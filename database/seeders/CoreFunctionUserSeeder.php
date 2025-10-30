<?php

namespace Database\Seeders;

use App\Models\IhrisV2\CoreFunctionUser;
use App\Models\SpmsSuccessIndicator;
use Illuminate\Database\Seeder;

class CoreFunctionUserSeeder extends Seeder
{
    public function run(): void
    {
        $matrixIndicators = SpmsSuccessIndicator::all();

        foreach ($matrixIndicators as $indicator) {
            $userIds = array_filter(
                array_map('trim', explode(',', $indicator->mi_incharge))
            );

            foreach ($userIds as $id) {
                CoreFunctionUser::updateOrCreate(
                    [
                        'user_id' => $id,
                        'core_function_id' => $indicator->cf_ID,
                    ],
                    [] // nothing else to update
                );
            }
        }
    }
}
