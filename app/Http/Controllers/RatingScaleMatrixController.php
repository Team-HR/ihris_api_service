<?php

namespace App\Http\Controllers;

use App\Models\SpmsCoreFunction;
use App\Models\SpmsMfoPeriod;
use App\Models\SpmsPerformanceReviewStatus;
use App\Models\SpmsSuccessIndicator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RatingScaleMatrixController extends Controller
{
    /**
     * Get RSM rows.
     * parameters period_id
     * @var integer
     */

    public function getRatingScaleMatrix(Request $request)
    {
        $user = Auth::user();
        $employee_id = $user->employees_id;

        $period_id = $request->period_id;
        $period = SpmsMfoPeriod::find($period_id);

        /**
         * department_id from spms_performancereviewstatus table
         * if no spms_performancereviewstatus, 
         * current user employee's department_id from
         * employees table is used
         */

        $pcrStatus = SpmsPerformanceReviewStatus::where('employees_id', $employee_id)->where('period_id', $period_id)->first();


        if ($pcrStatus) {
            $department = $pcrStatus->department;
        } else {
            $department = $user->employee_information->department;
        }



        return [
            // 'pcrStatus' =>  $pcrStatus,
            // 'user' => $user->employee_information,
            'rows' => getRows($period_id, $department->department_id),
            'employee_id' => $employee_id,
            'department' => $department,
            'period_id' => $period->mfoperiod_id,
            'period' => $period->month_mfo,
            'year' => $period->year_mfo
        ];
    }
}

/**
 * 
 * # get top mfos with no parents
 * $sql = "SELECT * from spms_corefunctions where parent_id='' and 
 * mfo_periodId='$period_id' and dep_id='$dep_id' ORDER BY `spms_corefunctions`.`cf_count` ASC ";
 * get top mfos with no parents
 * $sql = "SELECT * from spms_corefunctions where parent_id='' and 
 * mfo_periodId='$period_id' and dep_id='$dep_id' ORDER BY `spms_corefunctions`.`cf_count` ASC ";
 * 
 * */

function getRows($period_id, $department_id)
{
    $topMfos = SpmsCoreFunction::where('parent_id', '')->where('mfo_periodId', $period_id)->where('dep_id', $department_id)->orderBy('cf_count')->get();
    $rows = [];

    foreach ($topMfos as $key => $topMfo) {
        $indent = 0;
        $topMfo['indent'] = $indent;
        $topMfo['is_mfo'] = true;
        // check if has success indicators
        $success_indicators = SpmsSuccessIndicator::where('cf_ID', $topMfo->cf_ID)->get();
        $num_si = count($success_indicators);
        $topMfo['has_si'] = $num_si > 0 ? true : false;
        $topMfo['num_si'] = $num_si;
        $topMfo['success_indicators'] = $success_indicators;
        $rows[] = $topMfo;
        //append each success indicators to rows
        // if ($topMfo['has_si']) {
        //     foreach ($success_indicators as $s => $si) {
        //         $si['is_si'] = true;
        //         $rows[] = $si;
        //     }
        // }
        $rows = getChildren($rows, $topMfo->cf_ID, $indent);
    }

    return $rows;
}

function getChildren(&$rows, $parent_id, $indent)
{
    $indent += 1;
    $children = SpmsCoreFunction::where('parent_id', $parent_id)->orderBy('cf_count')->get();
    foreach ($children as $key => $child) {
        $child['indent'] = $indent;
        $child['is_mfo'] = true;
        // check if has success indicators
        $success_indicators = SpmsSuccessIndicator::where('cf_ID', $child->cf_ID)->get();
        // $child['has_si'] = count($success_indicators) > 0 ? true : false;
        $num_si = count($success_indicators);
        $child['has_si'] = $num_si > 0 ? true : false;
        $child['num_si'] = $num_si;
        $child['success_indicators'] = $success_indicators;
        $rows[] = $child;
        //append each success indicators to rows
        // if ($child['has_si']) {
        //     foreach ($success_indicators as $s => $si) {
        //         $si['is_si'] = true;
        //         $rows[] = $si;
        //     }
        // }
        $rows = getChildren($rows, $child->cf_ID, $indent);
    }
    return $rows;
}
