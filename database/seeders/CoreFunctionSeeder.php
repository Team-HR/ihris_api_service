<?php

namespace Database\Seeders;

use App\Models\IhrisV2\CoreFunction;
use App\Models\IhrisV2\Department;
use App\Models\IhrisV2\MfoPeriod;
use App\Models\SpmsCoreFunction;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CoreFunctionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $CoreFns = SpmsCoreFunction::all();


        foreach ($CoreFns as $function) {
            // Skip if department doesn't exist
            if (! Department::find($function->dep_id)) continue;

            // Validate MFO period
            $mfoPeriodId = (int) $function->mfo_periodId;
            if ($mfoPeriodId <= 0 || ! MfoPeriod::find($mfoPeriodId)) continue;

            CoreFunction::firstOrCreate(
                ['id' => $function->cf_ID],
                [
                    'mfo_period_id' => $mfoPeriodId,
                    'parent_id' => null, // temporarily null
                    'department_id' => $function->dep_id,
                    'title' => $function->cf_title,
                    'order' => $function->cf_count,
                ]
            );
        }

        // Update parent_id only if the parent exists
        foreach ($CoreFns as $function) {
            $parentId = is_numeric($function->parent_id) ? (int)$function->parent_id : null;

            if ($parentId && CoreFunction::find($parentId)) {
                CoreFunction::where('id', $function->cf_ID)
                    ->update([
                        'parent_id' => $parentId,
                    ]);
            }
        }


    }
}
