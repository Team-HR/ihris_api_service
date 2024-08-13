<?php

use App\Http\Controllers\RatingScaleMatrixController;
use App\Http\Controllers\SuccessIndicatorController;
use App\Models\SpmsMfoPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');



/**
 * 
 * PMS
 * 
 * */

Route::post('/getPeriodId', function (Request $request) {
    $selectedPeriod =  $request->selectedPeriod;
    $selectedYear =  $request->selectedYear;
    $period = SpmsMfoPeriod::where('month_mfo', $selectedPeriod)->where('year_mfo', $selectedYear)->first();
    return $period ? $period->mfoperiod_id : null;
})->middleware('auth:sanctum');

Route::post('/getRsmTitle', [RatingScaleMatrixController::class, 'getRatingScaleMatrixTitle'])->middleware('auth:sanctum');

Route::post('/getRsm', [RatingScaleMatrixController::class, 'getRatingScaleMatrix'])->middleware('auth:sanctum');

Route::post('/getRsmMfos', [RatingScaleMatrixController::class, 'getRatingScaleMatrixMfos'])->middleware('auth:sanctum');

Route::delete('/deleteSi/{id}', [SuccessIndicatorController::class, 'deleteSuccessIndicator'])->middleware('auth:sanctum');
