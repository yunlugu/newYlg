<?php
/**
* 用户注册控制器
* @author monkeyWzr
* @date 2016/10/2
*/

namespace App\Http\Controllers;

use App\Attendize\Utils;
use App\Models\Account;
use App\Models\User;
use App\Models\Organiser;
use App\Models\Department;
use App\Models\Member;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Mail;
use Hash;
use JavaScript;
use DB;

class UserSignupController extends Controller
{
    protected $auth;

    public function __construct(Guard $auth)
    {
        if (Account::count() > 0 && !Utils::isAttendize()) {
            return redirect()->route('login');
        }

        $this->auth = $auth;
        $this->middleware('guest');
    }

    public function showSignup()
    {
        $is_attendize = Utils::isAttendize();
        JavaScript::put([
            'fetchDepartmentsRoute' => route('fetchDepartments', ['organiser_id' => 1]),
            'fetchGroupsRoute' => route('fetchGroups'),
        ]);
        return view('Public.LoginAndRegister.Signup', compact('is_attendize'));
    }

    /**
     * 创建账户
     *
     * @param Request $request
     *
     * @return Redirect
     */
    public function postSignup(Request $request)
    {
        $is_attendize = Utils::isAttendize();

        $this->validate($request, [
            'email'        => 'required|email|unique:members',
            'phone'        => 'required|unique:members',
            'password'     => 'required|min:5|confirmed',
            'full_name'   => 'required',
            // 'terms_agreed' => $is_attendize ? 'required' : '',
        ]);

        $organiser = Organiser::findOrfail(1);

        $account_data = $request->only(['email', 'full_name']);
        $account_data['currency_id'] = config('attendize.default_currency');
        $account_data['timezone_id'] = config('attendize.default_timezone');
        $account = Account::create($account_data);

        $member = new Member();
        $member_data = $request->only(['email', 'full_name']);
        $member_data['phone'] = $request->get('phone');
        $member_data['password'] = Hash::make($request->get('password'));
        $member_data['account_id'] = $account->id;
        $member_data['organiser_id'] = $organiser->id;
        $member_data['department_id'] = $request->get('department');
        $member_data['group_id'] = $request->get('group');
        $member_data['is_parent'] = 1;
        $member_data['is_registered'] = 1;
        $member = Member::create($member_data);

        if (1) {
            // TODO: Do this async?
            Mail::send('Emails.ConfirmEmail', ['api_token' => $member->api_token, 'full_name' => $member->full_name, 'confirmation_code' => $member->confirmation_code, 'email_logo' => $organiser->logo_path], function ($message) use ($request) {
                $message->to($request->get('email'), $request->get('full_name'))
                    ->subject('欢迎加入云麓谷大家庭');
            });
        }

        session()->flash('message', '注册成功！记着确认邮件哦！');

        return redirect()->route('showDanmakuPage');
    }

    /**
     * Confirm a user email
     *
     * @param $confirmation_code
     * @return mixed
     */
    public function confirmEmail($confirmation_code)
    {
        $member = Member::whereConfirmationCode($confirmation_code)->first();

        if (!$member) {
            return view('Public.Errors.Generic', [
                'message' => '验证码无效，请确认邮件后重试',
            ]);
        }

        $member->is_confirmed = 1;
        $member->confirmation_code = null;
        $member->save();

        session()->flash('message', '邮箱验证成功～');

        return redirect()->route('login');
    }

    public function test(){
        event(new \App\Events\CheckinEvent(3));
        $data['data'] = 'hello world';
        return view('test', $data);
    }

    public function fetchDepartments($organiser_id) {
        $departments = Organiser::find($organiser_id)->departments;
        // var_dump($departments);
        return response()->json($departments);
    }
    public function fetchGroups($department_id = 0) {
        $groups = Department::find($department_id)->groups;
        // var_dump($departments);
        return response()->json($groups);
    }
}
