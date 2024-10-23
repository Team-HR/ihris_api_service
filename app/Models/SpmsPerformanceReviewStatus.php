<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpmsPerformanceReviewStatus extends Model
{
    // use HasFactory;
    // spms_performancereviewstatus

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'spms_performancereviewstatus';


    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'performanceReviewStatus_id';


    // Disable timestamps
    public $timestamps = false;


    protected $appends = [
        'department',
        'period'
    ];

    public function getDepartmentAttribute()
    {
        return SysDepartment::find($this->department_id);
    }

    public function getPeriodAttribute()
    {
        return SpmsMfoPeriod::find($this->period_id);
    }
}
