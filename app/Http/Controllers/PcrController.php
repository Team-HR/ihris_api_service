<?php

namespace App\Http\Controllers;

use App\Models\SpmsCoreFunction;
use App\Models\SpmsCoreFunctionData;
use App\Models\SpmsPerformanceReviewStatus;
use App\Models\SpmsStrategicFunction;
use Illuminate\Http\Request;

class PcrController extends Controller
{
    public function getPcr($period_id, Request $request)
    {
        $employee_id = $request->user()->employees_id;
        $pcr = SpmsPerformanceReviewStatus::where('period_id', $period_id)->where('employees_id', $employee_id)->first();
        return $pcr;
    }

    public function getStrategic($period_id, $employeesId)
    {
        // $strat = SpmsStrategicFunction::select('*', 'strategicFunc_id as id')->where('period_id', $period_id)->where('emp_id', $employeesId)->first();
        $strat = SpmsStrategicFunction::where('period_id', $period_id)->where('emp_id', $employeesId)->first();
        return $strat;
    }

    public function createStratAccomplishment(Request $request)
    {
        if ($request->strategicFunc_id) {
            $strat = SpmsStrategicFunction::find($request->strategicFunc_id);
        } else {
            $strat = new SpmsStrategicFunction();
        }
        $strat->period_id = $request->period_id;
        $strat->emp_id = $request->emp_id;
        $strat->mfo = $request->mfo;
        $strat->succ_in = $request->succ_in;
        $strat->acc = $request->acc;
        $strat->average = $request->average;
        if ($request->remark) {
            $strat->remark = $request->remark;
        }
        $strat->noStrat = $request->noStrat;
        $strat->save();
        return $strat;
    }

    public function deleteStratAccomplishment($id)
    {
        $strat = SpmsStrategicFunction::find($id);
        if ($strat) {
            $strat->delete();
            return response()->json(['success' => true, 'message' => 'Strategic accomplishment deleted.']);
        }
        return response()->json(['success' => false, 'message' => 'Strategic accomplishment not found.'], 404);
    }

    public function createAccomplishment(Request $request)
    {

        // "p_id": 41869,
        // "empId": 9,
        // "actualAcc": "Testing 2nd SA",
        // "Q": "1",
        // "E": null,
        // "T": "0",
        // "remarks": null,
        // "percent": 10

        $acc = new SpmsCoreFunctionData();
        $acc->p_id = $request->p_id;
        $acc->empId = $request->empId;
        $acc->actualAcc = $request->actualAcc;
        if ($request->Q !== null && $request->Q !== '') {
            $acc->Q = $request->Q;
        }
        if ($request->E !== null && $request->E !== '') {
            $acc->E = $request->E;
        }
        if ($request->T !== null && $request->T !== '') {
            $acc->T = $request->T;
        }
        $acc->remarks = $request->remarks;
        $acc->percent = $request->percent;
        $acc->save();

        return [
            'success' => true,
            'message' => 'Accomplishment created successfully.',
            'data' => $acc
        ];
    }

    public function updateAccomplishment($cf_id, Request $request)
    {
        $acc = SpmsCoreFunctionData::find($cf_id);

        // return $acc;

        if (!$acc) {
            return response()->json([
                'success' => false,
                'message' => 'Accomplishment not found.'
            ], 404);
        }

        if ($request->has('p_id')) {
            $acc->p_id = $request->p_id;
        }
        if ($request->has('empId')) {
            $acc->empId = $request->empId;
        }
        if ($request->has('actualAcc')) {
            $acc->actualAcc = $request->actualAcc;
        }
        if ($request->has('Q') && $request->Q !== null && $request->Q !== '') {
            $acc->Q = $request->Q;
        } elseif ($request->has('Q') && ($request->Q === null || $request->Q === '')) {
            $acc->Q = null;
        }
        if ($request->has('E') && $request->E !== null && $request->E !== '') {
            $acc->E = $request->E;
        } elseif ($request->has('E') && ($request->E === null || $request->E === '')) {
            $acc->E = null;
        }
        if ($request->has('T') && $request->T !== null && $request->T !== '') {
            $acc->T = $request->T;
        } elseif ($request->has('T') && ($request->T === null || $request->T === '')) {
            $acc->T = null;
        }
        if ($request->has('remarks')) {
            $acc->remarks = $request->remarks;
        }
        if ($request->has('percent')) {
            $acc->percent = $request->percent;
        }

        $acc->save();

        return response()->json([
            'success' => true,
            'message' => 'Accomplishment updated successfully.',
            'data' => $acc
        ]);
    }

    public function deleteAccomplishment($cfd_id)
    {
        $coreFunctionData = \App\Models\SpmsCoreFunctionData::find($cfd_id);
        if ($coreFunctionData) {
            $coreFunctionData->delete();
            return response()->json(['success' => true, 'message' => 'Accomplishment deleted.']);
        }
        return response()->json(['success' => false, 'message' => 'Accomplishment not found.'], 404);
        // return "delete " . $cfd_id;
    }

    public function createNaAccomplishment(Request $request)
    {

        $naAcc = new SpmsCoreFunctionData;

        $naAcc->p_id = $request->p_id;
        $naAcc->empId = $request->user()->employees_id;
        $naAcc->remarks = $request->remarks;
        $naAcc->disable = 1;
        $naAcc->save();
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
        $employee_id = 9; // Filter by employee_id = 9
        $pcr = SpmsPerformanceReviewStatus::where('period_id', $period_id)->where('employees_id', $employee_id)->first();
        // get spms_performancestatus id if existing using (period_id and employees_id )

        // if none create new
        $coreFunctions = new RatingScaleMatrixController();
        $rsm =  $coreFunctions->getRatingScaleMatrix($period_id);

        $rows = [];
        $includedMfoIds = []; // Track which MFOs have been included

        foreach ($rsm["rows"] as $mfo) {
            if (isset($mfo["success_indicators"])) {
                if (count($mfo["success_indicators"]) > 0) {
                    foreach ($mfo["success_indicators"] as $success_indicator) {
                        if (count($success_indicator["personnel"]) > 0) {
                            foreach ($success_indicator["personnel"] as $personnel) {
                                if ($personnel["employee_id"] == $employee_id) {
                                    // Get all parent MFOs recursively
                                    $parentMfos = $this->getAllParentMfos($mfo['cf_ID'], $rsm["rows"]);
                                    // Add parent MFOs to rows if not already included
                                    foreach ($parentMfos as $parentMfo) {
                                        if (!in_array($parentMfo['cf_ID'], $includedMfoIds)) {
                                            $rows[] = [
                                                "mfo" => $parentMfo,
                                                "success_indicator" => null,
                                                "acctual_accomplishment" => null
                                            ];
                                            $includedMfoIds[] = $parentMfo['cf_ID'];
                                        }
                                    }

                                    // Add the current MFO if not already included
                                    $mfoExists = in_array($mfo['cf_ID'], $includedMfoIds);
                                    if (!$mfoExists) {
                                        $includedMfoIds[] = $mfo['cf_ID'];
                                    }

                                    $rows[] = [
                                        "mfo" => !$mfoExists ? $mfo : null,
                                        "success_indicator" => $success_indicator,
                                        "acctual_accomplishment" => $personnel["actual_accomplishment"]
                                    ];
                                }
                            }
                        }
                    }
                }
            }
        }


        return $rows;
    }

    /**
     * Get all parent MFOs recursively up to the root
     */
    private function getAllParentMfos($cf_ID, $allMfos)
    {
        $parentMfos = [];
        $currentMfo = null;

        // Find the current MFO in the list
        foreach ($allMfos as $mfo) {
            if ($mfo['cf_ID'] == $cf_ID) {
                $currentMfo = $mfo;
                break;
            }
        }

        if (!$currentMfo || empty($currentMfo['parent_id'])) {
            return $parentMfos; // No parent, return empty array
        }

        // Recursively get parent MFOs
        $parentId = $currentMfo['parent_id'];
        while (!empty($parentId)) {
            $parentMfo = null;

            // Find parent MFO in the list
            foreach ($allMfos as $mfo) {
                if ($mfo['cf_ID'] == $parentId) {
                    $parentMfo = $mfo;
                    break;
                }
            }

            if ($parentMfo) {
                // Add parent to the beginning of the array (so root comes first)
                array_unshift($parentMfos, $parentMfo);
                $parentId = $parentMfo['parent_id'] ?? '';
            } else {
                // If parent not found in the list, try to get it from database
                $parentMfo = SpmsCoreFunction::find($parentId);
                if ($parentMfo) {
                    $parentMfoArray = $parentMfo->toArray();
                    array_unshift($parentMfos, $parentMfoArray);
                    $parentId = $parentMfo->parent_id ?? '';
                } else {
                    break; // Parent not found, stop recursion
                }
            }
        }

        return $parentMfos;
    }
}
