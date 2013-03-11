@extends('site.layouts.default')

{{-- Web site Title --}}
@section('title')
@parent
:: Account Signup
@stop

{{-- Content --}}
@section('content')
<div class="page-header">
   <h3>Signup</h3>
</div>
<div class="row">
   <div class="span6">
      <!-- ./ Facebook Login button -->
      <form method="post" action="" class="form-horizontal" autocomplete="off">
         <!-- CSRF Token -->
         <input type="hidden" name="csrf_token" id="csrf_token" value="{{ csrf_token() }}" />
         <!-- ./ csrf token -->

         <!-- First Name -->
         <div class="control-group {{ $errors->has('first_name') ? 'error' : '' }}">
            <label class="control-label" for="first_name">First Name</label>
            <div class="controls">
               <input type="text" name="first_name" id="first_name" value="{{ Input::old('first_name') }}" />
               {{ $errors->first('first_name', '<span class="help-inline">:message</span>') }}
            </div>
         </div>
         <!-- ./ first name -->

         <!-- Last Name -->
         <div class="control-group {{ $errors->has('last_name') ? 'error' : '' }}">
            <label class="control-label" for="last_name">Last Name</label>
            <div class="controls">
               <input type="text" name="last_name" id="last_name" value="{{ Input::old('last_name') }}" />
               {{ $errors->first('last_name', '<span class="help-inline">:message</span>') }}
            </div>
         </div>
         <!-- ./ last name -->

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

         <!-- Password Confirm -->
         <div class="control-group {{ $errors->has('password_confirmation') ? 'error' : '' }}">
            <label class="control-label" for="password_confirmation">Password Confirm</label>
            <div class="controls">
               <input type="password" name="password_confirmation" id="password_confirmation" value="" />
               {{ $errors->first('password_confirmation', '<span class="help-inline">:message</span>') }}
            </div>
         </div>
         <!-- ./ password confirm -->

         <!-- Signup button -->
         <div class="control-group">
            <div class="controls">
               <button type="submit" class="btn">Signup</button>
            </div>
         </div>
         <!-- ./ signup button -->
      </form>
   </div>
   <div class="span5">

      <!-- Facebook login button -->
      <div class="control-group">
         <div class="controls">	
            <a href="{{ URL::to('social/auth/facebook') }}"><img src="{{ asset('assets/img/social/fb_signup.png') }}" alt="Register with facebook" /></a>
         </div>
      </div>
       <!-- ./ Facebook Login button -->
   </div>
</div>
@stop
