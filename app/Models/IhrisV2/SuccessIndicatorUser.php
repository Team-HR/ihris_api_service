<?php

namespace App\Models\IhrisV2;

use Illuminate\Database\Eloquent\Model;

class SuccessIndicatorUser extends Model
{
    protected $connection = 'ihris_v2';
    protected $table = 'success_indicator_user';
    protected $fillable = ['success_indicator_id', 'user_id'];
}
