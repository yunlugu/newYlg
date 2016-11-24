<?php

namespace App\Http\Controllers;

use App\Attendize\Utils;
use App\Models\Affiliate;
use App\Models\Event;
use App\Models\EventStats;
use App\Models\Attendee;
use Auth;
use Cookie;
use Illuminate\Http\Request;
use Mail;
use Validator;
use JavaScript;

class PublicViewController extends Controller
{
    /**
     * Show the homepage for an event
     *
     * @param Request $request
     * @param $event_id
     * @param string $slug
     * @param bool $preview
     * @return mixed
     */
    public function showMainPage(Request $request) {
        return view('Public.MainPage');
    }

    public function showHomePage(Request $request) {
        return view('Public.HomePage');
    }

    public function showDanmakuPage(Request $request) {
        JavaScript::put([
            'logo_path' => url('assets/images/logo2.png'),
            'node_host' => env('NODE_HOST'),
        ]);
        return view('Public.Danmaku');
    }

    public function showLotteryPage(Request $request) {
        JavaScript::put([
            'logo_path' => url('assets/images/logo2.png'),
            'node_host' => env('NODE_HOST'),
            'attendees' => Attendee::get()->toJson(),
        ]);
        return view('Public.Lottery');
    }

    public function postDanmaku(Request $request) {
        $danmaku = $request->all();
        event(new \App\Events\CheckinEvent(json_encode($danmaku,JSON_UNESCAPED_UNICODE)));
        return reponse()->json([
            'status'  => 'success',
            'message' => '已发射',
        ]);
    }


}
