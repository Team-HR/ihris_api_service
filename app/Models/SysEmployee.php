<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SysEmployee extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'employees';


    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'employees_id';

    // Disable timestamps
    public $timestamps = false;

    protected $appends = [
        'full_name',
        'department',
        'position',
    ];

    public function getFullNameAttribute()
    {
        $middle_name = $this->middleName && $this->middleName != '.' ? ' ' . $this->middleName[0] . '.' : '';
        $name_ext = $this->extName && $this->extName != '.'  ? ' ' . $this->extName : '';
        return $this->lastName . ", " . $this->firstName . $middle_name . $name_ext;
    }


    public function getDepartmentAttribute()
    {
        return SysDepartment::find($this->department_id);
    }

    public function getPositionAttribute()
    {
        return PositionTitles::where('position_id', $this->position_id)->first();
    }
}
