<?php

namespace App\Http\Controllers;

use App\Models\SpmsPerformanceReviewStatus;
use Illuminate\Http\Request;

class PcrController extends Controller
{
    public function getPcr($period_id, Request $request)
    {
        $employee_id = $request->user()->employees_id;
        $pcr = SpmsPerformanceReviewStatus::where('period_id', $period_id)->where('employees_id', $employee_id)->first();
       
        return $pcr;
    }
}
