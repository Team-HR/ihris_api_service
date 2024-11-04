<?php

use App\Http\Controllers\LeaveApplicationController;
use App\Http\Controllers\LeaveApplicationFilerController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/api/leave-management/search-employee', [LeaveApplicationController::class, 'searchEmployee']);
    Route::get('/api/leave-management/search-leave-application', [LeaveApplicationController::class, 'searchLeaveApplication']);
    Route::get('/api/leave-management/fetch-all-leave-applications/{status}', [LeaveApplicationController::class, 'fetchLeaveApplications']);
    Route::get('/api/leave-management/get-employee-information/{id}', [LeaveApplicationController::class, 'getEmployeeInformation']);
    Route::get('/api/leave-management/get-leave-application/{id}', [LeaveApplicationController::class, 'getLeaveApplication']);
    Route::get('/api/leave-management/get-leave-balance/{id}', [LeaveApplicationController::class, 'getLeaveBalance']);
    Route::post('/api/leave-management/create-leave-application', [LeaveApplicationController::class, 'createLeaveApplication']);
    Route::patch('/api/leave-management/patch-leave-application', [LeaveApplicationController::class, 'updateLeaveApplication']);
    // FILE SYSTEM BELOW
    Route::post('/api/leave-management/upload-file/vacation-leave', [LeaveApplicationFilerController::class, 'uploadLeaveRequirements']);
    Route::get('/api/leave-management/download/file', [LeaveApplicationFilerController::class, 'downloadFile']);
});
