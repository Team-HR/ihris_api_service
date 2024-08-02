<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

use App\Http\Controllers\AuthController;

Route::post('/auth/login', [AuthController::class, 'authenticate']);
Route::post('/auth/logout', [AuthController::class, 'logout']);