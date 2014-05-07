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

Route::resource('deals', 'DealsController');

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