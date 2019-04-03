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
// Auth Module
Route::post('auth/login', 'AuthLoginController@authenticate',['as' => 'auth.login']);
Route::group(['middleware' => 'auth:api','prefix' => 'auth','as' => 'auth.'], function() {
        Route::get('logout', 'AuthLoginController@revoke')->name('logout');
        Route::apiResource('roles', 'AuthRoleController');
        Route::apiResource('permissions', 'AuthPermissionController');
});

// User
Route::group(['middleware' => 'auth:api','as' => 'users.me.'], function() {
    Route::put('users/me/password', 'UserPasswordController@update')->name('password');
    Route::apiResource('users/me/avatar', 'UserAvatarController')->except(['update','show','destroy']); 
    Route::get('users/me', 'UserMeController@index')->name('profile');
});

Route::group(['middleware' => 'auth:api','as' => 'users.batch.'], function() {    
    Route::apiResource('users/batch/active', 'UserBatchActiveController')->except(['index','store','destroy']);    
});

Route::group(['middleware' => 'auth:api'], function() {    
    Route::apiResource('users', 'UserController');
});
       
// Profile Module
Route::group(['middleware' => 'auth:api'], function() {
    Route::apiResource('profiles', 'ProfileController');
});

// Config Module
Route::group(['middleware' => 'auth:api'], function() {    
    Route::apiResource('settings', 'ConfigController');
});

// Policy Module
Route::group(['middleware' => 'auth:api','as' => 'policy.'], function() {
    Route::apiResource('policy/password', 'PolicyPasswordController');
});