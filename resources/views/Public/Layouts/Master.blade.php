<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>@yield('title')</title>
    @include('Shared.Layouts.ViewJavascript')
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
    {!!HTML::style('assets/stylesheet/application.css')!!}
    <link rel="stylesheet" type="text/css" href="{{url('css/bootstrap.min.css')}}" media="screen" />
    @yield('stylesheet')
    <style>
        .navbar-brand {
            /*padding: 10px 15px;*/
            padding: 0px;
        }
        .navbar-brand>img {
            /*padding: 10px 15px;*/
            height: 100%;
            padding: 2px;
            padding-left:  20px;
            width: auto;
        }
    </style>
</head>
<body class="bb-js">
    @yield('navbar')

    @yield('content')

    <div class="well container">
        <!-- <div style="float:right">
            <a href="https://weibo.com/yasengberg" class="twitter-share-button"   data-via="makeusabrew" data-related="makeusabrew" data-size="large">Weibo</a>

        </div> -->
        &copy; 2001-2016 <a href="http://www.yunlugu.org">云麓谷</a>.
    </div>
    <!-- JS dependencies -->
    <script type="text/javascript" src="{{url('vendor/jquery/dist/jquery.min.js')}}"></script>
    <script type="text/javascript" src="{{url('vendor/bootstrap/dist/js/bootstrap.min.js')}}"></script>
    @yield('script')
    {!!HTML::script('assets/javascript/backend.js')!!}
</body>
@include('Shared.Partials.GlobalFooterJS')
</html>
