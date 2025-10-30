<?php

use App\Http\Controllers\IhrisV2\MfoController;
use Illuminate\Support\Facades\Route;

// Route::middleware('auth:sanctum')->group(function () {
//     Route::get('/api/mfos', [MfoController::class, 'getAllMfo']);
// });

Route::get('/api/mfos', [MfoController::class, 'getAllMfo']);