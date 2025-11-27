<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpmsSuccessIndicator extends Model
{
    // use HasFactory;
    protected $connection = 'mariadb';
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
        'has_quality',
        'quality',
        'has_efficiency',
        'efficiency',
        'has_timeliness',
        'timeliness',
        'personnel',
        'perf_measures'
    ];


    public function getPerfMeasuresAttribute()
    {
        $data = [];

        $attributes = [
            'Quality' => $this->has_quality,
            'Efficiency' => $this->has_efficiency,
            'Timeliness' => $this->has_timeliness,
        ];

        $data = array_keys(array_filter($attributes));
        return $data;
    }

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
                    'full_name' => $employee->full_name,
                    'actual_accomplishment' => getActualAccomplishment($employee->employees_id, $this->mi_id)
                ];
            }
        }
        return $personnel;
    }

    public function getHasQualityAttribute()
    {
        if (!isset($this->mi_quality)) return false;
        $quality = unserialize($this->mi_quality);
        return checkIfNotEmpty($quality);
    }


    public function getQualityAttribute()
    {
        if (!isset($this->mi_quality)) return null;
        $quality = unserialize($this->mi_quality);
        if (checkIfNotEmpty($quality)) {
            $flipped_arr = [];
            $lenght = count($quality);
            for ($i = 0; $i < $lenght; $i++) {
                $flipped_arr[] = $quality[($lenght - $i) - 1];
            }
            return $flipped_arr;
        }
        return null;
    }

    public function getHasEfficiencyAttribute()
    {
        if (!isset($this->mi_eff)) return false;
        $efficiency = unserialize($this->mi_eff);
        return checkIfNotEmpty($efficiency);
    }


    public function getEfficiencyAttribute()
    {
        if (!isset($this->mi_eff)) return null;
        $efficiency = unserialize($this->mi_eff);
        // return checkIfNotEmpty($efficiency) ? $efficiency : null;

        if (checkIfNotEmpty($efficiency)) {
            $flipped_arr = [];
            $lenght = count($efficiency);
            for ($i = 0; $i < $lenght; $i++) {
                $flipped_arr[] = $efficiency[($lenght - $i) - 1];
            }
            return $flipped_arr;
        }
        return null;
    }


    public function getHasTimelinessAttribute()
    {
        if (!isset($this->mi_time)) return false;
        $timeliness = unserialize($this->mi_time);
        return checkIfNotEmpty($timeliness);
    }

    public function getTimelinessAttribute()
    {
        if (!isset($this->mi_time)) return null;
        $timeliness = unserialize($this->mi_time);
        if (checkIfNotEmpty($timeliness)) {
            $flipped_arr = [];
            $lenght = count($timeliness);
            for ($i = 0; $i < $lenght; $i++) {
                $flipped_arr[] = $timeliness[($lenght - $i) - 1];
            }
            return $flipped_arr;
        }
        return null;
    }
}

function checkIfNotEmpty($arr)
{
    if (!is_array($arr)) return false;

    foreach ($arr as $key => $value) {
        if (!empty($value)) {
            return true;
        }
    }
    return false;
}

function getActualAccomplishment($employees_id, $mi_id)
{
    if (!$employees_id && !$mi_id) return null;
    $data = SpmsCoreFunctionData::where('empId', $employees_id)->where('p_id', $mi_id)->first();
    return $data;
}
