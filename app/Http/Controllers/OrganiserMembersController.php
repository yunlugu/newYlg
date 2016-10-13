<?php

// 用户管理控制器

namespace App\Http\Controllers;

use App\Jobs\SendAttendeeInvite;
use App\Jobs\SendAttendeeTicket;
use App\Jobs\SendMessageToAttendees;
use App\Jobs\GenerateTicket;
use App\Models\Attendee;
use App\Models\Account;
use App\Models\Member;
use App\Models\Organiser;
use App\Models\Event;
use App\Models\EventStats;
use App\Models\Message;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Auth;
use DB;
use Excel;
use Mail;
use Omnipay\Omnipay;
use PDF;
use Validator;
use Config;
use Log;
use Hash;
use JavaScript;

class OrganiserMembersController extends MyBaseController
{
    /**
     * Show the attendees list
     *
     * @param Request $request
     * @param $event_id
     * @return View
     */
    public function showMembers(Request $request, $organiser_id)
    {
        $allowed_sorts = ['full_name', 'email', 'created_at'];

        $searchQuery = $request->get('q');
        $sort_order = $request->get('sort_order') == 'asc' ? 'asc' : 'desc';
        $sort_by = (in_array($request->get('sort_by'), $allowed_sorts) ? $request->get('sort_by') : 'created_at');

        $organiser = Organiser::findOrfail($organiser_id);

        // $event = Event::scope()->find($event_id);

        if ($searchQuery) {
            $members = $organiser->members()
                ->where(function ($query) use ($searchQuery) {
                    $query->Where('members.full_name', 'like', $searchQuery . '%')
                        ->orWhere('members.email', 'like', $searchQuery . '%');
                })
                ->orderBy('members.' . $sort_by, $sort_order)
                ->select('*')
                ->paginate();
        } else {
            // 由于 Eloquent 提供“动态属性”，我们可以像访问模型的属性一样访问members()关联方法：
            $members = $organiser->members()
                ->orderBy('members.' . $sort_by, $sort_order)
                ->select('*')
                ->paginate();
        }

        $data = [
            'members'  => $members,
            'organiser'  => $organiser,
            'sort_by'    => $sort_by,
            'sort_order' => $sort_order,
            'q'          => $searchQuery ? $searchQuery : '',
        ];


        return view('ManageOrganiser.Members', $data);
    }

    /**
     * Show the 'Invite Attendee' modal
     *
     * @param Request $request
     * @param $event_id
     * @return string|View
     */
    public function showAddMember(Request $request, $organiser_id)
    {
        $organiser = Organiser::find($organiser_id);

        /*
         * If there are no tickets then we can't create an attendee
         * @todo This is a bit hackish
         */
        // if ($event->tickets->count() === 0) {
        //     return '<script>showMessage("You need to create a ticket before you can invite an attendee.");</script>';
        // }

        return view('ManageOrganiser.Modals.AddMember', [
            'organiser'   => $organiser,
            // 'tickets' => $event->tickets()->lists('title', 'id'),
        ]);
    }

    /**
     * Invite an attendee
     *
     * @param Request $request
     * @param $event_id
     * @return mixed
     */
    public function postAddMember(Request $request, $organiser_id)
    {
        $rules = [
            'full_name'   => 'required',
            'password'    => 'required|min:6',
            'email'        => 'required|email|unique:members,email,deleted_at',
        ];

        $messages = [
            'email.exists'   => '该邮箱已被注册',
            'email.required' => '请填写您的邮箱',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json([
                'status'   => 'error',
                'messages' => $validator->messages()->toArray(),
            ]);
        }

        $organiser = Organiser::find($organiser_id);

        DB::beginTransaction();

        try {

            /*
             * 创建用户
             */

            $account_data = $request->only(['email', 'full_name']);
            $account_data['currency_id'] = config('attendize.default_currency');
            $account_data['timezone_id'] = config('attendize.default_timezone');
            $account = Account::create($account_data);

            $member = new Member();
            $member_data = $request->only(['email', 'full_name']);
            $member_data['password'] = Hash::make($request->get('password'));
            $member_data['account_id'] = $account->id;
            $member_data['organiser_id'] = $organiser->id;
            $member_data['is_parent'] = 1;
            $member_data['is_registered'] = 1;
            // var_dump($member_data);
            $member = Member::create($member_data);

            // if ($email_attendee == '1') {
            //   $this->dispatch(new SendAttendeeInvite($attendee));
            // }

            session()->flash('message', '人员添加成功');

            DB::commit();

            return response()->json([
                'status'      => 'success',
                'redirectUrl' => route('showOrganiserMembers', [
                    'orgnaiser_id' => $organiser_id,
                ]),
            ]);

        } catch (Exception $e) {

            Log::error($e);
            DB::rollBack();

            return response()->json([
                'status' => 'error',
                'error'  => '添加出现错误，请重试',
            ]);
        }

    }

    /**
     * Show the 'Import Attendee' modal
     *
     * @param Request $request
     * @param $event_id
     * @return string|View
     */
    public function showImportAttendee(Request $request, $event_id)
    {
        $event = Event::scope()->find($event_id);

        /*
         * If there are no tickets then we can't create an attendee
         * @todo This is a bit hackish
         */
        if ($event->tickets->count() === 0) {
            return '<script>showMessage("You need to create a ticket before you can add an attendee.");</script>';
        }

        return view('ManageEvent.Modals.ImportAttendee', [
            'event'   => $event,
            'tickets' => $event->tickets()->lists('title', 'id'),
        ]);
    }


    /**
     * Import attendees
     *
     * @param Request $request
     * @param $event_id
     * @return mixed
     */
    public function postImportAttendee(Request $request, $event_id)
    {
        $rules = [
            'ticket_id'      => 'required|exists:tickets,id,account_id,' . \Auth::user()->account_id,
            'attendees_list' => 'required|mimes:csv,txt|max:5000|',
        ];

        $messages = [
            'ticket_id.exists' => 'The ticket you have selected does not exist',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return response()->json([
                'status'   => 'error',
                'messages' => $validator->messages()->toArray(),
            ]);

        }

        $ticket_id = $request->get('ticket_id');
        $ticket_price = 0;
        $email_attendee = $request->get('email_ticket');
        $num_added = 0;
        if ($request->file('attendees_list')) {

            $the_file = Excel::load($request->file('attendees_list')->getRealPath(), function ($reader) {
            })->get();

            // Loop through
            foreach ($the_file as $rows) {
                if (!empty($rows['first_name']) && !empty($rows['last_name']) && !empty($rows['email'])) {
                    $num_added++;
                    $attendee_first_name = $rows['first_name'];
                    $attendee_last_name = $rows['last_name'];
                    $attendee_email = $rows['email'];

                    error_log($ticket_id . ' ' . $ticket_price . ' ' . $email_attendee);


                    /**
                     * Create the order
                     */
                    $order = new Order();
                    $order->first_name = $attendee_first_name;
                    $order->last_name = $attendee_last_name;
                    $order->email = $attendee_email;
                    $order->order_status_id = config('attendize.order_complete');
                    $order->amount = $ticket_price;
                    $order->account_id = Auth::user()->account_id;
                    $order->event_id = $event_id;
                    $order->save();

                    /**
                     * Update qty sold
                     */
                    $ticket = Ticket::scope()->find($ticket_id);
                    $ticket->increment('quantity_sold');
                    $ticket->increment('sales_volume', $ticket_price);
                    $ticket->event->increment('sales_volume', $ticket_price);

                    /**
                     * Insert order item
                     */
                    $orderItem = new OrderItem();
                    $orderItem->title = $ticket->title;
                    $orderItem->quantity = 1;
                    $orderItem->order_id = $order->id;
                    $orderItem->unit_price = $ticket_price;
                    $orderItem->save();

                    /**
                     * Update the event stats
                     */
                    $event_stats = new EventStats();
                    $event_stats->updateTicketsSoldCount($event_id, 1);
                    $event_stats->updateTicketRevenue($ticket_id, $ticket_price);

                    /**
                     * Create the attendee
                     */
                    $attendee = new Attendee();
                    $attendee->first_name = $attendee_first_name;
                    $attendee->last_name = $attendee_last_name;
                    $attendee->email = $attendee_email;
                    $attendee->event_id = $event_id;
                    $attendee->order_id = $order->id;
                    $attendee->ticket_id = $ticket_id;
                    $attendee->account_id = Auth::user()->account_id;
                    $attendee->reference_index = 1;
                    $attendee->save();

                    if ($email_attendee == '1') {
                        $this->dispatch(new SendAttendeeInvite($attendee));
                    }
                }
            };
        }

        session()->flash('message', $num_added . ' Attendees Successfully Invited');

        return response()->json([
            'status'      => 'success',
            'id'          => $attendee->id,
            'redirectUrl' => route('showEventAttendees', [
                'event_id' => $event_id,
            ]),
        ]);
    }

    /**
     * Show the printable attendee list
     *
     * @param $event_id
     * @return View
     */
    public function showPrintAttendees($event_id)
    {
        $data['event'] = Event::scope()->find($event_id);
        $data['attendees'] = $data['event']->attendees()->withoutCancelled()->orderBy('first_name')->get();

        return view('ManageEvent.PrintAttendees', $data);
    }

    /**
     * Show the 'Message Attendee' modal
     *
     * @param Request $request
     * @param $attendee_id
     * @return View
     */
    public function showMessageMember(Request $request, $member_id)
    {
        $member = Member::scope()->findOrFail($member_id);

        $data = [
            'member' => $member,
            // 'event'    => $member->event,
        ];

        return view('ManageEvent.Modals.MessageMember', $data);
    }

    /**
     * Send a message to an attendee
     *
     * @param Request $request
     * @param $attendee_id
     * @return mixed
     */
    public function postMessageMember(Request $request, $member_id)
    {
        $rules = [
            'subject' => 'required',
            'message' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status'   => 'error',
                'messages' => $validator->messages()->toArray(),
            ]);
        }

        $member = Member::scope()->findOrFail($member_id);

        $data = [
            'member'        => $member,
            'message_content' => $request->get('message'),
            'subject'         => $request->get('subject'),
            // 'event'           => $member->event,
            'email_logo'      => $member->organiser->full_logo_path,
        ];

        //@todo move this to the SendAttendeeMessage Job
        Mail::send('Emails.messageAttendees', $data, function ($message) use ($member, $data) {
            $message->to($member->email, $member->full_name)
                ->from(config('attendize.outgoing_email_noreply'), $member->organiser->name)
                ->replyTo($member->organiser->email, $member->organiser->name)
                ->subject($data['subject']);
        });

        /* 给部门管理员发通知 */
        // if ($request->get('send_copy') == '1') {
        //     Mail::send('Emails.messageAttendees', $data, function ($message) use ($member, $data) {
        //         $message->to($member->organiser->email, $member->organiser->name)
        //             ->from(config('attendize.outgoing_email_noreply'), $member->organiser->name)
        //             ->replyTo($member->organiser->email, $member->organiser->name)
        //             ->subject($data['subject'] . '[ORGANISER COPY]');
        //     });
        // }

        return response()->json([
            'status'  => 'success',
            'message' => 'Message Successfully Sent',
        ]);
    }

    /**
     * Shows the 'Message Attendees' modal
     *
     * @param $event_id
     * @return View
     */
    public function showMessageAttendees(Request $request, $event_id)
    {
        $data = [
            'event'   => Event::scope()->find($event_id),
            'tickets' => Event::scope()->find($event_id)->tickets()->lists('title', 'id')->toArray(),
        ];

        return view('ManageEvent.Modals.MessageAttendees', $data);
    }

    /**
     * Send a message to attendees
     *
     * @param Request $request
     * @param $event_id
     * @return mixed
     */
    public function postMessageAttendees(Request $request, $event_id)
    {
        $rules = [
            'subject'    => 'required',
            'message'    => 'required',
            'recipients' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status'   => 'error',
                'messages' => $validator->messages()->toArray(),
            ]);
        }

        $message = Message::createNew();
        $message->message = $request->get('message');
        $message->subject = $request->get('subject');
        $message->recipients = ($request->get('recipients') == 'all') ? 'all' : $request->get('recipients');
        $message->event_id = $event_id;
        $message->save();

        /*
         * Queue the emails
         */
        $this->dispatch(new SendMessageToAttendees($message));

        return response()->json([
            'status'  => 'success',
            'message' => 'Message Successfully Sent',
        ]);
    }

    /**
     * Downloads the ticket of an attendee as PDF
     *
     * @param $event_id
     * @param $attendee_id
     */
    public function showExportTicket($event_id, $attendee_id)
    {
        $attendee = Attendee::scope()->findOrFail($attendee_id);

        Config::set('queue.default', 'sync');
        Log::info("*********");
        Log::info($attendee_id);
        Log::info($attendee);


        $this->dispatch(new GenerateTicket($attendee->order->order_reference."-".$attendee->reference_index));

        $pdf_file_name = $attendee->order->order_reference.'-'.$attendee->reference_index;
        $pdf_file_path = public_path(config('attendize.event_pdf_tickets_path')).'/'.$pdf_file_name;
        $pdf_file = $pdf_file_path.'.pdf';


        return response()->download($pdf_file);
    }

    /**
     * Downloads an export of attendees
     *
     * @param $event_id
     * @param string $export_as (xlsx, xls, csv, html)
     */
    public function showExportAttendees($event_id, $export_as = 'xls')
    {

        Excel::create('attendees-as-of-' . date('d-m-Y-g.i.a'), function ($excel) use ($event_id) {

            $excel->setTitle('Attendees List');

            // Chain the setters
            $excel->setCreator(config('attendize.app_name'))
                ->setCompany(config('attendize.app_name'));

            $excel->sheet('attendees_sheet_1', function ($sheet) use ($event_id) {

                DB::connection()->setFetchMode(\PDO::FETCH_ASSOC);
                $data = DB::table('attendees')
                    ->where('attendees.event_id', '=', $event_id)
                    ->where('attendees.is_cancelled', '=', 0)
                    ->where('attendees.account_id', '=', Auth::user()->account_id)
                    ->join('events', 'events.id', '=', 'attendees.event_id')
                    ->join('orders', 'orders.id', '=', 'attendees.order_id')
                    ->join('tickets', 'tickets.id', '=', 'attendees.ticket_id')
                    ->select([
                        'attendees.first_name',
                        'attendees.last_name',
                        'attendees.email',
                        'orders.order_reference',
                        'tickets.title',
                        'orders.created_at',
                        DB::raw("(CASE WHEN attendees.has_arrived THEN 'YES' ELSE 'NO' END) AS has_arrived"),
                        'attendees.arrival_time',
                    ])->get();

                $sheet->fromArray($data);
                $sheet->row(1, [
                    'First Name',
                    'Last Name',
                    'Email',
                    'Order Reference',
                    'Ticket Type',
                    'Purchase Date',
                    'Has Arrived',
                    'Arrival Time',
                ]);

                // Set gray background on first row
                $sheet->row(1, function ($row) {
                    $row->setBackground('#f5f5f5');
                });
            });
        })->export($export_as);
    }

    /**
     * Show the 'Edit Attendee' modal
     *
     * @param Request $request
     * @param $event_id
     * @param $attendee_id
     * @return View
     */
    public function showEditMember(Request $request, $organiser_id, $member_id)
    {
        $member = Member::findOrFail($member_id);

        $data = [
            'member' => $member,
            'organiser'    => $member->organiser,
            // 'departments' => $member->organiser->
        ];
        JavaScript::put([
            'fetchDepartmentsRoute' => route('fetchDepartments', ['organiser_id' => 1]),
            'fetchGroupsRoute' => route('fetchGroups'),
        ]);

        return view('ManageOrganiser.Modals.EditMember', $data);
    }

    /**
     * Updates an attendee
     *
     * @param Request $request
     * @param $event_id
     * @param $attendee_id
     * @return mixed
     */
    public function postEditMember(Request $request, $organiser_id, $member_id)
    {
        $rules = [
            'full_name' => 'required',
            // 'ticket_id'  => 'required|exists:tickets,id,account_id,' . Auth::user()->account_id,
            'email'      => 'required|email',
        ];

        $messages = [
            'ticket_id.exists'   => 'The ticket you have selected does not exist',
            'ticket_id.required' => 'The ticket field is required. ',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json([
                'status'   => 'error',
                'messages' => $validator->messages()->toArray(),
            ]);
        }

        $member = Member::findOrFail($member_id);
        $member->update($request->all());

        session()->flash('message', '用户信息已更新！');

        return response()->json([
            'status'      => 'success',
            'id'          => $member->id,
            'redirectUrl' => '',
        ]);
    }

    /**
     * Shows the 'Cancel Attendee' modal
     *
     * @param Request $request
     * @param $event_id
     * @param $attendee_id
     * @return View
     */
    public function showDeleteMember(Request $request, $organiser_id, $member_id)
    {
        $member = Member::findOrFail($member_id);

        $data = [
            'member' => $member,
            'organiser'    => $member->organiser,
            // 'tickets'  => $member->event->tickets->lists('title', 'id'),
        ];

        return view('ManageOrganiser.Modals.DeleteMember', $data);
    }

    /**
     * 删除用户（软删除）
     *
     * @param Request $request
     * @param $event_id
     * @param $attendee_id
     * @return mixed
     */
    public function postDeleteMember(Request $request, $organiser_id, $member_id)
    {
        $organiser = Organiser::findOrFail($organiser_id);

        $member = $organiser->members()->findOrFail($member_id);
        //是否已经软删除
        if ($member->trashed()) {
            return response()->json([
                'status'  => 'success',
                'message' => '已删除',
            ]);
        }

        $member->delete();

        session()->flash('message', '已删除该员工');

        return response()->json([
            'status'      => 'success',
            'id'          => $member->id,
            'redirectUrl' => '',
        ]);
    }

    /**
     * Show the 'Message Attendee' modal
     *
     * @param Request $request
     * @param $attendee_id
     * @return View
     */
    public function showResendTicketToAttendee(Request $request, $attendee_id)
    {
        $attendee = Attendee::scope()->findOrFail($attendee_id);

        $data = [
            'attendee' => $attendee,
            'event'    => $attendee->event,
        ];

        return view('ManageEvent.Modals.ResendTicketToAttendee', $data);
    }

    /**
     * Send a message to an attendee
     *
     * @param Request $request
     * @param $attendee_id
     * @return mixed
     */
    public function postResendTicketToAttendee(Request $request, $attendee_id)
    {
        $attendee = Attendee::scope()->findOrFail($attendee_id);

        $this->dispatch(new SendAttendeeTicket($attendee));

        return response()->json([
            'status'  => 'success',
            'message' => 'Ticket Successfully Resent',
        ]);
    }


    /**
     * Show an attendee ticket
     *
     * @param Request $request
     * @param $attendee_id
     * @return bool
     */
    public function showAttendeeTicket(Request $request, $attendee_id)
    {
        $attendee = Attendee::scope()->findOrFail($attendee_id);

        $data = [
            'order'     => $attendee->order,
            'event'     => $attendee->event,
            'tickets'   => $attendee->ticket,
            'attendees' => [$attendee],
            'css'       => file_get_contents(public_path('assets/stylesheet/ticket.css')),
            'image'     => base64_encode(file_get_contents(public_path($attendee->event->organiser->full_logo_path))),

        ];

        if ($request->get('download') == '1') {
            return PDF::html('Public.ViewEvent.Partials.PDFTicket', $data, 'Tickets');
        }
        return view('Public.ViewEvent.Partials.PDFTicket', $data);
    }

}
