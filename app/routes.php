<?php

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

// authentication test using basic HTTP auth
Route::get('/httpauth_login', [
		'before' => 'auth.basic', 
		function() {
		    return "Hello! You successfully authenticated!";
		}
	]
);

Route::get('/httpauth_logout', function() 
{
	Auth::logout();
	return Redirect::to('/');
});

/** this was for the test API */
// route group for API versioning, this will setup a response for http://example.com/api/v1/url
// Route::group(array('prefix' => 'api/v1', 'before' => 'auth.basic'), function()
// {
//     Route::resource('url', 'UrlController');
// });
/** end test API */

/** this is the real API */
// route group for API versioning, this will setup a response for http://example.com/api/v1.1/deal
/** list of routes:
	/api/v1.1/productdeals
	/api/v1.1/dealsonly
*/
Route::group(array('prefix' => 'api/v1.1', 'before' => 'auth.basic'), function()
{
	Route::get('current_deals', 'APIController@index_unexpired_deals');
	Route::get('todays_deals', 'APIController@index_todays_deals');
	Route::get('weekly_deals', 'APIController@index_thisweeks_deals');
    Route::resource('deals', 'APIController');
});
/** end real API */

Route::resource('deals', 'DealsController');
Route::resource('products', 'ProductsController');
Route::resource('retailers', 'RetailersController');
Route::resource('users', 'UsersController');

Route::get('/', function()
{
	return View::make('index');
});

// User authentication
Route::get('user-login', ['uses' => 'AuthenticationController@index']);
Route::get('user-logout', ['uses' => 'AuthenticationController@destroy']);
Route::post('user-login', ['uses' => 'AuthenticationController@authenticate']);

Route::get('user-viewdeals', function()
{
	return View::make('user-viewdeals');
});

Route::get('user-createdeal', function() 
{
	return View::make('user-createdeal');
});

Route::get('contact-us', function()
{
	return View::make('contactus');	
});