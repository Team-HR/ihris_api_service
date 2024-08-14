<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpmsMfoPeriod extends Model
{
    // use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'spms_mfo_period';


    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'mfoperiod_id';

    // Disable timestamps
    public $timestamps = false;
}
