<?php

namespace App\Http\Controllers\IhrisV2;

use App\Http\Controllers\Controller;
use App\Models\IhrisV2\MfoPeriod;
use App\Models\User;
use Illuminate\Http\Request;

class MfoController extends Controller
{
    public function getAllMfo (){
        return MfoPeriod::all();
    }

    public function getMfo(Request $request, $mfoId)
    {
        // Get the 'with' query parameter — e.g. ?with[]=coreFunctions&with[]=coreFunctions.children
        $with = $request->query('with', []);

        // Validate that 'with' is an array (avoid errors if someone passes a string)
        if (!is_array($with)) {
            $with = [$with];
        }

        // Fetch the MFO with optional relationships
        $mfo = MfoPeriod::with($with)->findOrFail($mfoId);

        return response()->json($mfo);
    }

}
