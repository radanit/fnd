<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// Login Routes...
Route::get('/login', ['uses' => 'LoginController@showLoginForm','as' => 'login']);
Route::post('/login', ['uses' => 'LoginController@login']);
Route::post('/logout', ['uses' => 'LoginController@logout','as' => 'logout']);
Route::get('/logout', ['uses' => 'LoginController@logout','as' => 'logout']);

// Registration Routes...
/*
if ($options['register'] ?? true) {
    Route::get('register', ['uses' => 'RegisterController@showRegistrationForm','as' => 'register']);
    Route::post('register', ['uses' => 'RegisterController@register']);
}
*/
// Password Reset Routes...
/*
Route::get('password/reset', ['uses' => 'ForgotPasswordController@showLinkRequestForm','as' => 'password.request']);
Route::post('password/email', ['uses' => 'ForgotPasswordController@sendResetLinkEmail','as' => 'password.email']);
Route::get('password/reset/{token}', ['uses' => 'ResetPasswordController@showResetForm','as' => 'password.reset']);
Route::post('password/reset', ['uses' => 'ResetPasswordController@reset','as' => 'password.update']);
*/
// Email Verification Routes...
if ($options['verify'] ?? false) {
   //Auth::emailVerification();
}