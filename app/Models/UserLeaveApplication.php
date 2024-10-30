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
        'rejection_remark',
    ];

    protected $appends = [
        'employee_information',
        'leave_files',
        'mandatory_or_forced_leave_balance'
    ];

    public function getEmployeeInformationAttribute()
    {
        if (!$this->employees_id) return null;
        return SysEmployee::find($this->employees_id);
    }
    public function getLeaveFilesAttribute()
    {
        return UserLeaveFiles::where('leave_id', $this->id)->first();
    }
    public function getMandatoryOrForcedLeaveBalanceAttribute()
    {
        $toCount = UserLeaveApplication::where('leave_type', 'Mandatory / Forced leave')
            ->where('employees_id', $this->employees_id)
            ->where('status', 'approved')
            ->whereYear('created_at', date('Y'))
            ->get();

        $count = 0;

        foreach ($toCount as $item) {
            // Decode the JSON array
            $dates = json_decode($item->leave_dates, true); // true for associative array
            $count += count($dates); // Count the number of dates in the array
        }

        return $count;
    }
    public function employee()
    {
        return $this->belongsTo(SysEmployee::class, 'employees_id');
    }


    use HasFactory;
}
