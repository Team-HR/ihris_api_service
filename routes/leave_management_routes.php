<?php

use App\Http\Controllers\LeaveApplicationController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/api/leave-management/search-employee', [LeaveApplicationController::class, 'searchEmployee']);
    Route::get('/api/leave-management/fetch-all-leave-applications', [LeaveApplicationController::class, 'fetchAllLeaveApplications']);
    Route::get('/api/leave-management/get-employee-information/{id}', [LeaveApplicationController::class, 'getEmployeeInformation']);
    Route::post('/api/leave-management/create-leave-application', [LeaveApplicationController::class, 'createLeaveApplication']);
    Route::patch('/api/leave-management/patch-leave-application', [LeaveApplicationController::class, 'updateLeaveApplication']);
});
