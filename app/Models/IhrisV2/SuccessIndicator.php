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

    // 👇 Automatically load these relationships whenever SuccessIndicator is queried
    protected $with = [
        'qualityMeasures',
        'efficiencyMeasures',
        'timelinessMeasures',
    ];

    public function coreFunction(): BelongsTo
    {
        return $this->belongsTo(CoreFunction::class);
    }

    public function qualityMeasures(): HasMany
    {
        return $this->hasMany(QualityMeasure::class);
    }

    public function efficiencyMeasures(): HasMany
    {
        return $this->hasMany(EfficiencyMeasure::class);
    }

    public function timelinessMeasures(): HasMany
    {
        return $this->hasMany(TimelinessMeasure::class);
    }

    public function successIndicatorUsers()
    {
        return $this->hasMany(SuccessIndicatorUser::class, 'success_indicator_id');
    }

}
