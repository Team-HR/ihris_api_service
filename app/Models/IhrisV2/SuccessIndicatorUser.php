<?php

namespace App\Models\IhrisV2;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class SuccessIndicatorUser extends Model
{
    protected $connection = 'ihris_v2';
    protected $table = 'success_indicator_user';
    protected $fillable = ['success_indicator_id', 'user_id'];

    public function successIndicator()
    {
        return $this->belongsTo(SuccessIndicator::class, 'success_indicator_id');
    }

    public function user()
    {
        // manually set connection because the user table is in another database
        return $this->belongsTo(User::class, 'user_id', 'acc_id')->setConnection('mariadb');
    }
}
