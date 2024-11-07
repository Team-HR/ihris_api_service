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
            'solo_parent_id' => 'nullable|file|max:2048',
            'barangay_protection_order' => 'nullable|file|max:2048',
            'temporary_or_permanent_protection_order' => 'nullable|file|max:2048',
            'police_report' => 'nullable|file|max:2048',
            'incident_report' => 'nullable|file|max:2048',
            'approved_letter_of_mayor' => 'nullable|file|max:2048',
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
        $soloParentIdPath = null;
        $soloParentIdFile = null;
        $brgyProtectionOrderPath = null;
        $brgyProtectionOrderFile = null;
        $TemporaryOrPermanentProtectionOrderPath = null;
        $TemporaryOrPermanentProtectionOrderFile = null;
        $PoliceReportPath = null;
        $PoliceReportFile = null;
        $IncidentReportPath = null;
        $IncidentReportFile = null;
        $ApprovedLetterOfMayorPath = null;
        $ApprovedLetterOfMayorFile = null;

        // Store the authority to travel file
        if (isset($validated['authority_to_travel'])) {
            $authorityPath = "ihris_leave_management/{$validated['employees_id']}/authority_to_travel";
            $authorityFile = $currentDate . "_authority_to_travel_" . $validated['employees_id'] . '.' . $validated['authority_to_travel']->extension();
            Storage::putFileAs($authorityPath, $validated['authority_to_travel'], $authorityFile);
        }

        // Store the clearance file
        if (isset($validated['clearance'])) {
            $clearancePath = "ihris_leave_management/{$validated['employees_id']}/clearance";
            $clearanceFile = $currentDate . "_clearance_" . $validated['employees_id'] . '.' . $validated['clearance']->extension();
            Storage::putFileAs($clearancePath, $validated['clearance'], $clearanceFile);
        }

        // Store the medical cert file
        if (isset($validated['medical_certificate'])) {
            $medicalCertificatePath = "ihris_leave_management/{$validated['employees_id']}/medical_certificate";
            $medicalCertificateFile = $currentDate . "_medical_certificate_" . $validated['employees_id'] . '.' . $validated['medical_certificate']->extension();
            Storage::putFileAs($medicalCertificatePath, $validated['medical_certificate'], $medicalCertificateFile);
        }

        // Store the birth cert file
        if (isset($validated['birth_certificate'])) {
            $birthCertificatePath = "ihris_leave_management/{$validated['employees_id']}/birth_certificate";
            $birthCertificateFile = $currentDate . "_birth_certificate_" . $validated['employees_id'] . '.' . $validated['birth_certificate']->extension();
            Storage::putFileAs($birthCertificatePath, $validated['birth_certificate'], $birthCertificateFile);
        }

        // Store the solo parent cert file
        if (isset($validated['solo_parent_id'])) {
            $soloParentIdPath = "ihris_leave_management/{$validated['employees_id']}/solo_parent_id";
            $soloParentIdFile = $currentDate . "_solo_parent_id_" . $validated['employees_id'] . '.' . $validated['solo_parent_id']->extension();
            Storage::putFileAs($soloParentIdPath, $validated['solo_parent_id'], $soloParentIdFile);
        }

        // Store the brgy protection order file
        if (isset($validated['barangay_protection_order'])) {
            $brgyProtectionOrderPath = "ihris_leave_management/{$validated['employees_id']}/barangay_protection_order";
            $brgyProtectionOrderFile = $currentDate . "_barangay_protection_order_" . $validated['employees_id'] . '.' . $validated['barangay_protection_order']->extension();
            Storage::putFileAs($brgyProtectionOrderPath, $validated['barangay_protection_order'], $brgyProtectionOrderFile);
        }

        // Store the temporary or permanent protection order file
        if (isset($validated['temporary_or_permanent_protection_order'])) {
            $TemporaryOrPermanentProtectionOrderPath = "ihris_leave_management/{$validated['employees_id']}/temporary_or_permanent_protection_order";
            $TemporaryOrPermanentProtectionOrderFile = $currentDate . "_temporary_or_permanent_protection_order_" . $validated['employees_id'] . '.' . $validated['temporary_or_permanent_protection_order']->extension();
            Storage::putFileAs($TemporaryOrPermanentProtectionOrderPath, $validated['temporary_or_permanent_protection_order'], $TemporaryOrPermanentProtectionOrderFile);
        }

        // Store the Police report file
        if (isset($validated['police_report'])) {
            $PoliceReportPath = "ihris_leave_management/{$validated['employees_id']}/police_report";
            $PoliceReportFile = $currentDate . "_police_report_" . $validated['employees_id'] . '.' . $validated['police_report']->extension();
            Storage::putFileAs($PoliceReportPath, $validated['police_report'], $PoliceReportFile);
        }

        // Store the Incident report file
        if (isset($validated['incident_report'])) {
            $IncidentReportPath = "ihris_leave_management/{$validated['employees_id']}/incident_report";
            $IncidentReportFile = $currentDate . "_incident_report_" . $validated['employees_id'] . '.' . $validated['incident_report']->extension();
            Storage::putFileAs($IncidentReportPath, $validated['incident_report'], $IncidentReportFile);
        }

        // Store the Approved letter of mayor file
        if (isset($validated['approved_letter_of_mayor'])) {
            $ApprovedLetterOfMayorPath = "ihris_leave_management/{$validated['employees_id']}/approved_letter_of_mayor";
            $ApprovedLetterOfMayorFile = $currentDate . "_approved_letter_of_mayor_" . $validated['employees_id'] . '.' . $validated['approved_letter_of_mayor']->extension();
            Storage::putFileAs($ApprovedLetterOfMayorPath, $validated['approved_letter_of_mayor'], $ApprovedLetterOfMayorFile);
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
            'solo_parent_id_path' => $soloParentIdPath,
            'solo_parent_id_filename' => $soloParentIdFile,
            'barangay_protection_order_path' => $brgyProtectionOrderPath,
            'barangay_protection_order_filename' => $brgyProtectionOrderFile,
            'temporary_or_permanent_protection_order_path' => $TemporaryOrPermanentProtectionOrderPath,
            'temporary_or_permanent_protection_order_filename' => $TemporaryOrPermanentProtectionOrderFile,
            'police_report_path' => $PoliceReportPath,
            'police_report_filename' => $PoliceReportFile,
            'incident_report_path' => $IncidentReportPath,
            'incident_report_filename' => $IncidentReportFile,
            'approved_letter_of_mayor_path' => $ApprovedLetterOfMayorPath,
            'approved_letter_of_mayor_filename' => $ApprovedLetterOfMayorFile,
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
