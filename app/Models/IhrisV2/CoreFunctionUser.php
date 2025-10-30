<?php

namespace App\Models\IhrisV2;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoreFunctionUser extends Model
{
    use HasFactory;

    // Specify the connection to your secondary DB
    protected $connection = 'ihris_v2';

    // Define the table name
    protected $table = 'core_function_user';

    // Allow mass assignment
    protected $fillable = [
        'core_function_id',
        'user_id',
    ];

    /**
     * Relationship: Core Function (belongsTo)
     */
    public function coreFunction()
    {
        return $this->belongsTo(CoreFunction::class, 'core_function_id');
    }

    /**
     * Relationship: User (belongsTo) — from another DB connection
     */
    public function user()
    {
        // Import App\Models\User (from 'ihris' DB)
        return $this->belongsTo(User::class, 'user_id');
    }
}
