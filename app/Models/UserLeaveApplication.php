<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserLeaveApplication extends Model
{
    protected $fillable = [
        'employees_id',
        'leave_type',
        'date_of_filing',
        'leave_dates',
        'status',
        'specified_remark',
        'within_philippines',
        'abroad',
        'in_hospital',
        'out_patient',
        'completion_of_masters_degree',
        'bar_or_board_examination_review',
    ];

    protected $appends = [
        'employee_information',
    ];

    public function getEmployeeInformationAttribute()
    {
        if (!$this->employees_id) return null;
        return SysEmployee::find($this->employees_id);
    }

    public function employee()
    {
        return $this->belongsTo(SysEmployee::class, 'employees_id');
    }


    use HasFactory;
}
