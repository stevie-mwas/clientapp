<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title>Xara Financials Client App</title>
		{{ HTML::script('js/bootstrap.min.js') }}
		{{ HTML::style('css/bootstrap.min.css') }}
		{{ HTML::style('css/client.css') }}
	</head>

	<body class="">
		<header>
			<div class="container">
				<div class="row">
					<div class="">
						<h2>Xara Financials</h2>
					</div>
				</div>
			</div>
		</header>

		<div class="container">
			<div class="row">
				<div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3 col-xs-10 col-xs-offset-1 form-wrapper">
					<div class="form-group">
						<img src="img/xara.png" alt="Xara Financials" width="70%" height="70px;">
						<h3>Login to System</h3>
						Don't have an Account? <a href="{{{ URL::to('/signup') }}}">SIGNUP</a>
					</div>
					<form role="form" method="POST" action="{{{ URL::to('/login') }}}">
						<input type="hidden" name="_token" value="{{{ Session::getToken() }}}">
						<div class="form-group">
							<label for="">Username/ Email: </label>
							<input class="form-control" type="text" name="username" value="" placeholder="Username" required>
						</div>
						<div class="form-group">
							<label for="">Password: </label>
							<input class="form-control" type="password" name="password" value="" placeholder="Password" required>
						
							<p class="help-block">
					            <a href="{{{ URL::to('/forgot_pass') }}}">(Forgot Password)</a>
					        </p>
				        </div>
				        <div class="checkbox">
				            <label for="remember">
				                <input tabindex="4" type="checkbox" name="remember" id="remember" value="1"> Remember Me
				            </label>
				        </div>
				        
				        @if (Session::get('error'))
				            <div class="alert alert-error alert-danger">{{{ Session::get('error') }}}</div>
				        @endif

				        @if (Session::get('notice'))
				            <div class="alert">{{{ Session::get('notice') }}}</div>
				        @endif

						<div class="form-group text-right">
							<input class="btn btn-primary" type="submit" name="btn-register" value="Login">
						</div>
					</form>
				</div>
			</div>
		</div>
		
		<footer class="text-center">
			&copy; Copyright 2016 - Lixnet Technologies	
		</footer>
	</body>
</html>
