<?php

namespace App\Models\IhrisV2;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class MfoPeriod extends Model
{
    use SoftDeletes, HasFactory;

    protected $connection = 'ihris_v2';
    
    protected $fillable = [
        'id',
        'semester',
        'year'
    ];
    
    public function coreFunctions ():HasMany
    {
        return $this->hasMany(CoreFunction::class);
    }
}
