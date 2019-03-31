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
Route::post('auth/login', 'LoginController@authenticate',['as' => 'auth.login']);
Route::group(['middleware' => 'auth:api','prefix' => 'auth','as' => 'auth.'], function() {
        Route::get('logout', 'LoginController@revoke')->name('logout');
        Route::apiResource('roles', 'RoleController');
        Route::apiResource('permissions', 'PermissionController');
});

// User
Route::group(['middleware' => 'auth:api','prefix' => 'users/me','as' => 'users.me.'], function() {
    Route::put('password', 'ChangePasswordController@update')->name('password');
    Route::apiResource('avatar', 'UserAvatarController')->except(['update','show','destroy']); 
    Route::get('/', 'CurrentUserController@index')->name('profile');
});

Route::group(['middleware' => 'auth:api','prefix' => 'users','as' => 'users.'], function() {    
    Route::apiResource('batch/active', 'BatchActiveUsersController')->except(['update','show','destroy']);
    Route::apiResource('/', 'UserController');
});
/*        
// Profile Module
Route::name('profiles.')->group(['middleware' => 'auth:api','prefix' => 'profiles'], function() {    
    Route::apiResource('/', 'ProfileController')->name('profile');
});

// Config Module
Route::name('settings.')->group(['middleware' => 'auth:api','prefix' => 'settings'], function() {    
    Route::apiResource('/', 'ConfigController')->name('setting');
});

// Policy Module
Route::name('policy.')->group(['middleware' => 'auth:api','prefix' => 'policy'], function() {
    Route::apiResource('password', 'PasswordPolicyController')->name('password');
});*/