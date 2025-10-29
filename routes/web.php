<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

use App\Http\Controllers\AuthController;

Route::post('/auth/login', [AuthController::class, 'authenticate']);
Route::post('/auth/logout', [AuthController::class, 'logout']);
Route::get('/auth/fetch-user', [AuthController::class, 'fetchAuthenticatedUser']);

require __DIR__ . '/leave_management_routes.php';
