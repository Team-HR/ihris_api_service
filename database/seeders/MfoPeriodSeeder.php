<?php

namespace Database\Seeders;

use App\Models\IhrisV2\MfoPeriod;
use App\Models\SpmsMfoPeriod;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MfoPeriodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $mfos = SpmsMfoPeriod::all();

        foreach($mfos as $period){
            MfoPeriod::updateOrCreate(
            ['id' => $period->mfoperiod_id,],
            [
                'semester' => $period->month_mfo == 'January - June' ? 1 : 2,
                'year' => $period->year_mfo,
            ]);
        }
    }
}
