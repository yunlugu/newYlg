<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link href='http://fonts.googleapis.com/css?family=PT+Sans:400,700' rel='stylesheet' type='text/css'>

    <title>
        @section('title')
            云麓谷 ::
        @show
    </title></head>
    @include('Shared.Layouts.ViewJavascript')
    <!--Meta-->
    @include('Shared.Partials.GlobalMeta')
   <!--/Meta-->

    <!--JS-->
    {!! HTML::script(config('attendize.cdn_url_static_assets').'/vendor/jquery/dist/jquery.min.js') !!}
    {!! HTML::script(config('attendize.cdn_url_static_assets').'/assets/javascript/modernizr.js') !!}
    <!--/JS-->

    <!--Style-->
    <!-- {!! HTML::style(config('attendize.cdn_url_static_assets').'/assets/stylesheet/application.css') !!} -->
    {!! HTML::style(config('attendize.cdn_url_static_assets').'/assets/stylesheet/reset.css') !!}
    {!! HTML::style(config('attendize.cdn_url_static_assets').'/assets/stylesheet/style.css') !!}
    <!--/Style-->

    @yield('head')
</head>

<body>
	<header role="banner">
		<div id="cd-logo"><a href="#0"><img src="img/cd-logo.svg" alt="Logo"></a></div>

		<nav class="main-nav">
			<ul>
				<!-- inser more links here -->
				<li><a class="cd-signin" href="#0">Sign in</a></li>
				<li><a class="cd-signup" href="#0">Sign up</a></li>
			</ul>
		</nav>
	</header>

	<div class="cd-user-modal"> <!-- this is the entire modal form, including the background -->
		<div class="cd-user-modal-container"> <!-- this is the container wrapper -->
			<ul class="cd-switcher">
				<li><a href="#0">Sign in</a></li>
				<li><a href="#0">New account</a></li>
			</ul>

			<div id="cd-login"> <!-- log in form -->
				<form class="cd-form">
					<p class="fieldset">
						<label class="image-replace cd-email" for="signin-email">E-mail</label>
						<input class="full-width has-padding has-border" id="signin-email" type="email" placeholder="E-mail">
						<span class="cd-error-message">Error message here!</span>
					</p>

					<p class="fieldset">
						<label class="image-replace cd-password" for="signin-password">Password</label>
						<input class="full-width has-padding has-border" id="signin-password" type="text"  placeholder="Password">
						<a href="#0" class="hide-password">Hide</a>
						<span class="cd-error-message">Error message here!</span>
					</p>

					<p class="fieldset">
						<input type="checkbox" id="remember-me" checked>
						<label for="remember-me">Remember me</label>
					</p>

					<p class="fieldset">
						<input class="full-width" type="submit" value="Login">
					</p>
				</form>

				<p class="cd-form-bottom-message"><a href="#0">Forgot your password?</a></p>
				<!-- <a href="#0" class="cd-close-form">Close</a> -->
			</div> <!-- cd-login -->

			<div id="cd-signup"> <!-- sign up form -->
				<form class="cd-form">
					<p class="fieldset">
						<label class="image-replace cd-username" for="signup-username">Username</label>
						<input class="full-width has-padding has-border" id="signup-username" type="text" placeholder="Username">
						<span class="cd-error-message">Error message here!</span>
					</p>

					<p class="fieldset">
						<label class="image-replace cd-email" for="signup-email">E-mail</label>
						<input class="full-width has-padding has-border" id="signup-email" type="email" placeholder="E-mail">
						<span class="cd-error-message">Error message here!</span>
					</p>

					<p class="fieldset">
						<label class="image-replace cd-password" for="signup-password">Password</label>
						<input class="full-width has-padding has-border" id="signup-password" type="text"  placeholder="Password">
						<a href="#0" class="hide-password">Hide</a>
						<span class="cd-error-message">Error message here!</span>
					</p>

					<p class="fieldset">
						<input type="checkbox" id="accept-terms">
						<label for="accept-terms">I agree to the <a href="#0">Terms</a></label>
					</p>

					<p class="fieldset">
						<input class="full-width has-padding" type="submit" value="Create account">
					</p>
				</form>

				<!-- <a href="#0" class="cd-close-form">Close</a> -->
			</div> <!-- cd-signup -->

			<div id="cd-reset-password"> <!-- reset password form -->
				<p class="cd-form-message">Lost your password? Please enter your email address. You will receive a link to create a new password.</p>

				<form class="cd-form">
					<p class="fieldset">
						<label class="image-replace cd-email" for="reset-email">E-mail</label>
						<input class="full-width has-padding has-border" id="reset-email" type="email" placeholder="E-mail">
						<span class="cd-error-message">Error message here!</span>
					</p>

					<p class="fieldset">
						<input class="full-width has-padding" type="submit" value="Reset password">
					</p>
				</form>

				<p class="cd-form-bottom-message"><a href="#0">Back to log-in</a></p>
			</div> <!-- cd-reset-password -->
			<a href="#0" class="cd-close-form">Close</a>
		</div> <!-- cd-user-modal-container -->
	</div> <!-- cd-user-modal -->

	<header role="title">
		<h1>Icons Filling Effect</h1>
	</header>
	<ul class="cd-container">
		<li class="cd-service cd-service-divider"></li>

		<li class="cd-service cd-service-1">
			<h2>Web Design</h2>
			<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Perferendis pariatur tenetur quod veritatis nulla aspernatur architecto! Fugit, reprehenderit amet deserunt molestiae ut libero facere quasi velit perferendis ullam quis necessitatibus!</p>
		</li> <!-- cd-service -->

		<li class="cd-service cd-service-2">
			<h2>Responsive Approach</h2>
			<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Perferendis pariatur tenetur quod veritatis nulla aspernatur architecto! Fugit, reprehenderit amet deserunt molestiae ut libero facere quasi velit perferendis ullam quis necessitatibus!</p>
		</li> <!-- cd-service -->

		<li class="cd-service cd-service-3">
			<h2>E-commerce</h2>
			<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Perferendis pariatur tenetur quod veritatis nulla aspernatur architecto! Fugit, reprehenderit amet deserunt molestiae ut libero facere quasi velit perferendis ullam quis necessitatibus!</p>
		</li> <!-- cd-service -->

		<li class="cd-service cd-service-4">
			<h2>CMS Integration</h2>
			<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Perferendis pariatur tenetur quod veritatis nulla aspernatur architecto! Fugit, reprehenderit amet deserunt molestiae ut libero facere quasi velit perferendis ullam quis necessitatibus!</p>
		</li> <!-- cd-service -->

		<li class="cd-service cd-service-divider"></li>
	</ul> <!-- cd-services -->
	<footer>
		<p>
			Powered by 云麓谷
		</p>
	</footer>

@yield('content');


@yield('foot')

<!-- <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script> -->
{!! HTML::script(config('attendize.cdn_url_static_assets').'/assets/javascript/main.js') !!}

@include('Shared.Partials.GlobalFooterJS')

</body>
</html>