<?php

namespace Database\Seeders;

use App\Models\IhrisV2\QualityMeasure;
use App\Models\IhrisV2\SuccessIndicator;
use App\Models\SpmsSuccessIndicator;
use Illuminate\Database\Seeder;

class QualityMeasureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $indicators = SuccessIndicator::all();

        foreach ($indicators as $indicator) {
            $oldRecord = SpmsSuccessIndicator::find($indicator->id);

            if (!$oldRecord || empty($oldRecord->mi_quality)) {
                continue;
            }

            $qualityData = @unserialize($oldRecord->mi_quality);

            if (!is_array($qualityData)) {
                continue;
            }

            foreach ($qualityData as $index => $value) {
                if (!empty($value)) {
                    QualityMeasure::updateOrCreate(
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
