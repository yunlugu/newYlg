<section id="share" class="container">
    <div class="row">
        <h1 class="section_head">
            分享～
        </h1>
    </div>
    <div class="row">
        <div class="col-md-12">
            <ul class="cnrrssb-buttons clearfix">

                @if($event->social_show_facebook)
                <li class="cnrrssb-weibo" >
                    <a target="_blank" rel="nofollow" href="http://v.t.sina.com.cn/share/share.php?appkey=3036462609&url={{$event->event_url}}&title={{urlencode($event->title)}}&pic={{url($event->organiser->logo_path)}}&searchPic=true" class="popup" >
                        <span class="cnrrssb-icon">
                            <i class="fa fa-weibo"></i>
                        </span>
                        <span class="cnrrssb-text">新浪微博</span>
                    </a>
                </li>

                @endif
                @if($event->social_show_linkedin)
                <li class="cnrrssb-qqstar"  >
                    <a target="_blank" rel="nofollow" href="http://sns.qzone.qq.com/cgi-bin/qzshare/cgi_qzshare_onekey?url={{$event->event_url}}&title={{urlencode($event->title)}}&desc=&summary=云麓谷——你有才能，我给空间～&site=&pics={{url($event->organiser->logo_path)}}" class="popup">
                        <span class="cnrrssb-icon">
                            <i class="fa fa-star"></i>
                        </span>
                        <span class="cnrrssb-text">QQ空间</span>
                    </a>
                </li>
                @endif
                @if($event->social_show_whatsapp)
                <li class="cnrrssb-qq" >
                <a target="_blank" rel="nofollow" href="http://connect.qq.com/widget/shareqq/index.html?url={{$event->event_url}}&title={{urlencode($event->title)}}&desc=&summary=云麓谷——你有才能，我给空间～&site=&pics={{url($event->organiser->logo_path)}}">
                    <span class="cnrrssb-icon">
                        <i class="fa fa-qq"></i>

                    </span>
                    <span class="cnrrssb-text">QQ好友</span>
                </a>
            </li>
                @endif
                @if($event->social_show_googleplus)
                <li class="cnrrssb-weixin" >
                <a target="_blank" rel="nofollow" class="jiathis_button_weixin" href="javascript:void(0);" onclick="js_method()">
                    <span class="cnrrssb-icon">
                        <i class="fa fa-weixin"></i>

                    </span>
                    <span class="cnrrssb-text">微信</span>
                </a>
            </li>
                @endif
                @if($event->social_show_twitter)
                <li class="cnrrssb-twitter">
                    <a href="http://twitter.com/intent/tweet?text=Check out: {{$event->event_url}} {{{Str::words(strip_tags($event->description), 20)}}}" class="popup">
                        <span class="cnrrssb-icon">
                            <i class="fa fa-twitter"></i>
                        </span>
                        <span class="cnrrssb-text">twitter</span>
                    </a>
                </li>
                @endif
                @if($event->social_show_email)
                <li class="cnrrssb-email">
                    <a href="mailto:?subject=Check This Out&body={{urlencode($event->event_url)}}">
                        <span class="cnrrssb-icon">
                            <i class="fa fa-at"></i>
                        </span>
                        <span class="cnrrssb-text">email</span>
                    </a>
                </li>
                @endif
            </ul>
        </div>
    </div>
</section>
