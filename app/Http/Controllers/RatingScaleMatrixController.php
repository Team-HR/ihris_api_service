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

    public function deleteMfo($cf_ID)
    {
        $mfo = SpmsCoreFunction::find($cf_ID);
        if ($mfo->delete()) {
            // Return a success response
            return response()->json(['message' => 'Record deleted successfully!', 'data' => $mfo], 201);
        } else {
            // Return a failure response if save() returns false (uncommon)
            return response()->json(['message' => 'Failed to delete record.'], 500);
        }
    }

    public function addNewSubMfo(Request $request)
    {
        $mfo_periodId = $request->period_id;
        $parent_id = $request->parent_id;
        $dep_id = getAuthPersonnelDepartmentId($mfo_periodId);
        $cf_count = $request->cf_count;
        $cf_title = $request->cf_title;
        // return $request->all();
        $mfo = new SpmsCoreFunction();
        $mfo->mfo_periodId = $mfo_periodId;
        $mfo->parent_id = $parent_id;
        $mfo->dep_id = $dep_id;
        $mfo->cf_count = $cf_count;
        $mfo->cf_title = $cf_title;
        $mfo->corrections = "";

        if ($mfo->save()) {
            // Return a success response
            return response()->json(['message' => 'Record added successfully!', 'data' => $mfo], 201);
        } else {
            // Return a failure response if save() returns false (uncommon)
            return response()->json(['message' => 'Failed to add record.'], 500);
        }
    }


    public function addNewMfo(Request $request)
    {
        // $mfo = new SpmsCoreFunction();
        // {"newMfo":{"period_id":"18","cf_count":"x","cf_title":"xsasd"}}
        $period_id = $request['newMfo']['period_id'];
        $cf_count = $request['newMfo']['cf_count'];
        $cf_title = $request['newMfo']['cf_title'];

        $user = Auth::user();
        $employee_id = $user->employees_id;

        /**
         * department_id from spms_performancereviewstatus table
         * if no spms_performancereviewstatus, 
         * current user employee's department_id from
         * employees table is used
         */

        $pcrStatus = SpmsPerformanceReviewStatus::where('employees_id', $employee_id)->where('period_id', $period_id)->first();

        if ($pcrStatus) {
            $department_id = $pcrStatus->department_id;
        } else {
            $department_id = $user->employee_information->department_id;
        }


        $mfo = new SpmsCoreFunction();

        $mfo->mfo_periodId = $period_id;
        $mfo->parent_id = "";
        $mfo->dep_id = $department_id;
        $mfo->cf_count = $cf_count;
        $mfo->cf_title = $cf_title;
        $mfo->corrections = "";

        // Attempt to save the model
        if ($mfo->save()) {
            // Return a success response
            return response()->json(['message' => 'Record added successfully!', 'data' => $mfo], 201);
        } else {
            // Return a failure response if save() returns false (uncommon)
            return response()->json(['message' => 'Failed to save record.'], 500);
        }
        // return  $request->all();
    }


    /**
     * 
     * update MFO title and/or cf_count
     * 
     */

    public function updateMfo(Request $request, $cf_ID)
    {
        $mfo = SpmsCoreFunction::find($cf_ID);
        $mfo->cf_count = $request->cf_count;
        $mfo->cf_title = $request->cf_title;
        if ($mfo->save()) {
            // Return a success response
            return response()->json(['message' => 'Record updated successfully!', 'data' => $mfo], 201);
        } else {
            // Return a failure response if save() returns false (uncommon)
            return response()->json(['message' => 'Failed to update record.'], 500);
        }
    }


    /**
     * 
     *  Get RSM Title
     *  and Period
     * 
     * */

    public function getRatingScaleMatrixTitle($period_id)
    {
        $user = Auth::user();
        $employee_id = $user->employees_id;

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
            'department' => $department,
            'period_id' => $period->mfoperiod_id,
            'period' => $period->month_mfo,
            'year' => $period->year_mfo
        ];
    }

    /**
     * 
     * Get Cascaded MFOs list
     * for changing mfo parent
     * 
     * */
    public function getRatingScaleMatrixMfosOnly(Request $request)
    {
        $cf_ID = $request->cf_ID;
        $parent_id = $request->parent_id;
        $period_id = $request->period_id;

        $user = Auth::user();
        $employee_id = $user->employees_id;

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
            'rows' => getRowsMfosOnly($period_id, $department->department_id, $cf_ID, $parent_id),
        ];
    }

    /**
     * Get RSM rows.
     * parameters period_id
     * @var integer
     */

    public function getRatingScaleMatrix($period_id)
    {
        $user = Auth::user();
        $employee_id = $user->employees_id;

        // $period_id = $request->period_id;

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
            'rows' => getRows($period_id, $department->department_id),
        ];
    }


    /**
     * 
     *  Move MFO to 
     *  new parent MFO
     * 
     * */

    public function moveMfoToNewParent(Request $request)
    {
        $cf_ID = $request->cf_ID;
        $new_parent_id = $request->new_parent_id;

        $mfo = SpmsCoreFunction::find($cf_ID);
        $mfo->parent_id = $new_parent_id ? $new_parent_id : '';
        $mfo->save();

        // Attempt to save the model
        if ($mfo->save()) {
            // Return a success response
            return response()->json(['message' => 'Record moved successfully!', 'data' => $mfo], 201);
        } else {
            // Return a failure response if save() returns false (uncommon)
            return response()->json(['message' => 'Failed to move record.'], 500);
        }
    }



    public function getIndividualRatingScaleMatrix($period_id)
    {
        $user = Auth::user();
        $employee_id = $user->employees_id;

        // $period_id = $request->period_id;

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


        return getPersonnelCores($period_id, $department->department_id);

        // return [
        //     'rows' => getPersonnelCores($period_id, $department->department_id),
        // ];
    }
}


function getPersonnelCores($period_id, $department_id)
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

/**
 * getMfos only
 * no success indicators
 * for mfo parent reassigning
 * */

function getRowsMfosOnly($period_id, $department_id, $cf_ID)
{
    $topMfos = SpmsCoreFunction::where('parent_id', '')->where('mfo_periodId', $period_id)->where('dep_id', $department_id)->orderBy('cf_count')->get();
    $rows = [];

    foreach ($topMfos as $key => $topMfo) {
        $indent = 0;
        $topMfo['indent'] = $indent;
        $isDisabled = false;
        $isDisabled = $topMfo->cf_ID ==  $cf_ID  ? true : false;
        $topMfo['isDisabled'] = $isDisabled;
        $rows[] = $topMfo;
        $rows = getChildrenMfosOnly($rows, $topMfo->cf_ID, $indent, $isDisabled, $cf_ID);
    }

    return $rows;
}

function getChildrenMfosOnly(&$rows, $parent_id, $indent, $isDisabled, $cf_ID)
{
    $indent += 1;
    $children = SpmsCoreFunction::where('parent_id', $parent_id)->orderBy('cf_count')->get();
    foreach ($children as $key => $child) {
        $child['indent'] = $indent;
        $isDisabled = false;
        $isDisabled = $child->cf_ID ==  $cf_ID || $child->parent_id == $cf_ID ? true : false;
        $child['isDisabled'] = $isDisabled;
        $rows[] = $child;
        $rows = getChildrenMfosOnly($rows, $child->cf_ID, $indent,  $isDisabled, $cf_ID);
    }
    return $rows;
}


function getAuthPersonnelDepartmentId($period_id)
{
    $user = Auth::user();
    $employee_id = $user->employees_id;

    /**
     * department_id from spms_performancereviewstatus table
     * if no spms_performancereviewstatus, 
     * current user employee's department_id from
     * employees table is used
     */

    $pcrStatus = SpmsPerformanceReviewStatus::where('employees_id', $employee_id)->where('period_id', $period_id)->first();

    if ($pcrStatus) {
        $department_id = $pcrStatus->department_id;
    } else {
        $department_id = $user->employee_information->department_id;
    }

    return $department_id;
}
