<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpmsStrategicFunction extends Model
{
    // use HasFactory;
    // spms_performancereviewstatus

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'spms_strategicfuncdata';


    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'strategicFunc_id';


    // Disable timestamps
    public $timestamps = false;


    // protected $appends = [
    //     'ImmediateSupObj',
    //     'DepartmentHeadObj',
    //     'department',
    //     'period'
    // ];

    // public function getImmediateSupObjAttribute()
    // {

    //     $emp = SysEmployee::find($this->ImmediateSup);
    //     if ($emp) {
    //         return $emp->selected;
    //     }
    //     return [
    //         'employee_id' => null,
    //         'full_name' => null,
    //     ];
    // }

    // public function getDepartmentHeadObjAttribute()
    // {
    //     $emp = SysEmployee::find($this->DepartmentHead);
    //     if ($emp) {
    //         return $emp->selected;
    //     }
    //     return [
    //         'employee_id' => null,
    //         'full_name' => null,
    //     ];
    // }

    // public function getDepartmentAttribute()
    // {
    //     return SysDepartment::find($this->department_id);
    // }

    // public function getPeriodAttribute()
    // {
    //     return SpmsMfoPeriod::find($this->period_id);
    // }
}
