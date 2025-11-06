<?php

use App\Http\Controllers\IhrisV2\CoreFunctionController;
use App\Http\Controllers\IhrisV2\MfoController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/ihris_v2/mfo-periods/{mfoPeriodId}/departments/{departmentId}', [CoreFunctionController::class, 'getCoreFunctions']);
});

