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
Route::middleware(['api','auth:api'])->prefix('bahar')->namespace('\App\Bahar\Controllers')
        ->group(function() {
    Route::apiResource('radiotypes', 'RadioTypeController');    
    Route::apiResource('doctors', 'DoctorController');    
    Route::apiResource('specialities', 'SpecialityController');    
});
