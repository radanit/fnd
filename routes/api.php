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

Route::group(['middleware' => ['auth:api','role:admin|radio-admin']], function() {    
    Route::apiResource('radiotypes', 'API\RadioTypeController');
    Route::apiResource('specialities', 'API\SpecialityController');
    Route::apiResource('doctors', 'API\DoctorController');
});

Route::group(['middleware' => ['auth:api','role:admin|receptor']], function() {    
    Route::apiResource('receptions', 'API\ReceptionController');   
});