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
}
