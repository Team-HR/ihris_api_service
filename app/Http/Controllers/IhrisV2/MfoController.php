<?php

namespace App\Http\Controllers\IhrisV2;

use App\Http\Controllers\Controller;
use App\Models\IhrisV2\MfoPeriod;
use Illuminate\Http\Request;

class MfoController extends Controller
{
    public function getAllMfo (){
        return MfoPeriod::all();
    }
}
