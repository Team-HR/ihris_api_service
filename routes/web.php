<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

use App\Http\Controllers\AuthController;
use App\Http\Controllers\LeaveApplicationController;

Route::post('/auth/login', [AuthController::class, 'authenticate']);
Route::post('/auth/logout', [AuthController::class, 'logout']);

require __DIR__ . '/leave_management_routes.php';
