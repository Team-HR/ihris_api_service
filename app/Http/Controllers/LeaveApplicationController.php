<?php

namespace App\Http\Controllers;

use App\Models\SysEmployee;
use App\Models\User;
use App\Models\UserLeaveApplication;
use App\Models\UserLeaveBalance;
use App\Models\UserLeaveLogs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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
     * searches all leave application that matches the $name arg
     * 
     * 
     *  */
    public function searchLeaveApplication(Request $request)
    {
        $name = $request->query('name');

        if (empty($name)) {
            return response()->json([]);
        }

        // Split the name into parts
        $nameParts = explode(' ', $name);

        $leaveApplications = UserLeaveApplication::where(function ($query) use ($nameParts) {
            foreach ($nameParts as $part) {
                $query->orWhereHas('employee', function ($q) use ($part) {
                    $q->where('firstName', 'LIKE', '%' . $part . '%')
                        ->orWhere('lastName', 'LIKE', '%' . $part . '%')
                        ->orWhere('middleName', 'LIKE', '%' . $part . '%');
                })
                    ->orWhere('leave_type', 'LIKE', '%' . $part . '%')
                    ->orWhere('specified_remark', 'LIKE', '%' . $part . '%');
            }
        })
            ->get();


        return response()->json($leaveApplications);
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
            // 'leave_dates.*' => 'date', // Each date in the array should be a valid date
            'specified_remark' => 'nullable|string',
            'within_philippines' => 'nullable|boolean',
            'abroad' => 'nullable|boolean',
            'in_hospital' => 'nullable|boolean',
            'out_patient' => 'nullable|boolean',
            'half_days' => ['nullable', 'array'], // `half_days` can be null or an array
            'half_days.*.date' => 'required_with:half_days|date', // Date must be provided if `half_days` is provided
            'half_days.*.timeOfDay' => 'required_with:half_days|in:morning,afternoon', // Must be 'morning' or 'afternoon'
            'SPL_type' => 'nullable|string',
            'maternity_leave_type' => 'nullable|in:105,60',
        ]);

        $user = Auth::user();
        // $status = in_array('Leave_admin', $user->role) ? 'pending' : 'pending';
        // If half_days is provided, encode it as a JSON string, else leave it null

        $createdData = UserLeaveApplication::create([
            'employees_id' => $validatedData['employees_id'],
            'leave_type' => $validatedData['leave_type'],
            'date_of_filing' => $validatedData['date_of_filing'],
            'leave_dates' => json_encode($validatedData['leave_dates']),
            'status' => 'pending',
            'specified_remark' => $validatedData['specified_remark'],
            'within_philippines' => $validatedData['within_philippines'],
            'abroad' => $validatedData['abroad'],
            'in_hospital' => $validatedData['in_hospital'],
            'out_patient' => $validatedData['out_patient'],
            'half_days' => $validatedData['half_days'] ? json_encode($validatedData['half_days']) : null,
            'SPL_type' => $validatedData['SPL_type'],
            'maternity_leave_type' => $validatedData['maternity_leave_type'],
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
    public function fetchLeaveApplications(Request $request)
    {
        $id = $request->input('id');
        $status = $request->input('status');

        // If $id is provided, filter by status and employee id
        if ($id !== null) {
            $allData = UserLeaveApplication::where('employees_id', $id)
                ->orderBy('created_at', 'desc')
                ->get();
        } else {
            // If no $id, just filter by status
            $allData = UserLeaveApplication::where('status', $status)
                ->orderBy('created_at', 'desc')
                ->paginate();
        }

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
            'status' => 'required|string|in:approved,rejected,pending',
            'id' => 'required|integer',
            'rejection_remark' => 'string|nullable',
        ]);

        // Find the leave application by ID
        $leaveApplication = UserLeaveApplication::find($validatedData['id']);

        // Check if the application exists
        if (!$leaveApplication) {
            return response()->json(['message' => 'Leave application not found'], 404);
        }

        // Update the status and rejection remark
        $leaveApplication->update([
            'status' => $validatedData['status'],
            'rejection_remark' => $validatedData['rejection_remark'] ?? null, // Handle nullable remark
        ]);

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

    /**
     * 
     * get leave balance with employees id {id} 
     * 
     * 
     *  */
    public function createLeaveLog(Request $request)
    {
        $validatedData = $request->validate([
            'employees_id' => 'required|integer',
            'leave_id' => 'required|integer',
            'record_as_of' => 'required|string',
            'vl_total_earned' => 'numeric|nullable',
            'vl_deduction' => 'numeric|nullable',
            // 'vl_balance' => 'float|nullable',
            'sl_total_earned' => 'numeric|nullable',
            'sl_deduction' => 'numeric|nullable',
            // 'sl_balance' => 'float|nullable',
            'days_with_pay' => 'nullable|string',
            'days_without_pay' => 'nullable|string',
            'others' => 'nullable|string',
        ]);

        $createdData = UserLeaveLogs::create([
            'employees_id' => $validatedData['employees_id'],
            'leave_id' => $validatedData['leave_id'],
            'record_as_of' => $validatedData['record_as_of'],
            'vl_total_earned' => $validatedData['vl_total_earned'],
            'vl_deduction' => $validatedData['vl_deduction'],
            'vl_balance' => $validatedData['vl_total_earned'] - $validatedData['vl_deduction'],
            'sl_total_earned' => $validatedData['sl_total_earned'],
            'sl_deduction' => $validatedData['sl_deduction'],
            'sl_balance' => $validatedData['sl_total_earned'] - $validatedData['sl_deduction'],
            'days_with_pay' => $validatedData['days_with_pay'],
            'days_without_pay' => $validatedData['days_without_pay'],
            'others' => $validatedData['others'],
        ]);

        return response()->json($createdData);
    }
}
