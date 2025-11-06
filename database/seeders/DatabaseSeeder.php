<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(MfoPeriodSeeder::class);
        $this->call(DepartmentSeeder::class);
        $this->call(CoreFunctionSeeder::class);
        $this->call(SuccessIndicatorUserSeeder::class);
        $this->call(QualityMeasureSeeder::class);
    }
}
