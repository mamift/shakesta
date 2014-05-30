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

/* shakesta.app filters */
// disallow retailer users from admin only functions and pages
Route::filter('disallow_retailers', function() 
{
	$user_type = Auth::user()->user_type;
	$is_admin = Auth::user()->is_admin;

	if (!$is_admin && $user_type == 'retailer') {
		return Redirect::to('/user-login')->with('user_message', "You need to be a logged-in admin user to do that!");
	}
});

/* end shakesta.app filters */

/*
|--------------------------------------------------------------------------
| Authentication Filters
|--------------------------------------------------------------------------
|
| The following filters are used to verify that the user of the current
| session is logged into this application. The "basic" filter easily
| integrates HTTP Basic authentication for quick, simple checking.
|
*/

Route::filter('auth', function()
{
	if (Auth::guest()) return Redirect::guest('user-login');
});


Route::filter('httpauth', function()
{
	// leave out arguments to use e-mail field by default i.e. Auth::basic(); 
	// this will use the username field
	return Auth::basic('username');
});

Route::filter('apiauth', function($route, $request)
{
	$invalid_response = ['route' => $route, 'request' => $request];
	// $apikey = Input::get('apikey');
	$apikey = $route->getParameter('apikey');
	$apikeys = DB::table('user')->lists('apikey','user_id');

	if (isset($apikey)) {
		if (!in_array($apikey, $apikeys)) { // a bad api key
			// return Redirect::to();
			// return $invalid_response;
			// return new Response('Blah', 200, null);
			return "Invalid api key!";
		}
	} else {
		return "Need API key!";
	}
	// var_dump($apikeys); exit();
	// return Auth::onceBasic('apikey'); // use another column on the user table
});


/*
|--------------------------------------------------------------------------
| Guest Filter
|--------------------------------------------------------------------------
|
| The "guest" filter is the counterpart of the authentication filters as
| it simply checks that the current user is not logged in. A redirect
| response will be issued if they are, which you may freely change.
|
*/

Route::filter('guest', function()
{
	if (Auth::check()) return Redirect::to('/');
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
	if (Session::token() != Input::get('_token'))
	{
		throw new Illuminate\Session\TokenMismatchException;
	}
});
