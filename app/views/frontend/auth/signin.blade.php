@extends('frontend.layouts.default')

{{-- Page title --}}
@section('title')
Account Sign in ::
@parent
@stop

{{-- Page content --}}
@section('content')
<div class="page-header">
	<h3>Sign in into your account</h3>
</div>
<div class="row">
	<div class="span8">
		<form method="post" action="{{ URL::route('signin') }}" class="form-horizontal">
			<!-- CSRF Token -->
			<input type="hidden" name="_token" value="{{ csrf_token() }}" />

			<!-- Email -->
			<div class="control-group{{ $errors->first('email', ' error') }}">
				<label class="control-label" for="email">Email</label>
				<div class="controls">
					<input type="text" name="email" id="email" value="{{ Input::old('email') }}" />
					{{ $errors->first('email', '<span class="help-inline">:message</span>') }}
				</div>
			</div>

			<!-- Password -->
			<div class="control-group{{ $errors->first('password', ' error') }}">
				<label class="control-label" for="password">Password</label>
				<div class="controls">
					<input type="password" name="password" id="password" value="" />
					{{ $errors->first('password', '<span class="help-inline">:message</span>') }}
				</div>
			</div>

			<!-- Remember me -->
			<div class="control-group">
				<div class="controls">
				<label class="checkbox">
					<input type="checkbox" name="remember-me" id="remember-me" value="1" /> Remember me
				</label>
				</div>
			</div>

			<!-- Form actions -->
			<div class="control-group">
				<div class="controls">
					<a class="btn" href="{{ URL::to('/') }}">Cancel</a>

					<button type="submit" class="btn btn-info">Sign in</button>

					<hr />

					<a href="{{ URL::route('forgot-password') }}">Forgot your password?</a>
				</div>
			</div>
		</form>
	</div>
	<div class="span4">
		<!-- Facebook login button -->
		<div class="control-group">
			<div class="controls">
				<a href="{{ URL::to('social/auth/facebook') }}"><img src="{{ asset('assets/img/social/fb_login.png') }}" alt="Register with facebook" /></a>
			</div>
		</div>
	</div>
</div>
@stop
