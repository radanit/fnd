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

Route::group(['middleware' => ['auth:api','ability:admin,can-manage-radiology']], function() {    
    Route::apiResource('radiotypes', 'API\RadioTypeController');
    Route::apiResource('specialities', 'API\SpecialityController');
    Route::apiResource('doctors', 'API\DoctorController');
    Route::apiResource('patients', 'API\PatientController');
});

Route::group(['middleware' => ['auth:api','ability:admin,can-capture-reception']], function() {
    Route::get('receptions/capture', 'API\ReceptionCaptureController@index');   
    Route::get('receptions/{reception}/capture', 'API\ReceptionCaptureController@show');
    Route::put('receptions/{reception}/capture', 'API\ReceptionCaptureController@update');    
    Route::delete('receptions/{reception}/capture', 'API\ReceptionCaptureController@destroy');    
});

Route::group(['middleware' => ['auth:api','role:admin|receptor,can-register-reception']], function() {    
    Route::apiResource('receptions', 'API\ReceptionController');   
});