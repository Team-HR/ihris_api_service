<?php

namespace App\Http\Controllers\IhrisV2;

use App\Http\Controllers\Controller;
use App\Models\IhrisV2\CoreFunction;
use App\Models\IhrisV2\MfoPeriod;
use App\Models\User;
use Illuminate\Http\Request;

class MfoController extends Controller
{
    // public function getCoreFunctions(Request $request, $mfoPeriodId, $departmentId)
    // {
    //     // Get 'with' query params (e.g., ?with[]=coreFunctions&with[]=coreFunctions.children)
    //     $with = $request->query('with', []);

    //     if (!is_array($with)) {
    //         $with = [$with];
    //     }

    //     // Fetch the MFO period
    //     $mfo = MfoPeriod::findOrFail($mfoPeriodId);

    //     // If the 'with' parameter contains relationships, load them conditionally
    //     if (!empty($with)) {
    //         $mfo->load([
    //             // Always load coreFunctions, but filtered by department
    //             'coreFunctions' => function ($query) use ($departmentId) {
    //                 $query->where('department_id', $departmentId);
    //             },
    //             // Also load nested relationships (like coreFunctions.children) if requested
    //             ...collect($with)
    //                 ->filter(fn($relation) => $relation !== 'coreFunctions')
    //                 ->mapWithKeys(fn($relation) => [$relation => function () {}])
    //                 ->toArray(),
    //         ]);
    //     }

    //     return response()->json($mfo);
    // }




}
