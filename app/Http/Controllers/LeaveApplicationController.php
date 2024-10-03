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
}
