<?php

namespace App\Http\Controllers;

use App\Models\SysEmployee;
use Illuminate\Http\Request;

class SysEmployeeController extends Controller
{
    /**
     * 
     * get list of all active employees for primevue 
     * selects/multiselect components
     * 
     *  */
    public function getAllEmployees()
    {
        $employees = SysEmployee::where('status', 'ACTIVE')->orderBy('lastName')->get();
        $data = [];

        foreach ($employees as $key => $emp) {
            $data[] = [
                "name" => $emp["full_name"],
                "code" => $emp["employees_id"],
            ];
        }

        usort($data, fn($a, $b) => strcmp($a["name"], $b["name"]));

        return $data;
    }
}
