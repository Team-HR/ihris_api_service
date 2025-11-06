<?php

namespace App\Models\IhrisV2;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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
}
