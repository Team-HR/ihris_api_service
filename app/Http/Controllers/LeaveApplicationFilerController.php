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
            'fit_to_work_certification' => 'nullable|file|max:2048',
            'operating_room_record' => 'nullable|file|max:2048',
            'hospital_abstract' => 'nullable|file|max:2048',
            'discharge_summary' => 'nullable|file|max:2048',
            'histopath_report' => 'nullable|file|max:2048',
            'pre_adoptive_placement_authority' => 'nullable|file|max:2048',
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
        $FitToWorkCertificationPath = null;
        $FitToWorkCertificationFile = null;
        $OperatingRoomRecordPath = null;
        $OperatingRoomRecordFile = null;
        $HospitalAbstractPath = null;
        $HospitalAbstractFile = null;
        $DischargeSummaryPath = null;
        $DischargeSummaryFile = null;
        $HistoPathReportPath = null;
        $HistoPathReportFile = null;
        $PreAdoptivePlacementAuthorityPath = null;
        $PreAdoptivePlacementAuthorityFile = null;

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

        // Store the Fit to work certification file
        if (isset($validated['fit_to_work_certification'])) {
            $FitToWorkCertificationPath = "ihris_leave_management/{$validated['employees_id']}/fit_to_work_certification";
            $FitToWorkCertificationFile = $currentDate . "_fit_to_work_certification_" . $validated['employees_id'] . '.' . $validated['fit_to_work_certification']->extension();
            Storage::putFileAs($FitToWorkCertificationPath, $validated['fit_to_work_certification'], $FitToWorkCertificationFile);
        }

        // Store the Operating room record file
        if (isset($validated['operating_room_record'])) {
            $OperatingRoomRecordPath = "ihris_leave_management/{$validated['employees_id']}/operating_room_record";
            $OperatingRoomRecordFile = $currentDate . "_operating_room_record_" . $validated['employees_id'] . '.' . $validated['operating_room_record']->extension();
            Storage::putFileAs($OperatingRoomRecordPath, $validated['operating_room_record'], $OperatingRoomRecordFile);
        }

        // Store the Hospital abstract record file
        if (isset($validated['hospital_abstract'])) {
            $HospitalAbstractPath = "ihris_leave_management/{$validated['employees_id']}/hospital_abstract";
            $HospitalAbstractFile = $currentDate . "_hospital_abstract_" . $validated['employees_id'] . '.' . $validated['hospital_abstract']->extension();
            Storage::putFileAs($HospitalAbstractPath, $validated['hospital_abstract'], $HospitalAbstractFile);
        }

        // Store the Discharge Summary record file
        if (isset($validated['discharge_summary'])) {
            $DischargeSummaryPath = "ihris_leave_management/{$validated['employees_id']}/discharge_summary";
            $DischargeSummaryFile = $currentDate . "_discharge_summary_" . $validated['employees_id'] . '.' . $validated['discharge_summary']->extension();
            Storage::putFileAs($DischargeSummaryPath, $validated['discharge_summary'], $DischargeSummaryFile);
        }

        // Store the HistoPath Report record file
        if (isset($validated['histopath_report'])) {
            $HistoPathReportPath = "ihris_leave_management/{$validated['employees_id']}/histopath_report";
            $HistoPathReportFile = $currentDate . "_histopath_report_" . $validated['employees_id'] . '.' . $validated['histopath_report']->extension();
            Storage::putFileAs($HistoPathReportPath, $validated['histopath_report'], $HistoPathReportFile);
        }

        // Store the HistoPath Report record file
        if (isset($validated['pre_adoptive_placement_authority'])) {
            $PreAdoptivePlacementAuthorityPath = "ihris_leave_management/{$validated['employees_id']}/pre_adoptive_placement_authority";
            $PreAdoptivePlacementAuthorityFile = $currentDate . "_pre_adoptive_placement_authority_" . $validated['employees_id'] . '.' . $validated['pre_adoptive_placement_authority']->extension();
            Storage::putFileAs($PreAdoptivePlacementAuthorityPath, $validated['pre_adoptive_placement_authority'], $PreAdoptivePlacementAuthorityFile);
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
            'fit_to_work_certification_path' => $FitToWorkCertificationPath,
            'fit_to_work_certification_filename' => $FitToWorkCertificationFile,
            'operating_room_record_path' => $OperatingRoomRecordPath,
            'operating_room_record_filename' => $OperatingRoomRecordFile,
            'hospital_abstract_path' => $HospitalAbstractPath,
            'hospital_abstract_filename' => $HospitalAbstractFile,
            'discharge_summary_path' => $DischargeSummaryPath,
            'discharge_summary_filename' => $DischargeSummaryFile,
            'histopath_report_path' => $HistoPathReportPath,
            'histopath_report_filename' => $HistoPathReportFile,
            'pre_adoptive_placement_authority_path' => $PreAdoptivePlacementAuthorityPath,
            'pre_adoptive_placement_authority_filename' => $PreAdoptivePlacementAuthorityFile,
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
