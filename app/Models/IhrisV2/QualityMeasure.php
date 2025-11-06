<?php

namespace App\Models\IhrisV2;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class QualityMeasure extends Model
{
    use SoftDeletes;

    protected $connection = 'ihris_v2';
    
    protected $fillable = [
        'id',
        'success_indicator_id',
        'measure',
        'score',
    ];

    public function successIndicator():BelongsTo
    {
        return $this->belongsTo(SuccessIndicator::class);
    }
}
