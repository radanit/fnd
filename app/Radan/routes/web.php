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
Route::get('/login', ['uses' => 'Auth\LoginController@showLoginForm','as' => 'login']);
Route::post('/login', ['uses' => 'Auth\LoginController@login']);
Route::post('/logout', ['uses' => 'Auth\LoginController@logout','as' => 'logout']);
Route::get('/logout', ['uses' => 'Auth\LoginController@logout','as' => 'logout']);

// Change password Routes...
Route::get('/password/change', [
    'uses' => 'Auth\PasswordChangeController@showChangeForm',
    'as' => 'password.change.show'
]);
Route::post('/password/change', [
    'uses' => 'Auth\PasswordChangeController@change',
    'as' => 'password.change.update'
]);

// Localization
Route::get('/lang/{lang}', ['as' => 'lang.switch', 'uses' => 'LanguageController@switchLang']);
Route::get('/js/lang.js', ['as' => 'assets.lang', 'uses' => 'LanguageController@getLangResource']);