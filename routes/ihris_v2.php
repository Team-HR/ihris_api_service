<?php

use App\Http\Controllers\IhrisV2\CoreFunctionController;
use App\Http\Controllers\IhrisV2\MfoController;
use App\Http\Controllers\IhrisV2\SuccessIndicatorController;
use Illuminate\Support\Facades\Route;

// Route::middleware('auth:sanctum')->group(function () {
//     Route::get('/ihris_v2/mfo-periods/{mfoPeriodId}/departments/{departmentId}', [CoreFunctionController::class, 'getCoreFunctions']);

//     Route::get('/ihris_v2/users/{userId}/success-indicators', [SuccessIndicatorController::class, 'getUserSuccessIndicators']);
// });

Route::get('/ihris_v2/mfo-periods/{mfoPeriodId}/departments/{departmentId}', [CoreFunctionController::class, 'getCoreFunctions']);
Route::get('/ihris_v2/users/{userId}/success-indicators', [SuccessIndicatorController::class, 'getUserSuccessIndicators']);