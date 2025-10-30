<?php

namespace App\Models\IhrisV2;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Department extends Model
{
    use HasFactory, SoftDeletes;

    protected $connection = 'ihris_v2';
    protected $table = 'departments';
    protected $fillable = [
        'id',
        'parent_id',
        'name',
        'alias',
    ];

    /**
     * Parent department (self-referencing)
     */
    public function parent()
    {
        return $this->belongsTo(Department::class, 'parent_id');
    }

    /**
     * Child departments (self-referencing)
     */
    public function children()
    {
        return $this->hasMany(Department::class, 'parent_id');
    }
}
