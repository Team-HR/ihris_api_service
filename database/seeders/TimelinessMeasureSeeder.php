<?php

namespace Database\Seeders;

use App\Models\IhrisV2\SuccessIndicator;
use App\Models\IhrisV2\TimelinessMeasure;
use App\Models\SpmsSuccessIndicator;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TimelinessMeasureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $indicators = SuccessIndicator::all();

        foreach ($indicators as $indicator) {
            $oldRecord = SpmsSuccessIndicator::find($indicator->id);

            if (!$oldRecord || empty($oldRecord->mi_time)) {
                continue;
            }

            $timelinessData = @unserialize($oldRecord->mi_time);

            if (!is_array($timelinessData)) {
                continue;
            }

            foreach ($timelinessData as $index => $value) {
                if (!empty($value)) {
                    TimelinessMeasure::updateOrCreate(
                        [
                            'success_indicator_id' => $indicator->id,
                            'score' => $index, // uniquely identify by indicator + score
                        ],
                        [
                            'measure' => $value,
                        ]
                    );
                }
            }
        }
    }
}
