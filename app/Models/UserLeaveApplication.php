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
        'remarks',
        'status',
    ];

    protected $appends = [
        'employee_information',
    ];

    public function getEmployeeInformationAttribute()
    {
        if (!$this->employees_id) return null;
        return SysEmployee::find($this->employees_id);
    }

    use HasFactory;
}
