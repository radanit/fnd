<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::group(['middleware' => 'auth:api'], function() {
    Route::apiResource('profiles', 'ProfileController');
    Route::apiResource('users', 'UserController');
    Route::apiResource('user/avatar', 'UserAvatarController')->except(['update','show','destroy']);    
    Route::get('me', 'CurrentUserController@index' );
    Route::get('user', 'CurrentUserController@index');
});

