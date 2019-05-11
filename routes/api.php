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

Route::group(['middleware' => ['auth:api','ability:admin,can-manage-radiology,can-register-reception']], function() {    
    Route::apiResource('radiotypes', 'API\RadioTypeController');
    Route::apiResource('specialities', 'API\SpecialityController');
    Route::apiResource('doctors', 'API\DoctorController');
    Route::apiResource('patients', 'API\PatientController');
});

Route::group(['middleware' => ['auth:api','ability:admin,can-capture-reception']], function() {
    Route::get('receptions/capture', 'API\ReceptionCaptureController@index');       
    Route::get('receptions/{reception}/capture', 'API\ReceptionCaptureController@show');
    Route::get('receptions/{reception}/capture/{capture}', 'API\ReceptionCaptureController@download');   
    Route::put('receptions/{reception}/capture', 'API\ReceptionCaptureController@update');    
    Route::delete('receptions/{reception}/capture', 'API\ReceptionCaptureController@destroy');    
});

Route::group(['middleware' => ['auth:api','ability:admin,can-result-reception']], function() {
    Route::get('receptions/result', 'API\ReceptionResultController@index');   
    Route::get('receptions/{reception}/result', 'API\ReceptionResultController@show');
    Route::put('receptions/{reception}/result', 'API\ReceptionResultController@update');    
    Route::delete('receptions/{reception}/result', 'API\ReceptionResultController@destroy');    

    Route::get('receptions/{reception}/votes', 'API\ReceptionResultController@getVotes');
    Route::put('receptions/{reception}/votes', 'API\ReceptionResultController@setVotes');    
});

Route::group(['middleware' => ['auth:api','role:admin|receptor,can-register-reception']], function() {    
    Route::apiResource('receptions', 'API\ReceptionController');   
});