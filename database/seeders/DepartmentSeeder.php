<?php

namespace Database\Seeders;

use App\Models\IhrisV2\Department;
use App\Models\SysDepartment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departments = SysDepartment::all();

        foreach($departments as $dept){
            Department::updateOrCreate(
            ['id' => $dept->id,],
            [
                'parent_id' => $dept->parent_department_id,
                'name' => $dept->department,
                'alias' => $dept->alias,
            ]);
        }
    }
}
