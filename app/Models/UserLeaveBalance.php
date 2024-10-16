<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserLeaveBalance extends Model
{
    protected $fillable = [
        'employees_id',
        'vacation_leave_balance',
        'sick_leave_balance',
    ];

    use HasFactory;
}
