<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GymAccessPlanTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $branches = [
            [
                'description' => '1 Day Access',
                'price' => '179',
                'branch_location' => 'XGW - Francisco Homes SJDM',
                'duration' => '1'
            ],
            [
                'description' => '1 Month Access',
                'price' => '1699',
                'branch_location' => 'XGW - Francisco Homes SJDM',
                'duration' => '30'
            ],
            [
                'description' => '3 Months Access',
                'price' => '4199',
                'branch_location' => 'XGW - Francisco Homes SJDM',
                'duration' => '90'
            ],
            [
                'description' => '6 Months Access',
                'price' => '6999',
                'branch_location' => 'XGW - Francisco Homes SJDM',
                'duration' => '180'
            ],
            [
                'description' => '1 Year Access',
                'price' => '10799',
                'branch_location' => 'XGW - Francisco Homes SJDM',
                'duration' => '360'
            ],
        ];

        foreach ($branches as $branch) {
            DB::table('gym_access_plans')->insert($branch);
        }
    }
}
