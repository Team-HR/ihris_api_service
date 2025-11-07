<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Models\IhrisV2\SuccessIndicator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
// use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    protected $connection = 'mariadb';
    // mariadb
    // use HasApiTokens, 
    use HasFactory, Notifiable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'spms_accounts';


    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'acc_id';


    // Disable timestamps
    public $timestamps = false;


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'employees_id',
        'username',
        'type',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'type',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            // 'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }


    protected $appends = [
        'employee_information',
        'role'
    ];

    public function getEmployeeInformationAttribute()
    {
        if (!$this->employees_id) return null;
        return SysEmployee::find($this->employees_id);
    }

    public function getRoleAttribute(): array
    {
        return explode(',', $this->attributes['type']);
    }

   public function successIndicators()
    {
        return $this->belongsToMany(
            SuccessIndicator::class,
            'success_indicator_user',
            'user_id',
            'success_indicator_id'
        )->withTimestamps()
        ->setConnection('ihris_v2'); 
    }

}
