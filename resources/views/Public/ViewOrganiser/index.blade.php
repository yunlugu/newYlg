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
                <a href="http://www.yunlugu.org/danmaku">
                  Home
                </a>
              </li>
              <!-- <li>
                <a href="#">
                  归档
                </a>
              </li> -->
              <li>
                <a href="https://github.com/yunlugu">
                  Github
                </a>
              </li>

              <!-- <li>
                <a href="#">
                  加入我们
                </a>
              </li> -->
          </ul>
        </div>
      </div>
    </div>
  </div>
</header>


<!-- Home Page Post List -->
<div class="container">
    @if(count($upcoming_events))
        <div class="row">
          <div class="col-lg-10 col-md-10 col-md-offset-1">
            @foreach($upcoming_events as $event)
              <div class="post-item-wrapper">
                <a href="{{url('e/' . $event->id)}}" class="post-title">
                    {{$event->title}}
                </a>
                <div class="post-excerpt">
                    <!-- Post Date and Categories -->
                    <div class="date-and-category">
                        <div class="date">{{$event->start_date->format('Y-m-d H:i')}}</div>
                        <div class="speaker">
                            <a href="#">{{$event->speaker}}</a>
                        </div>
                        <div class="categories">
                            <a href="#">{{$event->department->department_name}}</a>
                        </div>
                    </div>
                    <!-- Post Excerpt -->
                    <div class="excerpt typo">{{$event->description}}
                        <div class="alert alert-info"><span class="glyphicon glyphicon-map-marker" aria-hidden="true"></span>@if($event->location_is_manual){{$event->venue_name}}@else{{$event->location_name}}@endif</div>
                    </div>
                    <!-- Post Tags -->
                    <div class="tags">
                    @if(!empty($event->tags))
                        @foreach(explode(',', $event->tags) as $tag)
                        <a class="tag" href="#">{{$tag}}</a>
                        @endforeach
                    @endif
                    </div>
                </div>
            </div>
            @endforeach
            </div>
        </div>
    @else
        <div class="alert alert-info">
            没有培训.
        </div>
    @endif
</div>

<!-- Pagination -->
<div class="container">
  <div class="row">
    <div class="col-lg-10 col-md-10 col-md-offset-1">
      <ul class="pagination">


      </ul>
    </div>
  </div>
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

  </body>
</html>
