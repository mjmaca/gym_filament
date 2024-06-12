<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BranchTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $branches = [
            ['code' => 'XGW - FH', 'name' => 'XGW - Francisco Homes SJDM'],
            ['code' => 'XGW - HQ', 'name' => 'XGW - Healthway Qualimed SJDM'],
            ['code' => 'XGW - MZ', 'name' => 'XGW - Muzon SJDM'],
            ['code' => 'XGW - P1', 'name' => 'XGW - Poblacion 1 SJDM'],
            ['code' => 'XGW - BL', 'name' => 'XGW - Baliuag Bulacan'],
            ['code' => 'XGW - BE', 'name' => 'XGW - Bocaue Bulacan'],
            ['code' => 'XGW - SM', 'name' => 'XGW - Santa Maria Bulacan'],
            ['code' => 'ATL - BC', 'name' => 'ATL - Bacoor Cavite'],
            ['code' => 'CF - SP', 'name' => 'CF - Sapangpalay SJDM'],
            ['code' => 'FP - LP', 'name' => 'FP - BF Resorts Laspiñas'],
        ];

        foreach ($branches as $branch) {
            DB::table('branches')->insert($branch);
        }
    }
}
