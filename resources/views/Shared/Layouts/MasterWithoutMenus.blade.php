<html>
    <head>

        <title>@yield('title')</title>

        @include('Shared/Layouts/ViewJavascript')

        @include('Shared.Partials.GlobalMeta')

        @yield('head')

        <!--JS-->
        {!! HTML::script('vendor/vue/dist/vue.min.js') !!}
        {!! HTML::script('vendor/vue-resource/dist/vue-resource.min.js') !!}

       {!! HTML::script('vendor/jquery/dist/jquery.min.js') !!}
        <!--/JS-->

        <!--Style-->
       {!!HTML::style('assets/stylesheet/application.css')!!}
       <link href="//cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
        <!--/Style-->

        <style>

            body {
                background: url({{asset('assets/images/background2.png')}}) no-repeat center center fixed;
                background-color: #2E3254;
                -webkit-background-size: cover;
                -moz-background-size: cover;
                -o-background-size: cover;
                background-size: cover;
            }

            h2 {
                text-align: center;
                margin-bottom: 31px;
                text-transform: uppercase;
                letter-spacing: 4px;
                font-size: 23px;
            }
            .panel {
                background-color: #ffffff;
                background-color: rgba(255,255,255,.95);
                padding: 15px 30px ;
                border: none;
                color: #333;
                box-shadow: 0 0 5px 0 rgba(0,0,0,.2);
                margin-top: 40px;
            }

            .panel a {
                color: #333;
                font-weight: 600;
            }

            .logo {
                text-align: center;
                margin-bottom: 20px;
            }

            .logo img {
                width: 200px;
            }

            .signup {
                margin-top: 10px;
            }

            .forgotPassword {
                font-size: 12px;
                color: #ccc;
            }
        </style>
    </head>
    <body>
        <section id="main" role="main">
            <section class="container">
                @yield('content')
            </section>

        </section>
        <div style="text-align: center; color: white" >
        </div>

        {!!HTML::script('assets/javascript/backend.js')!!}
    </body>
    @include('Shared.Partials.GlobalFooterJS')

</html>
