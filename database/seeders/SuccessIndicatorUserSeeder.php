<?php

namespace Database\Seeders;

use App\Models\IhrisV2\SuccessIndicator;
use App\Models\IhrisV2\SuccessIndicatorUser;
use App\Models\SpmsSuccessIndicator;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SuccessIndicatorUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $indicators = SuccessIndicator::all();

        foreach($indicators as $indicator){
            $indicatorOldRecord =  SpmsSuccessIndicator::find($indicator->id);

            $userIds = array_filter(explode(',', $indicatorOldRecord->mi_incharge));
            
            foreach($userIds as $id){
                SuccessIndicatorUser::updateOrCreate([
                    'success_indicator_id' => $indicator->id,
                    'user_id' => $id
                ],[]);
            }
        }
    }
}
