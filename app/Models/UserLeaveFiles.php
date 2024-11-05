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
    ];

    use HasFactory;
}
