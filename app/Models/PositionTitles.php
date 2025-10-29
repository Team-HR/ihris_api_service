<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PositionTitles extends Model
{
    protected $table = 'positiontitles'; // Specify the correct table name

    protected $fillable = [
        'position_id',
        'position',
        'functional',
        'alias',
        'level',
        'category',
        'salaryGrade',
    ];

    use HasFactory;
}
