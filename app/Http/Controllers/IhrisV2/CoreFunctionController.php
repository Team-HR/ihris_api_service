<?php

namespace App\Http\Controllers\IhrisV2;

use App\Http\Controllers\Controller;
use App\Models\IhrisV2\CoreFunction;
use Illuminate\Http\Request;

class CoreFunctionController extends Controller
{
    public function getCoreFunctions($mfoPeriodId, $departmentId){
        $coreFunctions = CoreFunction::where('mfo_period_id',$mfoPeriodId)->where('department_id',$departmentId)->get();

        return $coreFunctions;
    }
}
