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

Route::get('/', function(){
	return View::make('user.login');
});

/**
 * ========================================================================
 * LOGIN & SIGNUP PAGES & PROCESS
 * Confide Routes
 */
Route::get('/signup', 'UsersController@createSignUp');
Route::post('/signup', 'UsersController@doSignUp');
Route::get('/login', 'UsersController@createLogin');
Route::post('/login', 'UsersController@doLogin');
Route::get('/confirm/{code}', 'UsersController@confirm');
Route::get('/forgot_pass', 'UsersController@forgotPassword');
Route::post('/forgot_pass', 'UsersController@doForgotPassword');
Route::get('/reset_pass/{token}', 'UsersController@resetPassword');
Route::post('/reset_pass', 'UsersController@doResetPassword');
Route::get('/logout', 'UsersController@logout');



/**
 * DASHBOARD HOME PAGE
 */
Route::get('/user/dashboard', function(){
	return View::make('home.dashboard');
});

Route::get('user/', function(){
	return Redirect::to('user/dashboard');
});

Route::when('user/*', 'auth');

/*Route::get('/login', function(){
	if('auth'){
		return Redirect::to('user/dashboard');
	}
});*/


/**
 * ======================================================================
 * ROUTES TO URLS BEYOND '/user/*'
 */
Route::get('user/orders', 'DashboardController@showOrders');
Route::get('user/products', 'DashboardController@showProducts');
Route::get('user/invoices', 'DashboardController@showInvoices');
Route::get('user/statements', 'DashboardController@showStatements');

Route::get('user/orders/{order_id}', 'DashboardController@viewProducts');


/**
 * ROUTES FOR CREATING A NEW ORDER
 */
Route::get('user/new-order', 'DashboardController@showNewOrder');
Route::post('user/new-order', 'DashboardController@setOrder');
Route::post('user/new-order/commit', 'DashboardController@saveOrder');


/**
 * ====================================================================
 * EDITING AND DELETING ORDER ITEMS BEFORE AND AFTER PROCESSING
 * Edit before processing
 */
Route::get('user/orders/edit/{count}', 'DashboardController@editSessionItem');
Route::post('user/orders/edit/{count}', 'DashboardController@saveEdit');

// Delete item before processing
Route::get('user/orders/delete/{count}', 'DashboardController@deleteSessionItem');