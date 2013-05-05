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
	Route::group(array('prefix' => 'blogs'), function()
	{
		Route::get('/', 'AdminBlogsController@getIndex');
		Route::get('create', 'AdminBlogsController@getCreate');
		Route::post('create', 'AdminBlogsController@postCreate');
		Route::get('{blogId}/edit', 'AdminBlogsController@getEdit');
		Route::post('{blogId}/edit', 'AdminBlogsController@postEdit');
		Route::get('{blogId}/delete', 'AdminBlogsController@getDelete');
	});

	# User Management
	Route::group(array('prefix' => 'users'), function()
	{
		Route::get('/', 'AdminUsersController@getIndex');
		Route::get('create', 'AdminUsersController@getCreate');
		Route::post('create', 'AdminUsersController@postCreate');
		Route::get('{userId}/edit', 'AdminUsersController@getEdit');
		Route::post('{userId}/edit', 'AdminUsersController@postEdit');
		Route::get('{userId}/delete', 'AdminUsersController@getDelete');
	});

	# Group Management
	Route::group(array('prefix' => 'groups'), function()
	{
		Route::get('/', 'AdminGroupsController@getIndex');
		Route::get('create', 'AdminGroupsController@getCreate');
		Route::post('create', 'AdminGroupsController@postCreate');
		Route::get('{groupId}/edit', 'AdminGroupsController@getEdit');
		Route::post('{groupId}/edit', 'AdminGroupsController@postEdit');
		Route::get('{groupId}/delete', 'AdminGroupsController@getDelete');
	});

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

Route::group(array('prefix' => 'auth'), function()
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

Route::group(array('prefix' => 'account'), function()
{

	# Account Dashboard
	Route::get('/', array('as' => 'account', 'uses' => 'AccountDashboardController@getIndex'));

	# Profile
	Route::get('profile', array('as' => 'profile', 'uses' => 'AccountProfileController@getIndex'));
	Route::post('profile', 'AccountProfileController@postIndex');

	# Change Password
	Route::get('change-password', array('as' => 'change-password', 'uses' => 'AccountChangePasswordController@getIndex'));
	Route::post('change-password', 'AccountChangePasswordController@postIndex');

	# Change Email
	Route::get('change-email', array('as' => 'change-email', 'uses' => 'AccountChangeEmailController@getIndex'));
	Route::post('change-email', 'AccountChangeEmailController@postIndex');

});

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
