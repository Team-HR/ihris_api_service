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

    public function getSuccessIndicator($id)
    {
        $success_indicator = SpmsSuccessIndicator::where('mi_id', $id)->first();
        return $success_indicator;
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

        return [
            "mi_id" => $mi_id,
            "mi_succIn" => $mi_succIn,
            "mi_quality" => $mi_quality,
            "mi_eff" => $mi_eff,
            "mi_time" => $mi_time,
            "mi_incharge" => $mi_incharge
        ];

        return null;


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



    /*
        FOR pcr_next APP
    */

    public function saveSiToEdit(Request $request)
    {
        $inputs = $request->all();

        $cf_ID = $inputs['cf_ID'];

        $quality = $inputs['quality'];
        $quality = check_string_array($quality);

        $mi_quality = parseToSerialized($quality);

        $efficiency = $inputs['efficiency'];
        $efficiency = check_string_array($efficiency);
        $mi_eff = parseToSerialized($efficiency);

        $timeliness = $inputs['timeliness'];
        $timeliness = check_string_array($timeliness);
        $mi_time = parseToSerialized($timeliness);


        $mi_id = $inputs['mi_id'];
        $mi_succIn = $inputs['successIndicator'];

        $inCharge = $inputs['inCharge'];

        $mi_incharge = array_column($inCharge, 'employee_id');
        if ($mi_incharge) {
            $mi_incharge = implode(',', $mi_incharge);
        }

        // return [
        //     $mi_quality,
        //     $mi_eff,
        //     $mi_time,
        //     $mi_incharge
        // ];



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

function parseToSerialized($arr)
{
    $data = array_map(
        fn($i) => $i === 0 ? '' : ($arr[5 - $i] ?? null),
        range(0, 5)
    );

    if (!empty($data)) {
        $data = serialize($data);
    }

    return $data;
}

/**
 * Checks an array of strings to see if all values are effectively empty (null, empty string, or all whitespace).
 *
 * @param array $stringArray The input array of strings.
 * @return array|null The original array if at least one string has content, or null if all are empty/null/whitespace.
 */
function check_string_array(array $stringArray): ?array
{
    // Iterate through each value in the array
    foreach ($stringArray as $value) {
        // The trim function removes leading and trailing whitespace (spaces, tabs, newlines).
        // If the value, after trimming, is not an empty string, it has content.
        // Also, skip null checks inside the loop; simply let 'trim' handle it, as
        // trim((string)null) results in an empty string, and we are casting to string.

        // However, to be explicit about handling null/non-string values robustly:

        // 1. If the value is explicitly NOT null AND is a string:
        if (is_string($value) && trim($value) !== '') {
            // Found a non-empty string, so the array is not all empty. Return the original array.
            return $stringArray;
        }

        // 2. If the value is NOT null AND NOT a string (e.g., an integer 0, boolean false, etc.):
        // Depending on strictness, you might treat these as 'content' or 'empty'. 
        // For an "array of strings" function, we'll treat a non-string value as content 
        // that prevents a 'null' return, unless it's explicitly null.
        if ($value !== null && !is_string($value)) {
            return $stringArray;
        }

        // If it's null, empty string, or all whitespace, the loop continues.
    }

    // If the loop completes without finding any non-empty content, return null.
    return null;
}
