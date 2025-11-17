<?php

namespace Database\Seeders;

use App\Models\IhrisV2\SuccessIndicator;
use App\Models\SpmsSuccessIndicator;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SuccessIndicatorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
   
        $successIndicators = SpmsSuccessIndicator::all();

        foreach($successIndicators as $indicator){
            if (!DB::connection('ihris_v2')->table('core_functions')->where('id', $indicator->cf_ID)->exists()) {
                continue; // skip invalid references
            }
            
            SuccessIndicator::firstOrCreate(
            ['id' => $indicator->mi_id],
            [
                'core_function_id' => $indicator->cf_ID,
                'indicator' => $indicator->mi_succIn,
            ]);
        }
    }
}
