@extends('Public.Layouts.Master')

@section('title')
    云麓蛋
@stop

@section('stylesheet')
    <link rel="stylesheet" type="text/css" href="{{url('plugins/danmaku/static/css/style.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{url('plugins/danmaku/dist/css/barrager.css')}}">
    <link rel="stylesheet" type="text/css" href="{{url('plugins/danmaku/static/pick-a-color/css/pick-a-color-1.2.3.min.css')}}">
    <link type="text/css" rel="stylesheet" href="{{url('plugins/danmaku/static/syntaxhighlighter/styles/shCoreDefault.css')}}"/>
@stop

@section('navbar')
    @include('Public.Partials.Navbar')
@stop

@section('content')
    <div id="content" class="bb-docs-header" tabindex="-1">
        <div class="container text-center">
            <div class="bb-masthead">
                <h1>云麓蛋</h1>
                <p>
                    dàn ?? tán ??
                </p>
            </div>
        </div>
    </div>
    <div class="container">
        {!! Form::open(array('class' => '')) !!}
        <section class="bb-section">
            <div class="lead-top">
                <div class="text-center">
                    <div class="row">
                        <div class="col-md-6 col-md-offset-3">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="发射弹幕">
                                <span class="input-group-btn">
                                    <button  class="btn btn-success"> 发射！</button>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section id="custom" class="bb-section">
            <div class="page-header">
                <h2>自定义</h2>
            </div>
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                        <div class="form-group">
                            <label for="" >速度</label>
                            <input  class="form-control"  name="speed" type="text" placeholder="10" value="10" />
                        </div>
                        <div class="row">
                            <div class="form-group">
                                <div class="col-md-3">
                                    <label >高度</label>
                                    <input id="bottomradio" type="radio" name="bottomradio"   value="0" checked="checked"> 随机

                                </div>
                                <div class="col-md-3">
                                    <input type="radio" name="bottomradio" value="1" > 设置
                                    <input class="form-control" name="bottom" type="text" placeholder="250"  value="250"   />
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="color" >颜色</label>
                            <input id="color" type="text" value="fff" name="color" class="pick-a-color form-control">
                        </div>
                        <!-- <button type="submit" class="btn btn-primary bb-light-blue"> 运行</button> -->
                        <button  class="btn btn-warning" onclick="clear_barrage()"> 清除</button>
                    {!! Form::close() !!}
                </div>
            </div>
        </section>
    </div>

@stop

@section('script')
    <script type="text/javascript" src="{{url('plugins/danmaku/static/js/tinycolor-0.9.15.min.js')}}"></script>
    <script type="text/javascript" src="{{url('plugins/danmaku/dist/js/jquery.barrager.min.js')}}"></script>
    <script type="text/javascript" src="{{url('plugins/danmaku/static/syntaxhighlighter/scripts/shCore.js')}}"></script>
    <script type="text/javascript" src="{{url('plugins/danmaku/static/syntaxhighlighter/scripts/shBrushJScript.js')}}"></script>
    <script type="text/javascript" src="{{url('plugins/danmaku/static/syntaxhighlighter/scripts/shBrushPhp.js')}}"></script>
    <script type="text/javascript" src="{{url('plugins/danmaku/static/pick-a-color/js/pick-a-color-1.2.3.min.js')}}"></script>
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
                'img':Attendize.logo_path,
                'info':'云麓蛋！！！！！',
                'href':'http://www.yunlugu.org',
                'close':false,
                'speed':10,
                'bottom':300,
                'color':'#fff' ,
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
    <!-- <script src="http://code.jquery.com/jquery-1.11.1.js"></script> -->
    <script>
    var socket = io('http://localhost:3000');

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
@stop
