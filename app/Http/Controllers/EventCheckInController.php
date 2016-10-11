<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendee;
use App\Models\Member;
use App\Models\Event;
use Carbon\Carbon;
use DB;
use JavaScript;

class EventCheckInController extends MyBaseController
{
    /**
     * Show the check-in page
     *
     * @param $event_id
     * @return \Illuminate\View\View
     */
    public function showCheckIn($event_id)
    {

        $event = Event::scope()->findOrFail($event_id);

        $data = [
            'event'     => $event,
            'attendees' => $event->attendees
        ];

        JavaScript::put([
            'qrcodeCheckInRoute' => route('postQRCodeCheckInAttendee', ['event_id' => $event->id]),
            'checkInRoute'       => route('postCheckInAttendee', ['event_id' => $event->id]),
            'checkInSearchRoute' => route('postCheckInSearch', ['event_id' => $event->id]),
        ]);

        return view('ManageEvent.CheckIn', $data);
    }

    public function showQRCodeModal(Request $request, $event_id)
    {
        return view('ManageEvent.Modals.QrcodeCheckIn');
    }

    /**
     * Search attendees
     *
     * @param Request $request
     * @param $event_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function postCheckInSearch(Request $request, $event_id)
    {
        $searchQuery = $request->get('q');

        $attendees = Attendee::withoutCancelled()
            ->where(function ($query) use ($event_id) {
                $query->where('attendees.event_id', '=', $event_id);
            })->where(function ($query) use ($searchQuery) {
                $query->orWhere('attendees.full_name', 'like', $searchQuery . '%')
                    ->orWhere('attendees.email', 'like', $searchQuery . '%');
            })
            ->select([
                'attendees.id',
                'attendees.full_name',
                'attendees.email',
                'attendees.arrival_time',
                'attendees.has_arrived',
            ])
            ->orderBy('attendees.full_name', 'ASC')
            ->get();

        return response()->json($attendees);
    }

    /**
     * Check in/out an attendee
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postCheckInAttendee(Request $request)
    {
        $attendee_id = $request->get('attendee_id');
        $checking = $request->get('checking');

        $attendee = Attendee::scope()->find($attendee_id);

        /*
         * Ugh
         */
        if ((($checking == 'in') && ($attendee->has_arrived == 1)) || (($checking == 'out') && ($attendee->has_arrived == 0))) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Attendee Already Checked ' . (($checking == 'in') ? 'In (at ' . $attendee->arrival_time->format('H:i A, F j') . ')' : 'Out') . '!',
                'checked' => $checking,
                'id'      => $attendee->id,
            ]);
        }

        $attendee->has_arrived = ($checking == 'in') ? 1 : 0;
        $attendee->arrival_time = Carbon::now();
        $attendee->save();

        return response()->json([
            'status'  => 'success',
            'checked' => $checking,
            'message' => 'Attendee Successfully Checked ' . (($checking == 'in') ? 'In' : 'Out'),
            'id'      => $attendee->id,
        ]);
    }


    /**
     * Check in an attendee
     *
     * @param $event_id
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postCheckInAttendeeQr($event_id, Request $request)
    {
        //思路：使用个人二维码签到，插入新一条记录，而不是验证已经报名的。

        $event = Event::scope()->findOrFail($event_id);

        $qrcodeToken = $request->get('attendee_reference');
        $member = Member::where('api_token',  $qrcodeToken)->firstOrFail();

        $attendee = new Attendee();
        $attendee_data['event_id'] = $event->id;
        $attendee_data['member_id'] = $member->id;
        $attendee_data['full_name'] = $member->full_name;
        $attendee_data['has_arrived'] = 1;
        $attendee_data['private_reference_number'] = $qrcodeToken;
        $attendee_data['email'] = $member->email;
        $attendee = Attendee::create($attendee_data);

        if (is_null($attendee)) {
            return response()->json([
                'status'  => 'error',
                'message' => "Invalid Ticket! Please try again."
            ]);
        }

        $attendees = $event->attendees()->get(['full_name']);
        $name_list = array();
        foreach ($attendees as $key => $value) {
            $name = $value['full_name'];
            $name_list["$name"] = mt_rand(10,100);
        }
        // var_dump($attendees);
        event(new \App\Events\CheckinEvent(json_encode($name_list,JSON_UNESCAPED_UNICODE)));

        return response()->json([
            'status'  => 'success',
            'message' => 'Success !<br>Name: ' . $member->full_name . '<br>email: ' . $attendee->email
        ]);

    }

    /**
     * Confirm tickets of same order.
     *
     * @param $event_id
     * @param $order_id
     * @return \Illuminate\Http\Response
     */
    public function confirmOrderTicketsQr($event_id, $order_id)
    {
        $updateRowsCount = Attendee::scope()->where([
            'event_id'    => $event_id,
            'order_id'    => $order_id,
            'has_arrived' => 0,
        ])->update([
            'has_arrived'  => 1,
            'arrival_time' => Carbon::now(),
        ]);

        return response()->json([
            'message' => $updateRowsCount . ' Attendee(s) Checked in.'
        ]);
    }

}
