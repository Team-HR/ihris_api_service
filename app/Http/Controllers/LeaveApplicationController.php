<?php

namespace App\Http\Controllers;

use App\Models\SysEmployee;
use App\Models\UserLeaveApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LeaveApplicationController extends Controller
{
    /**
     * 
     * fetches all employees that matches the $name arg
     * 
     * 
     *  */
    public function searchEmployee(Request $request)
    {
        $name = $request->query('name');

        if (empty($name)) {
            return response()->json([]);
        }

        // Split the name into parts
        $nameParts = explode(' ', $name);

        $employees = SysEmployee::where('status', 'ACTIVE')
            ->where(function ($query) use ($nameParts) {
                foreach ($nameParts as $part) {
                    $query->where(function ($q) use ($part) {
                        $q->where('firstName', 'LIKE', '%' . $part . '%')
                            ->orWhere('lastName', 'LIKE', '%' . $part . '%')
                            ->orWhere('middleName', 'LIKE', '%' . $part . '%');
                    });
                }
            })
            ->get();

        return response()->json($employees);
    }

    /**
     * 
     * creates/adds leave application to database
     * 
     * 
     *  */

    public function createLeaveApplication(Request $request)
    {
        $validatedData = $request->validate([
            'employees_id' => 'required|integer', // Assuming users table
            'leave_type' => 'required|string',
            'date_of_filing' => 'required|date',
            'leave_dates' => 'required|array', // Assuming it will be an array
            'leave_dates.*' => 'date', // Each date in the array should be a valid date
            'remarks' => 'nullable|string',
        ]);

        $user = Auth::user();
        $status = in_array('Leave_admin', $user->role) ? 'approved' : 'pending';

        $createdData = UserLeaveApplication::create([
            'employees_id' => $validatedData['employees_id'],
            'leave_type' => $validatedData['leave_type'],
            'date_of_filing' => $validatedData['date_of_filing'],
            'leave_dates' => json_encode($validatedData['leave_dates']),
            'status' => $status,
            'remarks' => $validatedData['remarks'],
        ]);

        return response()->json($createdData);
    }


    /**
     * 
     * Fetches all leave applications from database
     * 
     * 
     *  */
    public function fetchAllLeaveApplications()
    {
        $allData = UserLeaveApplication::orderBy('created_at', 'desc')->get();

        return response()->json($allData);
    }
}
