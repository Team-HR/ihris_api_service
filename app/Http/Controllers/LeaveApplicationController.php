<?php

namespace App\Http\Controllers;

use App\Models\SysEmployee;
use App\Models\User;
use App\Models\UserLeaveApplication;
use App\Models\UserLeaveBalance;
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
            'specified_remark' => 'nullable|string',
            'within_philippines' => 'nullable|boolean',
            'abroad' => 'nullable|boolean',
            // 'in_hospital' => 'nullable|boolean',
            // 'out_patient' => 'nullable|boolean',
            // 'completion_of_masters_degree' => 'nullable|boolean',
            // 'bar_or_board_examination_review' => 'nullable|boolean',
        ]);

        $user = Auth::user();
        $status = in_array('Leave_admin', $user->role) ? 'approved' : 'pending';

        $createdData = UserLeaveApplication::create([
            'employees_id' => $validatedData['employees_id'],
            'leave_type' => $validatedData['leave_type'],
            'date_of_filing' => $validatedData['date_of_filing'],
            'leave_dates' => json_encode($validatedData['leave_dates']),
            'status' => $status,
            'specified_remark' => $validatedData['specified_remark'],
            'within_philippines' => $validatedData['within_philippines'],
            'abroad' => $validatedData['abroad'],
            // 'in_hospital' => $validatedData['in_hospital'],
            // 'out_patient' => $validatedData['out_patient'],
            // 'completion_of_masters_degree' => $validatedData['completion_of_masters_degree'],
            // 'bar_or_board_examination_review' => $validatedData['bar_or_board_examination_review'],
        ]);

        return response()->json($createdData);
    }


    /**
     * 
     * Fetches leave applications from database
     * 
     * 
     *  */
    public function fetchLeaveApplications($status)
    {
        $allData = UserLeaveApplication::where('status', $status)->orderBy('created_at', 'desc')->get();

        return response()->json($allData);
    }


    /**
     * 
     * updates leave applications with {id} 
     * updates status of leave applications approved/rejected
     * 
     *  */
    public function updateLeaveApplication(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'status' => 'required|string|in:approved,rejected,pending', // Adjust statuses as needed
            'id' => 'required|int'
        ]);

        // Find the leave application by ID
        $leaveApplication = UserLeaveApplication::find($validatedData['id']);

        // Check if the application exists
        if (!$leaveApplication) {
            return response()->json(['message' => 'Leave application not found'], 404);
        }

        // Update the status
        $leaveApplication->status = $validatedData['status'];
        $leaveApplication->save();

        return response()->json($leaveApplication, 200);
    }
    /**
     * 
     * get employee information with specific {id} 
     * 
     * 
     *  */
    public function getEmployeeInformation($id)
    {
        // Fetch the user based on employees_id
        $user = User::where('employees_id', $id)->first();

        // Check if the user exists
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        // Return the user information
        return response()->json($user);
    }
    /**
     * 
     * get leave application with specific {id} 
     * 
     * 
     *  */
    public function getLeaveApplication($id)
    {
        // Fetch the user based on employees_id
        $leaveApplication = UserLeaveApplication::find($id);

        // Check if the user exists
        if (!$leaveApplication) {
            return response()->json(['message' => 'Leave application not found'], 404);
        }

        // Return the user information
        return response()->json($leaveApplication);
    }
    /**
     * 
     * get leave balance with employees id {id} 
     * 
     * 
     *  */
    public function getLeaveBalance($id)
    {
        // Fetch the user based on employees_id
        $leaveBalance = UserLeaveBalance::where('employees_id', $id)->first();

        if (!$leaveBalance) {
            return response()->json(['message' => 'Leave balance not found'], 404);
        }

        // Return the leave balance information
        return response()->json($leaveBalance ?? null);
    }
}
