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
	return Redirect::to('/signup');
});

/**
 * ===================================================
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
 * HOME PAGE
 */
Route::get('/user/dashboard', function(){
	return View::make('home.dashboard');
});

Route::get('user/', function(){
	return Redirect::to('user/dashboard');
});

Route::when('user/*', 'auth');
//

// Confide routes
/*Route::get('users/create', 'UsersController@create');
Route::post('users', 'UsersController@store');
Route::get('users/login', 'UsersController@login');
Route::post('users/login', 'UsersController@doLogin');
Route::get('users/confirm/{code}', 'UsersController@confirm');
Route::get('users/forgot_password', 'UsersController@forgotPassword');
Route::post('users/forgot_password', 'UsersController@doForgotPassword');
Route::get('users/reset_password/{token}', 'UsersController@resetPassword');
Route::post('users/reset_password', 'UsersController@doResetPassword');
Route::get('users/logout', 'UsersController@logout');*/
