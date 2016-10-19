@extends('Shared.Layouts.Master')

@section('title')
    @parent
    控制面板
@stop


@section('top_nav')
    @include('ManageEvent.Partials.TopNav')
@stop

@section('page_title', '<i class="ico-home2"></i>&nbsp;控制面板')

@section('menu')
    @include('ManageEvent.Partials.Sidebar')
@stop

@section('head')
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css" />
    <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
    <script>
        $(function () {
            $.getJSON('http://graph.facebook.com/?id=' + '{{route('showEventPage',['event_id' => $event->id, 'event_slug' => Str::slug($event->title)])}}', function (fbdata) {
                $('#facebook-count').html(fbdata.shares);
            });
        });
    </script>

    <style>
        svg {
            width: 100% !important;
        }
    </style>
@stop

@section('content')
    <div class="row">
        <!-- <div class="col-sm-3">
            <div class="stat-box">
                <h3>{{ money($event->sales_volume + $event->organiser_fees_volume, $event->currency) }}</h3>
                <span>Sales Volume</span>
            </div>
        </div> -->
        <div class="col-sm-4">
            <div class="stat-box">
                <h3>{{ $event->attendees->count() }}</h3>
                <span>报名</span>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="stat-box">
                <h3>{{ $event->attendees->count() }}</h3>
                <span>签到</span>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="stat-box">
                <h3>{{ $event->stats->sum('views') }}</h3>
                <span>总浏览量</span>
            </div>
        </div>

        <!-- May be implemented soon.
        <div class="col-sm-3 hide">
            <div class="stat-box">
                <h3 id="facebook-count">0</h3>
                <span>Facebook Shares</span>
            </div>
        </div>
        -->
    </div>

    <div class="row">
        <div class="col-md-9 col-sm-6">
            <div class="row">

                <div class="col-md-6">
                    <div class="panel">
                        <div class="panel-heading panel-default">
                            <h3 class="panel-title">
                                签到情况
                                <span style="color: green; float: right;">
                                    {{$event->attendees->count()}} Total
                                </span>
                            </h3>
                        </div>
                        <div class="panel-body">
                            <div class="chart-wrap">
                                <div style="height: 200px;" class="statChart" id="theChart3"></div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="panel">
                        <div class="panel-heading panel-default">
                            <h3 class="panel-title">
                                培训详情页浏览量
                                <span style="color: green; float: right;">
                                    {{$event->stats->sum('views')}} Total
                                </span>
                            </h3>
                        </div>
                        <div class="panel-body">
                            <div class="chart-wrap">
                                <div style="height: 200px;" class="statChart" id="theChart2"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="panel">
                        <div class="panel-heading panel-default">
                            <h3 class="panel-title">
                                还没想好是啥{{$event->stats->sum('views')}} Total
                            </h3>
                        </div>
                        <div class="panel-body">
                            <div class="chart-wrap">
                                <div style="height:200px;" class="statChart" id="pieChart"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="col-md-3 col-sm-6">
            <div class="panel panel-success ticket">
                <div class="panel-body">
                    <i class="ico ico-clock"></i>
                    @if($event->happening_now)
                        培训已开始
                    @else
                        <span id="countdown"></span>
                    @endif
                </div>
            </div>
            <div class="panel panel-success">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <i class="ico-link mr5 ellipsis"></i>
                        培训详情页链接
                    </h3>
                </div>

                <div class="panel-body">
                    {!! Form::input('text', 'front_end_url', $event->event_url, ['class' => 'form-control', 'onclick' => 'this.select();']) !!}
                </div>

            </div>
            <div class="panel panel-success">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <i class="ico-share mr5 ellipsis"></i>
                        分享
                    </h3>
                </div>

                <div class="panel-body">
                    <ul class="cnrrssb-buttons clearfix">
                        <li class="cnrrssb-weibo" >
                            <a target="_blank" rel="nofollow" href="http://v.t.sina.com.cn/share/share.php?appkey=3036462609&url={{$event->event_url}}&title={{urlencode($event->title)}}&pic={{url($event->organiser->logo_path)}}&searchPic=true" class="popup" >
                                <span class="cnrrssb-icon">
                                    <i class="fa fa-weibo"></i>
                                </span>
                                <span class="cnrrssb-text">新浪微博</span>
                            </a>
                        </li>
                        <li class="cnrrssb-qqstar"  >
                            <a target="_blank" rel="nofollow" href="http://sns.qzone.qq.com/cgi-bin/qzshare/cgi_qzshare_onekey?url={{$event->event_url}}&title={{urlencode($event->title)}}&desc=&summary=云麓谷——你有才能，我给空间～&site=&pics={{url($event->organiser->logo_path)}}" class="popup">
                                <span class="cnrrssb-icon">
                                    <i class="fa fa-star"></i>
                                </span>
                                <span class="cnrrssb-text">QQ空间</span>
                            </a>
                        </li>
                        <li class="cnrrssb-qq" >
                        <a target="_blank" rel="nofollow" href="http://connect.qq.com/widget/shareqq/index.html?url={{$event->event_url}}&title={{urlencode($event->title)}}&desc=&summary=云麓谷——你有才能，我给空间～&site=&pics={{url($event->organiser->logo_path)}}">
                            <span class="cnrrssb-icon">
                                <i class="fa fa-qq"></i>

                            </span>
                            <span class="cnrrssb-text">QQ好友</span>
                        </a>
                    </li>
                        <li class="cnrrssb-weixin" >
                        <a target="_blank" rel="nofollow" class="jiathis_button_weixin" href="javascript:void(0);" onclick="js_method()">
                            <span class="cnrrssb-icon">
                                <i class="fa fa-weixin"></i>

                            </span>
                            <span class="cnrrssb-text">微信</span>
                        </a>
                    </li>
                        <li class="cnrrssb-twitter">
                            <a href="http://twitter.com/intent/tweet?text=Check out: {{$event->event_url}} {{{Str::words(strip_tags($event->description), 20)}}}" class="popup">
                                <span class="cnrrssb-icon">
                                    <i class="fa fa-twitter"></i>
                                </span>
                                <span class="cnrrssb-text">twitter</span>
                            </a>
                        </li>
                        <li class="cnrrssb-email">
                            <a href="mailto:?subject=Check This Out&body={{urlencode($event->event_url)}}">
                                <span class="cnrrssb-icon">
                                    <i class="fa fa-at"></i>
                                </span>
                                <span class="cnrrssb-text">email</span>
                            </a>
                        </li>
                    </ul>
                </div>

            </div>

            <div class="panel panel-success hide">

                <div class="panel-heading">
                    <h3 class="panel-title">
                        <i class="ico-link mr5 ellipsis"></i>
                        Quick Links
                    </h3>
                </div>

                <div class="panel-body">

                    <a href="" class="btn-link btn">
                        Edit Event Page Design <i class="ico ico-arrow-right3"></i>
                    </a>
                    <a href="" class="btn-link btn">
                        Create Tickets <i class="ico ico-arrow-right3"></i>
                    </a>
                    <a href="" class="btn-link btn">
                        Website Embed Code <i class="ico ico-arrow-right3"></i>
                    </a>
                    <a href="" class="btn-link btn">
                        Generate Affiliate Link <i class="ico ico-arrow-right3"></i>
                    </a>
                    <a href="" class="btn-link btn">
                        Edit Organiser Fees <i class="ico ico-arrow-right3"></i>
                    </a>
                </div>

            </div>
        </div>
    </div>

    <script>

        var chartData = {!! $chartData  !!};
        var ticketData = {!! $ticketData  !!};



        new Morris.Donut({
            element: 'pieChart',
            data: ticketData,
        });

        new Morris.Line({
            element: 'theChart3',
            data: chartData,
            xkey: 'date',
            ykeys: ['sales_volume'],
            labels: ['Sales Volume'],
            xLabels: 'day',
            xLabelAngle: 30,
            yLabelFormat: function (x) {
                return '{!! $event->currency_symbol !!} ' + x;
            },
            xLabelFormat: function (x) {
                return formatDate(x);
            }
        });
        new Morris.Line({
            element: 'theChart2',
            data: chartData,
            xkey: 'date',
            //ykeys: ['views', 'unique_views'],
            //labels: ['Event Page Views', 'Unique views'],
            ykeys: ['views'],
            labels: ['Event Page Views'],
            xLabels: 'day',
            xLabelAngle: 30,
            xLabelFormat: function (x) {
                return formatDate(x);
            }
        });
        new Morris.Line({
            element: 'theChart',
            data: chartData,
            xkey: 'date',
            ykeys: ['tickets_sold'],
            labels: ['Tickets sold'],
            xLabels: 'day',
            xLabelAngle: 30,
            lineColors: ['#0390b5', '#0066ff'],
            xLabelFormat: function (x) {
                return formatDate(x);
            }
        });
        function formatDate(x) {
            var m_names = new Array("Jan", "Feb", "Mar",
                    "Apr", "May", "Jun", "Jul", "Aug", "Sep",
                    "Oct", "Nov", "Dec");
            var sup = "",
                    curr_date = x.getDate();
            if (curr_date == 1 || curr_date == 21 || curr_date == 31) {
                sup = "st";
            }
            else if (curr_date == 2 || curr_date == 22) {
                sup = "nd";
            }
            else if (curr_date == 3 || curr_date == 23) {
                sup = "rd";
            }
            else {
                sup = "th";
            }

            return curr_date + sup + ' ' + m_names[x.getMonth()];
        }

        var target_date = new Date("{{$event->start_date->format('M')}} {{$event->start_date->format('d')}}, {{$event->start_date->format('Y')}} {{$event->start_date->format('H')}}:{{$event->start_date->format('i')}} ").getTime();
        var now = new Date();
        var countdown = document.getElementById("countdown");
        if (target_date < now) {
            countdown.innerHTML = 'This event has started.';
        } else {

            var days, hours, minutes, seconds;
            setCountdown();
            setInterval(function () {
                setCountdown();
            }, 30000);
            function setCountdown() {
                var current_date = new Date().getTime();
                var seconds_left = (target_date - current_date) / 1000;
                // do some time calculations
                days = parseInt(seconds_left / 86400);
                seconds_left = seconds_left % 86400;
                hours = parseInt(seconds_left / 3600);
                seconds_left = seconds_left % 3600;
                minutes = parseInt(seconds_left / 60);
                // format countdown string + set tag value
                countdown.innerHTML = (days > 0 ? '<b>' + days + "</b> days<b> " : '') + (hours > 0 ? hours + " </b>hours<b> " : '') + (minutes > 0 ? minutes + "</b> minutes" : '');
            }
        }

    </script>
@stop
