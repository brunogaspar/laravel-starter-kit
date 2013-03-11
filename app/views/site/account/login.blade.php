@extends('site.layouts.default')

{{-- Web site Title --}}
@section('title')
@parent
:: Account Login
@stop

{{-- Content --}}
@section('content')
<div class="page-header">
   <h3>Login into your account</h3>
</div>
<div class="row">
   <div class="span6">
      <form method="post" action="" class="form-horizontal">
         <!-- CSRF Token -->
         <input type="hidden" name="csrf_token" id="csrf_token" value="{{ csrf_token() }}" />

         <!-- Email -->
         <div class="control-group {{ $errors->has('email') ? 'error' : '' }}">
            <label class="control-label" for="email">Email</label>
            <div class="controls">
               <input type="text" name="email" id="email" value="{{ Input::old('email') }}" />
               {{ $errors->first('email', '<span class="help-inline">:message</span>') }}
            </div>
         </div>
         <!-- ./ email -->

         <!-- Password -->
         <div class="control-group {{ $errors->has('password') ? 'error' : '' }}">
            <label class="control-label" for="password">Password</label>
            <div class="controls">
               <input type="password" name="password" id="password" value="" />
               {{ $errors->first('password', '<span class="help-inline">:message</span>') }}
            </div>
         </div>
         <!-- ./ password -->

         <!-- Remember me -->
         <div class="control-group">
            <div class="controls">
               <label class="checkbox">
                  <input type="checkbox" name="remember-me" id="remember-me" value="1" /> Remember me
               </label>
            </div>
         </div>
         <!-- ./ remember me -->

         <!-- Login button -->
         <div class="control-group">
            <div class="controls">
               <button type="submit" class="btn">Login</button>

               <a href="{{ URL::to('account/forgot-password') }}" class="btn">Forgot your password?</a>
            </div>
         </div>
         <!-- ./ login button -->


      </form>
   </div>
   <div class="span5">

      <!-- Facebook login button -->
      <div class="control-group">
         <div class="controls">	
            <a href="{{ URL::to('social/auth/facebook') }}"><img src="{{ asset('assets/img/social/fb_login.png') }}" alt="Register with facebook" /></a>
         </div>
      </div>
      <!-- ./ Facebook Login button -->
   </div>
</div>
@stop
