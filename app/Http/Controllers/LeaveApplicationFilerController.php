<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LeaveApplicationFilerController extends Controller
{
    public function postVacationLeaveRequirements(Request $request)
    {
        $validated = $request->validate([
            'employees_id' => 'required|integer',
            'authority_to_travel' => 'nullable|file|max:2048',
            'clearance' => 'nullable|file|max:2048',
        ]);

        $currentDate = date('Y-m-d');

        if ($validated['authority_to_travel']) {
            Storage::putFileAs("{$validated['employees_id']}/vacation_leave/authority_to_travel", $validated['authority_to_travel'], $currentDate . "." . $validated['authority_to_travel']->extension());
        }
        if ($validated['clearance']) {
            Storage::putFileAs("{$validated['employees_id']}/vacation_leave/clearance", $validated['clearance'], $currentDate . "." . $validated['clearance']->extension());
        }
    }
}
