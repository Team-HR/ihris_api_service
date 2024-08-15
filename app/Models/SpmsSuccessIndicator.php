<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpmsSuccessIndicator extends Model
{
    // use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'spms_matrixindicators';


    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'mi_id';


    // Disable timestamps
    public $timestamps = false;

    protected $appends = [
        'quality',
        'effeciency',
        'timeliness',
        'personnel'
    ];

    public function getPersonnelAttribute()
    {
        if (!isset($this->mi_incharge)) return null;
        $incharges = explode(',', $this->mi_incharge);
        $personnel = [];

        foreach ($incharges as $employee_id) {
            $employee = SysEmployee::find($employee_id);
            if ($employee) {
                $personnel[] = [
                    'employee_id' => $employee->employees_id,
                    'full_name' => $employee->full_name
                ];
            }
        }
        return $personnel;
    }

    public function getQualityAttribute()
    {
        if (!isset($this->mi_quality)) return null;
        $quality = unserialize($this->mi_quality);
        return checkIfNotEmpty($quality) ? $quality : null;
    }

    public function getEffeciencyAttribute()
    {
        if (!isset($this->mi_eff)) return null;
        $efficiency = unserialize($this->mi_eff);
        return checkIfNotEmpty($efficiency) ? $efficiency : null;
    }

    public function getTimelinessAttribute()
    {
        if (!isset($this->mi_time)) return null;
        $timeliness = unserialize($this->mi_time);
        return checkIfNotEmpty($timeliness) ? $timeliness : null;
    }
}

function checkIfNotEmpty($arr)
{
    foreach ($arr as $key => $value) {
        if (!empty($value)) {
            return true;
        }
    }
    return false;
}
