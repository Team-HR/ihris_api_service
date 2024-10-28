<?php

use App\Http\Controllers\LeaveApplicationController;
use App\Http\Controllers\PcrController;
use App\Http\Controllers\RatingScaleMatrixController;
use App\Http\Controllers\SuccessIndicatorController;
use App\Http\Controllers\SysEmployeeController;
use App\Models\SpmsMfoPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


/**
 * 
 * Generic APIs
 * 
 * */

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/getAllEmployees', [SysEmployeeController::class, 'getAllEmployees']);
});


/**
 * 
 * PMS
 * 
 * */

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/getPeriodId', function (Request $request) {
        $selectedPeriod =  $request->selectedPeriod;
        $selectedYear =  $request->selectedYear;
        $period = SpmsMfoPeriod::where('month_mfo', $selectedPeriod)->where('year_mfo', $selectedYear)->first();
        return $period ? $period->mfoperiod_id : null;
    });

    /**
     * 
     * RSM
     * 
     * */

    Route::get('/rsm/title/{period_id}', [RatingScaleMatrixController::class, 'getRatingScaleMatrixTitle']);
    Route::get('/rsm/{period_id}', [RatingScaleMatrixController::class, 'getRatingScaleMatrix']);
    Route::post('/mfo', [RatingScaleMatrixController::class, 'addNewMfo']);
    Route::post('/mfo/sub', [RatingScaleMatrixController::class, 'addNewSubMfo']);
    Route::patch('/mfo/{cf_ID}', [RatingScaleMatrixController::class, 'updateMfo']);
    Route::delete('/mfo/{cf_ID}', [RatingScaleMatrixController::class, 'deleteMfo']);
    Route::post('/getRsmMfos', [RatingScaleMatrixController::class, 'getRatingScaleMatrixMfosOnly']);
    Route::post('/moveMfoToNewParent', [RatingScaleMatrixController::class, 'moveMfoToNewParent']);
    Route::post('/si/saveEdit', [SuccessIndicatorController::class, 'saveSuccessIndicator']);
    Route::delete('/si/{id}', [SuccessIndicatorController::class, 'deleteSuccessIndicator']);

    /**
     * 
     * PCR
     * 
     * */

    Route::get('/pcr/{period_id}', [PcrController::class, 'getPcr']);
});
