<?php

/*
|--------------------------------------------------------------------------
| Application & Route Filters
|--------------------------------------------------------------------------
|
| Below you will find the "before" and "after" events for the application
| which may be used to do any work before or after a request into your
| application. Here you may also register your custom route filters.
|
*/

App::before(function($request)
{
	//
});


App::after(function($request, $response)
{
	//
});

/*
|--------------------------------------------------------------------------
| Authentication Filters
|--------------------------------------------------------------------------
|
| The following filters are used to verify that the user of the current
| session is logged into this application. Also, a "guest" filter is
| responsible for performing the opposite. Both provide redirects.
|
*/

Route::filter('auth', function()
{
	// Check if the user is logged in
	if ( ! Sentry::check())
	{
		// Store the current uri in the session
		Session::put('loginRedirect', Request::url());

		// Redirect to the login page
		return Redirect::route('signin');
	}
});

/*
|--------------------------------------------------------------------------
| Admin authentication filter.
|--------------------------------------------------------------------------
|
| This filter does the same as the 'auth' filter but it checks if the user
| has 'admin' privileges.
|
*/

Route::filter('admin-auth', function()
{
	// Check if the user is logged in
	if ( ! Sentry::check())
	{
		// Store the current uri in the session
		Session::put('loginRedirect', Request::url());

		// Redirect to the login page
		return Redirect::route('signin');
	}

	// Check if the user has access to the admin page
	if ( ! Sentry::getUser()->hasAccess('admin'))
	{
		// Show the insufficient permissions page
		return App::abort(403);
	}
});

/*
|--------------------------------------------------------------------------
| CSRF Protection Filter
|--------------------------------------------------------------------------
|
| The CSRF filter is responsible for protecting your application against
| cross-site request forgery attacks. If this special token in a user
| session does not match the one given in this request, we'll bail.
|
*/

Route::filter('csrf', function()
{
	if (Session::getToken() != Input::get('_token'))
	{
		throw new Illuminate\Session\TokenMismatchException;
	}
});
