<?php

namespace Database\Seeders;

use App\Models\IhrisV2\EfficiencyMeasure;
use App\Models\IhrisV2\QualityMeasure;
use App\Models\IhrisV2\SuccessIndicator;
use App\Models\SpmsSuccessIndicator;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EfficiencyMeasureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $indicators = SuccessIndicator::all();

        foreach ($indicators as $indicator) {
            $oldRecord = SpmsSuccessIndicator::find($indicator->id);

            if (!$oldRecord || empty($oldRecord->mi_eff)) {
                continue;
            }

            $efficiencyData = @unserialize($oldRecord->mi_eff);

            if (!is_array($efficiencyData)) {
                continue;
            }

            foreach ($efficiencyData as $index => $value) {
                if (!empty($value)) {
                    EfficiencyMeasure::updateOrCreate(
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
