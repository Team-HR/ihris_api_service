<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpmsCoreFunctionData extends Model
{
    // use HasFactory;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'spms_corefucndata';


    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'cfd_id';

    // Disable timestamps
    public $timestamps = false;


    protected $appends = [
        'A',
    ];


    public function getAAttribute()
    {
        // return 1;
        return null;

        $average = null;

        $num = 0;
        $sum = 0;

        if ($this->Q) {
            $num += 1;
            $sum += $this->Q;
        }

        if ($this->E) {
            $num += 1;
            $sum += $this->E;
        }

        if ($this->T) {
            $num += 1;
            $sum += $this->T;
        }

        if ($num == 0 && !$this->percent) return null;

        $average = ($sum / $num) * ($this->percent / 100);
        // $average = number_format($average, 2);
        $average = bcdiv($average, 1, 2);

        return $average;
    }
}
