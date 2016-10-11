<!DOCTYPE html>
<html>
  <!-- Html Head Tag-->
  <head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="John Doe">
  <!-- Open Graph Data -->
  <meta property="og:title" content="Hexo"/>
  <meta property="og:description" content="" />
  <meta property="og:site_name" content="Hexo"/>
  <meta property="og:type" content="website" />
  <meta property="og:image" content="http://yoursite.comundefined"/>

    <link rel="alternate" href="/atom.xml" title="Hexo" type="application/atom+xml">
    <link rel="icon" href="/favicon.png">

  <!-- Site Title -->
  <title>云麓谷</title>

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="{{url('css/bootstrap.min.css')}}">
  <!-- Custom CSS -->
  <link rel="stylesheet" href="{{url('css/style.light.css')}}">
  <link rel="stylesheet" type="text/css" href="{{url('plugins/danmaku/static/css/style.css')}}" />
  <link rel="stylesheet" type="text/css" href="{{url('plugins/danmaku/dist/css/barrager.css')}}">
  <link rel="stylesheet" type="text/css" href="{{url('plugins/danmaku/static/pick-a-color/css/pick-a-color-1.2.3.min.css')}}">
  <link type="text/css" rel="stylesheet" href="{{url('plugins/danmaku/static/syntaxhighlighter/styles/shCoreDefault.css')}}"/>
</head>

  <body>
    <!-- Page Header -->


<header class="site-header header-background" style="background-image: url({{url('img/default-banner-dark.jpg')}})">
  <div class="container">
    <div class="row">
      <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
        <div class="page-title with-background-image">
          <p class="title">云麓谷</p>
          <p class="subtitle"></p>
        </div>
        <div class="site-menu with-background-image">
          <ul>
              <li>
                <a href="/">
                  Home
                </a>
              </li>
              <li>
                <a href="/archives">
                  归档
                </a>
              </li>
              <li>
                <a href="https://github.com/yunlugu">
                  Github
                </a>
              </li>

              <li>
                <a href="#">
                  加入我们
                </a>
              </li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</header>


<!-- Home Page Post List -->
<div class="container">
    <canvas id="my_canvas" width="1000" height="1000"></canvas>
</div>

    <!-- Footer -->
<footer>
  <div class="container">
    <div class="row">
      <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
        <p class="copyright text-muted">
          Theme By <a target="_blank" href="https://github.com/levblanc">Levblanc.</a>
        <p class="copyright text-muted">
          Powered By <a target="_blank" href="https://ylg.csu.edu.cn/">云麓谷</a>
        </p>
      </div>
    </div>
  </div>
</footer>


    <!-- After Footer Scripts -->
<script src="{{url('/js/highlight.pack.js')}}"></script>
<script>
  document.addEventListener("DOMContentLoaded", function(event) {
    var codeBlocks = Array.prototype.slice.call(document.getElementsByTagName('pre'))
    codeBlocks.forEach(function(block, index) {
      hljs.highlightBlock(block);
    });
  });
</script>
{!! HTML::script('assets/javascript/wordcloud2.js') !!}

<script type="text/javascript">
    // WordCloud(document.getElementById('my_canvas'), {shape: 'circle', list: [['吴泽冉', 100], ['胡浩斌', 80], ['吴大屁', 40], ['胡大屎', 70]]} );
</script>
<script src="{{url('plugins/socket.io/node_modules/socket.io-client/socket.io.js')}}"></script>
  <!-- <script src="http://code.jquery.com/jquery-1.11.1.js"></script> -->
    <script type="text/javascript" src="{{url('plugins/danmaku/static/js/jquery-1.9.1.min.js')}}"></script>
  <script>
    var socket = io('http://localhost:6001');
    socket.on('connection', function (data) {
        console.log('this is data');
        console.log(data);
        console.log('end of data');
    });
    socket.on('checkin-channel:App\\Events\\CheckinEvent', function(message){
        // $('#messages').append($('<li>').text(message.user_id));
        var name_list = [];
        name_list = JSON.parse(message.name_list);
        var arr = $.map(name_list, function(el, key) { return [[key, el]] });
        WordCloud(document.getElementById('my_canvas'), {shape: 'circle', list: arr} );

    });
    console.log(socket);
  </script>

  <script type="text/javascript" src="{{url('plugins/danmaku/static/js/bootstrap.min.js')}}"></script>
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
  var  barrager_code=
      'var item={\n'+
      "   img:'{img}', //图片 \n"+
      "   info:'{info}', //文字 \n"+
      "   href:'{href}', //链接 \n"+
      "   close:{close}, //显示关闭按钮 \n"+
      "   speed:{speed}, //延迟,单位秒,默认6 \n"+
      "   bottom:{bottom}, //距离底部高度,单位px,默认随机 \n"+
      "   color:'{color}', //颜色,默认白色 \n"+
      "   old_ie_color:'{old_ie_color}', //ie低版兼容色,不能与网页背景相同,默认黑色 \n"+
      " }\n"+
      "$('body').barrager(item);"
      ;

  $(function() {

      SyntaxHighlighter.all();
      $(".pick-a-color").pickAColor();

      var  default_item={
              'img':'static/heisenberg.png',
              'info':'弹幕文字信息',
              'href':'http://www.yaseng.org',
              'close':true,
              'speed':6,
              'bottom':70,
              'color':'#fff' ,
              'old_ie_color':'#000000'
          };
      var item={'img':'static/img/heisenberg.png','href':'http://www.baidu.com','info':'Jquery.barrager.js 专业的网页弹幕插件'};
      //item1={'href':'http://www.baidu.com','info':'这是一条很长很长的字幕','close':false};
      $('#barrager-code').val(barrager_code.format(default_item));


      $('body').barrager(item);



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
          //获取
          $.getJSON('server.php?mode=1',function(data){
              //是否有数据
              if(data.info){

                   $('body').barrager(data);
              }

          });
      }

      function barrager(){



      }







  });

  function  run(){

      var  info=$('input[name=info]').val();
      (info == '' ) ?  info='请填写弹幕文字' : info=info;
      var  href=$('input[name=href]').val();
      var  speed=parseInt($('input[name=speed]').val());
      var  bottom=parseInt($('input[name=bottom]').val());
      var  code=barrager_code;
      if($('input:radio[name=bottomradio]:checked').val() == 0){
      var  window_height=$(window).height()-150;
      bottom=Math.floor(Math.random()*window_height+40);
      code=code.replace("   bottom:{bottom}, //距离底部高度,单位px,默认随机 \n",'');

      }

      var  img=$('input:radio[name=img]:checked').val();

      if   (img == 'none' ){

          code=code.replace("   img:'{img}', //图片 \n",'');
      }




      var  item={
              'img':'static/img/'+img,
              'info':info,
              'href':href,
              'close':true,
              'speed':speed,
              'bottom':bottom,
              'color':'#'+$('input[name=color').val(),
              'old_ie_color':'#'+$('input[name=color').val()



              };

       if(!$('input[name=close]').is(':checked')){


          item.close=false;


      }


      code=code.format(item);
      console.log(code);
      $('#barrager-code').val(code);
      eval(code);


  }

  function  clear_barrage(){

      $.fn.barrager.removeAll();
  }





  function  run_example(){

  var example_item={'img':'static/img/heisenberg.png','info':'Hello world!'};
  $('body').barrager(example_item);
  return false;

  }

  </script>
  </body>
</html>
