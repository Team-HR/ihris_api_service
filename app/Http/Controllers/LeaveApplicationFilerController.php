<?php

namespace App\Http\Controllers;

use App\Models\UserLeaveFiles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LeaveApplicationFilerController extends Controller
{
    public function uploadVacationLeaveRequirements(Request $request)
    {
        $validated = $request->validate([
            'employees_id' => 'required|integer',
            'leave_id' => 'required|integer', // Ensure you validate leave_id if it's required
            'authority_to_travel' => 'nullable|file|max:2048',
            'clearance' => 'nullable|file|max:2048',
        ]);

        $currentDate = date('Y-m-d');
        $authorityPath = null;
        $authorityFile = null;
        $clearancePath = null;
        $clearanceFile = null;

        // Store the authority to travel file
        if ($validated['authority_to_travel']) {
            $authorityPath = "{$validated['employees_id']}/vacation_leave/authority_to_travel";
            $authorityFile = $currentDate . "_authority_to_travel_" . $validated['employees_id'] . '.' . $validated['authority_to_travel']->extension();
            Storage::putFileAs($authorityPath, $validated['authority_to_travel'], $authorityFile);
        }

        // Store the clearance file
        if ($validated['clearance']) {
            $clearancePath = "{$validated['employees_id']}/vacation_leave/clearance";
            $clearanceFile = $currentDate . "_clearance_" . $validated['employees_id'] . '.' . $validated['clearance']->extension();
            Storage::putFileAs($clearancePath, $validated['clearance'], $clearanceFile);
        }

        // Create a new instance of the UserLeaveFiles model
        UserLeaveFiles::create([
            'employees_id' => $validated['employees_id'],
            'leave_id' => $validated['leave_id'],
            'authority_to_travel_path' => $authorityPath,
            'authority_to_travel_filename' => $authorityFile,
            'clearance_path' => $clearancePath,
            'clearance_filename' => $clearanceFile,
        ]);

        return response()->json(['message' => 'Files uploaded successfully'], 201);
    }
    public function downloadFile(Request $request)
    {
        $validated = $request->validate([
            'path' => 'required|string',
            'file' => 'required|string',
        ]);

        $fullPath = $validated['path'] . '/' . $validated['file'];

        if (!Storage::exists($fullPath)) {
            return response()->json(['message' => 'File not found.'], 404);
        }

        return response()->download(storage_path("app/{$fullPath}"));
    }
}
