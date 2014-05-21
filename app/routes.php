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
Route::get('/authtest', array
	(
		'before' => 'auth.basic', 
		function() {
		    // return View::make('hello');
		    return "Hello! You successfully authenticated!";
		}
	)
);

/** this was for the test API **/
// route group for API versioning, this will setup a response for http://example.com/api/v1/url
Route::group(array('prefix' => 'api/v1', 'before' => 'auth.basic'), function()
{
    Route::resource('url', 'UrlController');
});
/** end test API **/

/** this is the real API **/
// route group for API versioning, this will setup a response for http://example.com/api/v1.1/url
Route::group(array('prefix' => 'api/v1.1', 'before' => 'auth.basic'), function()
{
	Route::get('dealsonly', 'APIController@dealsindex'); // see the dealsindex() function inside the \APIController class
    Route::resource('deal', 'APIController');
});

/** end real API **/

Route::resource('deals', 'DealsController');

Route::resource('products', 'ProductsController');

Route::resource('retailers', 'RetailersController');

Route::resource('users', 'UsersController');

Route::get('/', function()
{
	return View::make('index');
});

Route::get('user-login', function() 
{
	return View::make('login');
});

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