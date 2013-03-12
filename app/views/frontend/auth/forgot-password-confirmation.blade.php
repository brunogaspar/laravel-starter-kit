@extends('frontend.layouts.default')

{{-- Page Title --}}
@section('title')
@parent
:: Forgot Password
@stop

{{-- Page content --}}
@section('content')
<div class="page-header">
	<h3>Forgot Password</h3>
</div>
<form method="post" action="" class="form-horizontal">
	<!-- CSRF Token -->
	<input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}" />

	<!-- New Password -->
	<div class="control-group {{ $errors->has('password') ? 'error' : '' }}">
		<label class="control-label" for="password">New Password</label>
		<div class="controls">
			<input type="password" name="password" id="password" value="{{ Input::old('password') }}" />
			{{ $errors->first('password', '<span class="help-inline">:message</span>') }}
		</div>
	</div>

	<!-- Password Confirmation -->
	<div class="control-group {{ $errors->has('password_confirmation') ? 'error' : '' }}">
		<label class="control-label" for="password_confirmation">Password Confirmation</label>
		<div class="controls">
			<input type="password" name="password_confirmation" id="password_confirmation" value="{{ Input::old('password_confirmation') }}" />
			{{ $errors->first('password_confirmation', '<span class="help-inline">:message</span>') }}
		</div>
	</div>

	<!-- Form actions -->
	<div class="control-group">
		<div class="controls">
			<button type="submit" class="btn">Submit</button>
		</div>
	</div>
</form>
@stop
