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

Route::post('login', 'LoginController@authenticate');
//Route::post('login', 'LoginController@login');
//Route::post('signup', 'RegisterController@signup');
Route::group(['middleware' => 'auth:api'], function() {
    Route::get('logout', 'LoginController@revoke');
    Route::apiResource('roles', 'RoleController');
    Route::apiResource('permissions', 'PermissionController');
    Route::put('change_password', 'ChangePasswordController@update');
    Route::get('users/batch/active/{active}', 'BatchActiveUsersController@show');
    Route::post('users/batch/active', 'BatchActiveUsersController@update');
});
