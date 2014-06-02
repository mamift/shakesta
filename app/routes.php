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

// Route::enableFilters();
Route::group(['before' => 'apiauth'], function() 
{
	Route::get('/apiauth_test', function() 
	{
		return array('user' => Auth::user()->username, 'data' => Deal::all());
	});
});

// authentication test using basic HTTP auth
Route::get('/httpauth_login', 
	[
		'before' => 'httpauth', 
		function() {
		    return "{ Hello! You successfully authenticated! goto /httpauth_logout to logout}";
		}
	]
);

Route::get('/httpauth_logout', function() 
{
	Auth::logout();
	return Redirect::to('/');
});

/** this is the real API */
// route group for API versioning, this will setup a response for http://example.com/api/v1.1/deal
/** list of routes:
	/api/v1.1/productdeals
	/api/v1.1/dealsonly
*/
// Route::group(array('prefix' => 'api/v1.1', 'before' => 'apiauth'), function()
Route::group(['prefix' => 'api/v1.1'], function()
{
	Route::get('/', function() {
		return ['commands' => [
			'deals',
			'deals/all',
			'deals/all/curent',
			'deals/all/expired',
			'deals/today',
			'deals/week',
			'deals/show/{id}',
			'deals/categories',
			'deals/bycategory']
		];
	});

	Route::group(['before' => 'apiauth'], function() {
		Route::post('deals', 						'APIController@index');
		Route::post('deals/all', 					'APIController@index_all_deals');
		Route::post('deals/all/current', 			'APIController@index_current_deals');
		Route::post('deals/all/expired', 			'APIController@index_expired_deals');
		Route::post('deals/today',	 				'APIController@index_todays_deals');
		Route::post('deals/week',	 				'APIController@index_thisweeks_deals');
		Route::post('deals/show/{id}',				'APIController@show');
		Route::post('deals/categories',				'APIController@index_deal_categories');
		Route::post('deals/bycategory/{category}',	'APIController@deals_by_category');
		// Route::post('deals/search/{text}',		'APIController@search');
	    // Route::resource('deals', 'APIController');
	});
});

Route::group(['prefix' => 'api/v1.2'], function() {
	Route::get('/', function() {
		return ['commands' => [
			'deals/apikey={}',
			'deals/apikey={}/all',
			'deals/apikey={}/all/current',
			'deals/apikey={}/all/expired',
			'deals/apikey={}/today',
			'deals/apikey={}/week',
			'deals/apikey={}/show/{id}',
			'deals/apikey={}/categories',
			'deals/apikey={}/bycategory']
		];
	});

	Route::group(['before' => 'apiauth'], function() {
		Route::get('deals/apikey={apikey}',							'APIController@index');
		Route::get('deals/apikey={apikey}/all', 					'APIController@index_all_deals');
		Route::get('deals/apikey={apikey}/all/current', 			'APIController@index_current_deals');
		Route::get('deals/apikey={apikey}/all/expired', 			'APIController@index_expired_deals');
		Route::get('deals/apikey={apikey}/today',	 				'APIController@index_todays_deals');
		Route::get('deals/apikey={apikey}/week',	 				'APIController@index_thisweeks_deals');
		Route::get('deals/apikey={apikey}/show/{id}',				'APIController@show');
		Route::get('deals/apikey={apikey}/categories',				'APIController@index_deal_categories');
		Route::get('deals/apikey={apikey}/bycategory/{category}',	'APIController@deals_by_category');

		Route::post('categories/apikey={apikey}/create', 'DealsController@store_category');
		Route::post('categories/apikey={apikey}/update', 'DealsController@update_category');
		Route::post('categories/apikey={apikey}/destroy','DealsController@destroy_category');
	});
});
/** end real API */

Route::group(['before' => 'auth'], function() {
	Route::get('deals_by_category', 'DealsController@index_deals_by_category');
	Route::resource('deals', 'DealsController');
	Route::resource('products', 'ProductsController');

	//only administrators can access these
	Route::group(['before' => 'disallow_retailers'], function() {
		Route::resource('retailers', 'RetailersController');
		Route::resource('users', 'UsersController');
	});
});

// User authentication
Route::get('user-login', ['uses' => 'AuthenticationController@index']);
Route::get('user-logout', ['uses' => 'AuthenticationController@destroy']);
Route::post('user-login', ['uses' => 'AuthenticationController@authenticate']);

// User registration
Route::get('user-signup', ['uses' => 'AuthenticationController@register']);
Route::post('user-signup', ['uses' => 'AuthenticationController@self_signup_store']);

Route::get('/', function()
{
	return View::make('index');
});

Route::get('contact-us', function()
{
	return View::make('contactus');	
});