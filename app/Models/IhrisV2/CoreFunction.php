<?php

namespace App\Models\IhrisV2;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class CoreFunction extends Model
{
    use HasFactory, SoftDeletes;

    // Specify the connection to the new database
    protected $connection = 'ihris_v2';

    // Mass-assignable columns
    protected $fillable = [
        'mfo_period_id',
        'parent_id',
        'department_id',
        'title',
        'order',
    ];

    /**
     * Relationship: MFO Period
     */
    public function mfoPeriod()
    {
        return $this->belongsTo(MfoPeriod::class, 'mfo_period_id');
    }

    /**
     * Relationship: Department
     */
    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    /**
     * Self-referencing parent
     */
    public function parent()
    {
        return $this->belongsTo(CoreFunction::class, 'parent_id');
    }

    /**
     * Self-referencing children
     */
    public function children()
    {
        return $this->hasMany(CoreFunction::class, 'parent_id');
    }

    
    public function successIndicators():HasMany
    {
        return $this->hasMany(SuccessIndicator::class);
    }
}
