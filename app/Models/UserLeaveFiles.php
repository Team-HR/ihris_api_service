<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserLeaveFiles extends Model
{
    protected $fillable = [
        'employees_id',
        'leave_id',
        'authority_to_travel_path',
        'authority_to_travel_filename',
        'clearance_path',
        'clearance_filename',
        'medical_certificate_path',
        'medical_certificate_filename',
        'birth_certificate_path',
        'birth_certificate_filename',
        'solo_parent_id_path',
        'solo_parent_id_filename',
        'barangay_protection_order_path',
        'barangay_protection_order_filename',
        'temporary_or_permanent_protection_order_path',
        'temporary_or_permanent_protection_order_filename',
        'police_report_path',
        'police_report_filename',
        'incident_report_path',
        'incident_report_filename',
        'approved_letter_of_mayor_path',
        'approved_letter_of_mayor_filename',
        'fit_to_work_certification_path',
        'fit_to_work_certification_filename',
        'operating_room_record_path',
        'operating_room_record_filename',
        'hospital_abstract_path',
        'hospital_abstract_filename',
        'discharge_summary_path',
        'discharge_summary_filename',
        'histopath_report_path',
        'histopath_report_filename',
        'pre_adoptive_placement_authority_path',
        'pre_adoptive_placement_authority_filename',
    ];

    use HasFactory;
}
