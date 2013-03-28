<?php

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Register all the admin routes.
|
*/

Route::group(array('prefix' => 'admin'), function()
{

	# Blog Management
	Route::get('blogs', 'AdminBlogsController@getIndex');
	Route::get('blogs/create', 'AdminBlogsController@getCreate');
	Route::post('blogs/create', 'AdminBlogsController@postCreate');
	Route::get('blogs/{blogId}/edit', 'AdminBlogsController@getEdit');
	Route::post('blogs/{blogId}/edit', 'AdminBlogsController@postEdit');
	Route::get('blogs/{blogId}/delete', 'AdminBlogsController@getDelete');

	# User Management
	Route::get('users', 'AdminUsersController@getIndex');
	Route::get('users/create', 'AdminUsersController@getCreate');
	Route::post('users/create', 'AdminUsersController@postCreate');
	Route::get('users/{userId}/edit', 'AdminUsersController@getEdit');
	Route::post('users/{userId}/edit', 'AdminUsersController@postEdit');
	Route::get('users/{userId}/delete', 'AdminUsersController@getDelete');

	# Group Management
	Route::get('groups', 'AdminGroupsController@getIndex');
	Route::get('groups/create', 'AdminGroupsController@getCreate');
	Route::post('groups/create', 'AdminGroupsController@postCreate');
	Route::get('groups/{groupId}/edit', 'AdminGroupsController@getEdit');
	Route::post('groups/{groupId}/edit', 'AdminGroupsController@postEdit');
	Route::get('groups/{groupId}/delete', 'AdminGroupsController@getDelete');

	# Admin Dashboard
	Route::get('/', array('as' => 'admin', 'uses' => 'AdminDashboardController@getIndex'));

});

/*
|--------------------------------------------------------------------------
| Authentication and Authorization Routes
|--------------------------------------------------------------------------
|
|
|
*/

Route::group(array('prefix' => 'account'), function()
{

	# Login
	Route::get('signin', array('as' => 'signin', 'uses' => 'AuthController@getSignin'));
	Route::post('signin', 'AuthController@postSignin');

	# Register
	Route::get('signup', array('as' => 'signup', 'uses' => 'AuthController@getSignup'));
	Route::post('signup', 'AuthController@postSignup');

	# Account Activation
	Route::get('activate/{activationCode}', array('as' => 'activate', 'uses' => 'AuthController@getActivate'));

	# Forgot Password
	Route::get('forgot-password', array('as' => 'forgot-password', 'uses' => 'AuthController@getForgotPassword'));
	Route::post('forgot-password', 'AuthController@postForgotPassword');

	# Forgot Password Confirmation
	Route::get('forgot-password/{passwordResetCode}', array('as' => 'forgot-password-confirm', 'uses' => 'AuthController@getForgotPasswordConfirm'));
	Route::post('forgot-password/{passwordResetCode}', 'AuthController@postForgotPasswordConfirm');

	# Logout
	Route::get('logout', array('as' => 'logout', 'uses' => 'AuthController@getLogout'));

});

/*
|--------------------------------------------------------------------------
| Account Routes
|--------------------------------------------------------------------------
|
|
|
*/

# Profile
Route::get('account/profile', array('as' => 'profile', 'uses' => 'AccountProfileController@getIndex'));
Route::post('account/profile', 'AccountProfileController@postIndex');

# Change Password
Route::get('account/change-password', array('as' => 'change-password', 'uses' => 'AccountChangePasswordController@getIndex'));
Route::post('account/change-password', 'AccountChangePasswordController@postIndex');

# Change Email
Route::get('account/change-email', array('as' => 'change-email', 'uses' => 'AccountChangeEmailController@getIndex'));
Route::post('account/change-email', 'AccountChangeEmailController@postIndex');

# Dashboard
Route::get('account', array('as' => 'account', 'uses' => 'AccountDashboardController@getIndex'));


/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('about-us', function()
{
	//
	return View::make('frontend/about-us');
});

Route::get('contact-us', array('as' => 'contact-us', 'uses' => 'ContactUsController@getIndex'));
Route::post('contact-us', 'ContactUsController@postIndex');


Route::get('blog/{postSlug}', array('as' => 'view-post', 'uses' => 'BlogController@getView'));
Route::post('blog/{postSlug}', 'BlogController@postView');

Route::get('/', array('as' => 'home', 'uses' => 'BlogController@getIndex'));

# routes for handling social authentication via opauth
Route::get('social/auth/{network?}', 'SocialController@auth');
Route::get('social/callback', 'SocialController@callback');

Route::get('social/auth/{network?}/int_callback', 'SocialController@auth');
Route::get('social/auth/{network?}/oauth2callback', 'SocialController@auth');
Route::get('social/auth/{network?}/oauth_callback', 'SocialController@auth');
