<?php

namespace App\Http\Controllers\IhrisV2;

use App\Http\Controllers\Controller;
use App\Models\IhrisV2\SuccessIndicatorUser;
use App\Models\User;
use Illuminate\Http\Request;

class SuccessIndicatorController extends Controller
{
    public function getUserSuccessIndicators($userId)
    {
        // Fetch all success indicators linked to this user
        $records = SuccessIndicatorUser::with(['successIndicator.qualityMeasures', 'successIndicator.efficiencyMeasures', 'successIndicator.timelinessMeasures'])
            ->where('user_id', $userId)
            ->get();

        // Map only success indicators if you want to simplify the output
        $indicators = $records->pluck('successIndicator')->filter()->values();

        return response()->json($indicators);
    }
}
