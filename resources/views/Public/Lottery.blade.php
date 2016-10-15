@extends('Public.Layouts.Master')

@section('title')
    抽奖
@stop

@section('stylesheet')
    <link rel="stylesheet" type="text/css" href="{{url('plugins/danmaku/static/css/style.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{url('plugins/danmaku/dist/css/barrager.css')}}">
    <link rel="stylesheet" type="text/css" href="{{url('plugins/danmaku/static/pick-a-color/css/pick-a-color-1.2.3.min.css')}}">
    <link type="text/css" rel="stylesheet" href="{{url('plugins/danmaku/static/syntaxhighlighter/styles/shCoreDefault.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{url('plugins/WOW/css/libs/animate.css')}}">
    <link rel="stylesheet" href="{{url('plugins/WOW/css/site.css')}}">
    <style>
      .wow:first-child {
        visibility: hidden;
      }
    </style>
@stop

@section('navbar')
    @include('Public.Partials.Navbar')
@stop

@section('content')
<div id="container">
  <div id="main">
        <img width="80%" class="wow pulse" data-wow-iteration="infinite" data-wow-duration="1500ms" src="{{url('img/lulu.png')}}" alt="" />
    <br>
    <br>
    <br>
    <section id="lottery" class="wow bounceInLeft" data-wow-offset="300">
        <h1 id="lotteryText">云麓谷</h1>
        <button id="lotteryBtn" class="btn btn-large" type="button" name="button">点击文字开始</button>
        <button id="speedUpBtn" class="btn btn-large" type="button" name="button">はやく</button>
    </section>
  </div>
</div>

@stop

@section('script')
    <script type="text/javascript" src="{{url('plugins/danmaku/static/js/tinycolor-0.9.15.min.js')}}"></script>
    <script type="text/javascript" src="{{url('plugins/danmaku/dist/js/jquery.barrager.min.js')}}"></script>
    <script type="text/javascript" src="{{url('plugins/danmaku/static/syntaxhighlighter/scripts/shCore.js')}}"></script>
    <script type="text/javascript" src="{{url('plugins/danmaku/static/syntaxhighlighter/scripts/shBrushJScript.js')}}"></script>
    <script type="text/javascript" src="{{url('plugins/danmaku/static/syntaxhighlighter/scripts/shBrushPhp.js')}}"></script>
    <script type="text/javascript" src="{{url('plugins/danmaku/static/pick-a-color/js/pick-a-color-1.2.3.min.js')}}"></script>
    <script type="text/javascript" src="{{url('plugins/WOW/dist/wow.js')}}"></script>
    <script type="text/javascript">

    String.prototype.format = function(args) {
        var result = this;
        if (arguments.length < 1) {
            return result;
        }
        var data = arguments;
        if (arguments.length == 1 && typeof (args) == "object") {
            data = args;
        }
        for (var key in data) {
            var value = data[key];
            if (undefined != value) {
                result = result.replace("{" + key + "}", value);
            }
        }
        return result;
    }

    $(function() {

        SyntaxHighlighter.all();
        $(".pick-a-color").pickAColor();

        var  default_item={
                'img':newYlg.logo_path,
                'info':'云麓蛋！！！！！',
                'href':'http://www.yunlugu.org',
                'close':false,
                'speed':10,
                'bottom':300,
                'color':'red' ,
                'old_ie_color':'#000000'
            };
        $('body').barrager(default_item);

         //每条弹幕发送间隔
        var looper_time=3*1000;
        //是否首次执行
        var run_once=true;
       // do_barrager();

        function do_barrager(){
            if(run_once ){
                //如果是首次执行,则设置一个定时器,并且把首次执行置为false
                looper=setInterval(do_barrager,looper_time);
                run_once=false;
            }
        }

        function barrager(){

        }
    });

    function  clear_barrage(){
        $.fn.barrager.removeAll();
    }

    </script>

    <script type="text/javascript" src="{{url('js/jquery.serializejson.min.js')}}"></script>
    <script src="{{url('plugins/socket.io/node_modules/socket.io-client/socket.io.js')}}"></script>
    <script>
    var socket = io(newYlg.node_host);

    $('form').submit(function(){
        console.log($(this).serializeJSON())
    socket.emit('chat message', $(this).serializeJSON());
    // $('#m').val('');
    return false;
    });

    socket.on('chat message', function(danmaku) {
        var item={
               img:false, //图片
               info:danmaku.info, //文字
               // href:'http://www.yaseng.org', //链接
               close:false, //显示关闭按钮
               speed:danmaku.speed, //延迟,单位秒,默认6
               bottom:danmaku.bottomradio, //距离底部高度,单位px,默认随机
               color:danmaku.color, //颜色,默认白色
               old_ie_color:'#000000', //ie低版兼容色,不能与网页背景相同,默认黑色
          }
        $('body').barrager(item);
    })

 </script>
 <script>
 wow = new WOW(
   {
     animateClass: 'animated',
     offset:       100,
     callback:     function(box) {
       console.log("WOW: animating <" + box.tagName.toLowerCase() + ">")
     }
   }
 );
 wow.init();
 document.getElementById('lotteryText').onclick = function() {

   var attendees = JSON.parse(newYlg.attendees);
   var i = 0;
   $('#lotteryBtn').text('停止');
   $('#speedUpBtn').text($('#speedUpBtn').text() + '!');

   var handler = setInterval(function(){
    console.log(attendees[i].full_name);
       $('#lotteryText').text(attendees[i].full_name);
       i++;
       if (i===attendees.length) i = 0;
       $('#lotteryBtn').click(function(){
           clearInterval(handler);
           $('#lotteryBtn').text('点击文字开始');
           $('#speedUpBtn').text('はやく');
       })
   }, 100);

 };

 </script>
@stop
