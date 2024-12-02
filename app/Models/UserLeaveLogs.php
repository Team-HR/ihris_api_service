<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserLeaveLogs extends Model
{
    protected $fillable = [
        'employees_id',
        'leave_id',
        'vl_total_earned',
        'vl_deduction',
        'vl_balance',
        'sl_total_earned',
        'sl_deduction',
        'sl_balance',
        'days_with_pay',
        'days_without_pay',
        'others',
    ];

    use HasFactory;
}
