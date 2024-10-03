<?php

namespace App\Http\Controllers;

use App\Models\SysEmployee;
use Illuminate\Http\Request;

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

        $employees = SysEmployee::where('status', 'ACTIVE')
            ->where(function ($query) use ($name) {
                $query->where('firstName', 'LIKE', '%' . $name . '%')
                    ->orWhere('lastName', 'LIKE', '%' . $name . '%')
                    ->orWhere('middleName', 'LIKE', '%' . $name . '%');
            })
            ->get();

        return response()->json($employees);
    }
}
