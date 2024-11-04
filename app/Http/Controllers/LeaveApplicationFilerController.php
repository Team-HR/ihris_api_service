<?php

namespace App\Http\Controllers;

use App\Models\UserLeaveFiles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LeaveApplicationFilerController extends Controller
{
    public function uploadLeaveRequirements(Request $request)
    {
        $validated = $request->validate([
            'employees_id' => 'required|integer',
            'leave_id' => 'required|integer', // Ensure you validate leave_id if it's required
            'authority_to_travel' => 'nullable|file|max:2048',
            'clearance' => 'nullable|file|max:2048',
            'medical_certificate' => 'nullable|file|max:2048',
            'birth_certificate' => 'nullable|file|max:2048',
        ]);

        $currentDate = date('Y-m-d');
        $authorityPath = null;
        $authorityFile = null;
        $clearancePath = null;
        $clearanceFile = null;
        $medicalCertificatePath = null;
        $medicalCertificateFile = null;
        $birthCertificatePath = null;
        $birthCertificateFile = null;

        // Store the authority to travel file
        if (isset($validated['authority_to_travel'])) {
            $authorityPath = "{$validated['employees_id']}/authority_to_travel";
            $authorityFile = $currentDate . "_authority_to_travel_" . $validated['employees_id'] . '.' . $validated['authority_to_travel']->extension();
            Storage::putFileAs($authorityPath, $validated['authority_to_travel'], $authorityFile);
        }

        // Store the clearance file
        if (isset($validated['clearance'])) {
            $clearancePath = "{$validated['employees_id']}/clearance";
            $clearanceFile = $currentDate . "_clearance_" . $validated['employees_id'] . '.' . $validated['clearance']->extension();
            Storage::putFileAs($clearancePath, $validated['clearance'], $clearanceFile);
        }

        // Store the medical cert file
        if (isset($validated['medical_certificate'])) {
            $medicalCertificatePath = "{$validated['employees_id']}/medical_certificate";
            $medicalCertificateFile = $currentDate . "_medical_certificate_" . $validated['employees_id'] . '.' . $validated['clearance']->extension();
            Storage::putFileAs($medicalCertificatePath, $validated['medical_certificate'], $medicalCertificateFile);
        }

        // Store the birth cert file
        if (isset($validated['birth_certificate'])) {
            $birthCertificatePath = "{$validated['employees_id']}/birth_certificate";
            $birthCertificateFile = $currentDate . "_birth_certificate_" . $validated['employees_id'] . '.' . $validated['clearance']->extension();
            Storage::putFileAs($birthCertificatePath, $validated['birth_certificate'], $birthCertificateFile);
        }

        // Create a new instance of the UserLeaveFiles model
        UserLeaveFiles::create([
            'employees_id' => $validated['employees_id'],
            'leave_id' => $validated['leave_id'],
            'authority_to_travel_path' => $authorityPath,
            'authority_to_travel_filename' => $authorityFile,
            'clearance_path' => $clearancePath,
            'clearance_filename' => $clearanceFile,
            'birth_certificate_path' => $birthCertificatePath,
            'birth_certificate_filename' => $birthCertificateFile,
            'medical_certificate_path' => $medicalCertificatePath,
            'medical_certificate_filename' => $medicalCertificateFile,
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
