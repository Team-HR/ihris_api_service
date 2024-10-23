<?php

namespace App\Http\Controllers;

use App\Models\SpmsSuccessIndicator;
use Illuminate\Http\Request;

class SuccessIndicatorController extends Controller
{
    public function deleteSuccessIndicator($id)
    {
        $si = SpmsSuccessIndicator::find($id);
        $si->delete();
    }

    public function saveSuccessIndicator(Request $request)
    {

        $inputs = $request->inputs;
        $metrics = $request->metrics;
        #################
        $mi_id = isset($inputs["mi_id"]) ? $inputs["mi_id"] : null;
        $cf_ID = $inputs["cf_ID"];
        $mi_succIn = $inputs["mi_succIn"];
        $mi_incharge = isset($inputs["mi_incharge"]) ? $inputs["mi_incharge"] : [];
        #################
        $mi_incharge = count($mi_incharge) > 0 ? $mi_incharge : null;
        $employees_ids = "";

        if ($mi_incharge) {
            foreach ($mi_incharge as $key =>  $personnel) {
                if ($key != 0) {
                    $employees_ids .= ",";
                }
                $employees_ids .= $personnel["employee_id"];
            }
        }

        $mi_incharge = $employees_ids;
        $mi_quality = "";
        $mi_eff = "";
        $mi_time = "";

        // return $metrics;

        foreach ($metrics as $key => $metric) {
            if ($metric["name"] == "Quality" && $metric["isChecked"]) {
                $mi_quality = flipArr($metric["inputs"]);
            } elseif ($metric["name"] == "Efficiency" && $metric["isChecked"]) {
                $mi_eff = flipArr($metric["inputs"]);
            } elseif ($metric["name"] == "Timeliness" && $metric["isChecked"]) {
                $mi_time = flipArr($metric["inputs"]);
            }
        }

        $mi_quality = serialize($mi_quality);
        $mi_eff = serialize($mi_eff);
        $mi_time = serialize($mi_time);

        if ($mi_id) {


            $success_indicator = SpmsSuccessIndicator::find($mi_id);
            if (!$success_indicator) return null;

            $success_indicator->mi_succIn = $mi_succIn;
            $success_indicator->mi_quality = $mi_quality;
            $success_indicator->mi_eff = $mi_eff;
            $success_indicator->mi_time = $mi_time;
            $success_indicator->mi_incharge = $mi_incharge;
            // $success_indicator->save();
            return $success_indicator->save();
        } else {
            // insert new record
            $success_indicator = new SpmsSuccessIndicator();
            $success_indicator->cf_ID = $cf_ID;
            $success_indicator->mi_succIn = $mi_succIn;
            $success_indicator->mi_quality = $mi_quality;
            $success_indicator->mi_eff = $mi_eff;
            $success_indicator->mi_time = $mi_time;
            $success_indicator->mi_incharge = $mi_incharge;
            $success_indicator->corrections = "";
            return $success_indicator->save();
        }
        // return [$mi_quality, $mi_eff, $mi_time];

        // $mi_quality = 'a:6:{i:0;s:0:"";i:1;s:0:"";i:2;s:19:"3 or more revisions";i:3;s:11:"2 revisions";i:4;s:10:"1 revision";i:5;s:11:"No revision";}';
        // $mi_quality = unserialize($mi_quality);
        // return $mi_quality;
        // return  [$mi_quality, $metrics];
        // return $request->all();
    }
}

function flipArr($arr)
{
    $data = [];
    $length = count($arr);
    if (!$arr ||  $length < 1) return "";
    for ($i = 0; $i < $length; $i++) {
        $data[] = $arr[($length - 1) - $i] ? $arr[($length - 1) - $i] : "";
    }
    return $data;
}
