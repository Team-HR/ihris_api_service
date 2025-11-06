<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpmsCoreFunction extends Model
{
    // use HasFactory;
    protected $connection = 'mariadb';
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'spms_corefunctions';


    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'cf_ID';

    // Disable timestamps
    public $timestamps = false;
}
