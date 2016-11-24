<!DOCTYPE html>
<html>

  <head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Clean</title>
  <meta name="description" content="Write an awesome description for your new site here. You can edit this line in _config.yml.
">
  <link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro:600' rel='stylesheet' type='text/css'>
  <link href='https://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
  <link rel="stylesheet" href="{{url('css/main.css')}}">
  <link rel="stylesheet" type="text/css" href="{{url('plugins/WOW/css/libs/animate.css')}}">
  <!-- <link rel="stylesheet" type="text/css" href="{{url('plugins/textillate/css/libs/animate.css')}}"> -->
  <link rel="canonical" href="http://yourdomain.com/clean/">
  <link rel="alternate" type="application/rss+xml" title="Clean" href="http://yourdomain.com/clean/feed.xml" />
</head>


  <body>

    <div class="cover">
      <div class="clock"></div>
      <div class='hours'></div>
      <div class='seconds'></div>
      <div class='minutes'></div>
      <div class="site-name">
        <div class="site-name__inner">
          <div class="name">云麓谷</div>
          <div class="desc">你有才能，我给空间
          </div>
          <div class="btn">大事纪</div>
        </div>
      </div>
    </div>

    <!-- <header class="site-header">

      <div class="wrapper">

        <nav class="site-nav">

              <a class="page-link" href="/clean/about/">About</a>

        </nav>
      </div>
    </header> -->
<script type="text/javascript" src="{{url('vendor/jquery/dist/jquery.min.js')}}"></script>
<script type="text/javascript" src="{{url('plugins/WOW/dist/wow.js')}}"></script>
<script type="text/javascript" src="{{url('plugins/textillate/assets/jquery.lettering.js')}}"></script>
<script type="text/javascript" src="{{url('plugins/textillate/jquery.textillate.js')}}"></script>
<script>
    $(function () {
        $('.desc').textillate({
            loop: true,
            in: {
                effect: 'flip',
                delayScale: 1.5,
                delay: 100,
                sync: false,
                shuffle: false,
                reverse: false,
            },
            out: {
                effect: 'flipOutX',
                delayScale: 2,
                delay: 50,
                sync: false,
                shuffle: false,
                reverse: false,
            }
        });
    })
</script>
<script>
  setInterval(function() {
    var seconds = new Date().getSeconds();
    var sdegree = seconds * 6 + 270;
    seconds = ("0" + seconds).slice(-2);
    var secondSel = document.querySelector(".seconds");

    secondSel.style.transform = "rotate(" + sdegree + "deg) translate(160px) rotate(-" + sdegree + "deg)";
    secondSel.innerHTML = seconds;

    var minutes = new Date().getMinutes();
    var mdegree = minutes * 6 + 270;
    var minutesSel = document.querySelector(".minutes");
    minutes = ("0" + minutes).slice(-2);

    minutesSel.style.transform = "rotate(" + mdegree + "deg) translate(181px) rotate(-" + mdegree + "deg)";
    minutesSel.innerHTML =  minutes;

    var hours = new Date().getHours();
    var hoursSel = document.querySelector(".hours");

    if (hours > 12) {
      hours = hours - 12;
    }

    hours = ("0" + hours).slice(-2);

    hoursSel.innerHTML = hours;
  }, 1000);

  var btnSel = document.querySelector('.btn');
  var header = document.getElementsByTagName('header')[0];

  btnSel.addEventListener("click", function() {
    header.scrollIntoView();
  }, false);

</script>

  </body>

</html>
