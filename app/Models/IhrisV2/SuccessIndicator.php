<?php

namespace App\Models\IhrisV2;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class SuccessIndicator extends Model
{
    use SoftDeletes;

    protected $connection = 'ihris_v2';
    protected $fillable = [
        'core_function_id',
        'indicator',
    ];


    public function coreFunction():BelongsTo
    {
        return $this->belongsTo(CoreFunction::class);
    }

    public function users():BelongsToMany
    {
        return $this->belongsToMany(
            User::class,
            'success_indicator_user',
            'success_indicator_id',
            'user_id'
        )->usingConnection('ihris_v2');
    }

    public function qualityMeasures():HasMany
    {
        return $this->hasMany(QualityMeasure::class);
    }

    public function efficiencyMeasures():HasMany
    {
        return $this->hasMany(EfficiencyMeasure::class);
    }

    public function timelinessMeasures():HasMany
    {
        return $this->hasMany(TimelinessMeasure::class);
    }
}
