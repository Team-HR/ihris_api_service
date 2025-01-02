<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpmsImmediateSupervisors extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'spms_performancereviewstatus';
    /**
     * The primary id for the model.
     *
     * @var string
     */
    protected $primaryKey = 'performanceReviewStatus_id';



    use HasFactory;
}
