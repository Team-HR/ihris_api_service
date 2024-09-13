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
                "employee_id" => $emp["employees_id"],
                "full_name" => $emp["full_name"]
            ];
        }

        usort($data, fn($a, $b) => strcmp($a["full_name"], $b["full_name"]));

        return $data;
    }
}
