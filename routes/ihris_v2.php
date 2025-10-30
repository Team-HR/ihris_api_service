<?php

use App\Http\Controllers\IhrisV2\MfoController;
use Illuminate\Support\Facades\Route;

// Route::middleware('auth:sanctum')->group(function () {
//     Route::get('/ihris_v2/mfos', [MfoController::class, 'getAllMfo']);
//     Route::get('/ihris_v2/mfos/{mfoId}', [MfoController::class, 'getMfo']);
//     Route::get('/ihris_v2/mfos/{mfoId}/with-core-functions', [MfoController::class, 'getMfoWithCoreFunctions']);
// });

Route::get('/ihris_v2/mfos', [MfoController::class, 'getAllMfo']);
Route::get('/ihris_v2/mfos/{mfoId}', [MfoController::class, 'getMfo']);


// Route::get('/ihris_v2/mfos/{mfoId}', [MfoController::class, 'getMfo']);