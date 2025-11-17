<?php

namespace App\Http\Controllers\IhrisV2;

use App\Http\Controllers\Controller;
use App\Models\IhrisV2\CoreFunction;
use App\Models\IhrisV2\SuccessIndicatorUser;
use Illuminate\Http\Request;

class CoreFunctionController extends Controller
{
    public function getCoreFunctions($mfoPeriodId, $departmentId)
    {
        $coreFunctions = CoreFunction::with([
            'successIndicators.successIndicatorUsers.user', // nested eager load with user
        ])
            ->where('mfo_period_id', $mfoPeriodId)
            ->where('department_id', $departmentId)
            ->get();

        // Transform data so that each success indicator has a direct `users` array
        // foreach ($coreFunctions as $core) {
        //     foreach ($core->successIndicators as $indicator) {
        //         $indicator->users = $indicator->successIndicatorUsers->map(function ($successIndicatorUser) {
        //             $user = $successIndicatorUser->user;
        //             if ($user && $user->employee_information) {
        //                 // Include employee information from SysEmployee
        //                 $successIndicatorUser->employee = $user->employee_information;
        //             }
        //             return $successIndicatorUser;
        //         });
        //         unset($indicator->successIndicatorUsers); // optional cleanup
        //     }
        // }

        return response()->json($coreFunctions);
    }

}
