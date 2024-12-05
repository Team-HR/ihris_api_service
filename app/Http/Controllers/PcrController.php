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

    // FORMTYPE START
    public function getFormType($period_id, Request $request)
    {
        $employee_id = $request->user()->employees_id;
        // return [$employee_id, $period_id];
        $pcr = SpmsPerformanceReviewStatus::where("period_id", $period_id)->where("employees_id", $employee_id)->first();
        if (!$pcr) {
            return null;
        }
        return $pcr->formType;
    }

    public function saveFormType($period_id, Request $request)
    {
        $formType  = $request->selectedFormType;
        $employee_id = $request->user()->employees_id;
        $department_id = $request->user()->employee_information->department_id;
        $pcr = SpmsPerformanceReviewStatus::where('period_id', $period_id)->where('employees_id', $employee_id)->first();
        if (!$pcr) {
            // if not exist create
            $pcr = new SpmsPerformanceReviewStatus();
            $pcr->period_id = $period_id;
            $pcr->employees_id = $employee_id;
            $pcr->formType = $formType;
            $pcr->HeadAgency = "JOHN T. RAYMOND, JR.";
            $pcr->department_id = $department_id;
            $pcr->save();
        } else {
            // if exist update
            $pcr = SpmsPerformanceReviewStatus::where('period_id', $period_id)->where('employees_id', $employee_id)->first();
            $pcr->formType = $formType;
            $pcr->save();
        }

        return $pcr;
    }
    // FORMTYPE END

    // SIGNATORIES START

    public function getSignatories($period_id, Request $request)
    {
        $employee_id = $request->user()->employees_id;
        $signatories = SpmsPerformanceReviewStatus::where('period_id', $period_id)->where('employees_id', $employee_id)->first();
        return $signatories;
        if ($signatories) {
            return [
                'ImmediateSup' => $signatories['ImmediateSup'],
                'DepartmentHead' => $signatories['DepartmentHead'],
                'HeadAgency' => $signatories['HeadAgency'],
            ];
        }
        // return $signatories;
    }

    public function saveSignatories($period_id, Request $request)
    {
        $employee_id = $request->user()->employees_id;

        $ImmediateSup = $request->inputs['ImmediateSup'] ? $request->inputs['ImmediateSup']['employee_id'] : null;

        $DepartmentHead = $request->inputs['DepartmentHead'] ? $request->inputs['DepartmentHead']['employee_id'] : null;

        $HeadAgency = $request->inputs['HeadAgency'];

        $pcr = SpmsPerformanceReviewStatus::where('period_id', $period_id)->where('employees_id', $employee_id)->first();
        $pcr->ImmediateSup = $ImmediateSup;
        $pcr->DepartmentHead = $DepartmentHead;
        $pcr->HeadAgency = $HeadAgency;
        $pcr->save();

        return $request->all();
    }
    // SIGNATORIES END

    public function getCoreFunctions($period_id, Request $request)
    {   // only for authed personnel accomplishing their pcr
        // get authed employees)id
        $employee_id = $request->user()->employees_id;
        $pcr = SpmsPerformanceReviewStatus::where('period_id', $period_id)->where('employees_id', $employee_id)->first();
        // get spms_performancestatus id if existing using (period_id and employees_id )

        // if none create new 
        $coreFunctions = new RatingScaleMatrixController();
        $rsm =  $coreFunctions->getRatingScaleMatrix($period_id);

        $rows = [];

        foreach ($rsm["rows"] as $mfo) {
            if (isset($mfo["success_indicators"])) {
                if (count($mfo["success_indicators"]) > 0) {
                    foreach ($mfo["success_indicators"] as $success_indicator) {
                        if (count($success_indicator["personnel"]) > 0) {
                            foreach ($success_indicator["personnel"] as $personnel) {
                                if ($personnel["employee_id"] == $employee_id) {
                                    
                                    $mfoExists = false;
                                    // check $rows if mfo already exist if so, mfo is a parent of the following si
                                    foreach ($rows as $key => $row) {
                                        if (!isset($row['mfo'])) {
                                            continue;
                                        }

                                        if ($row['mfo']['cf_ID'] == $mfo['cf_ID']) {
                                            $mfoExists = true;
                                            break;
                                        }
                                    }

                                    $rows[] = [
                                        "mfo" => !$mfoExists ? $mfo : null,
                                        "success_indicator" => $success_indicator,
                                        "acctual_accomplishment" => $personnel["actual_accomplishment"]
                                    ];
                                    // $rows[] = $success_indicator;
                                }
                            }
                        }
                    }
                }
            }
        }


        return $rows;
    }
}
