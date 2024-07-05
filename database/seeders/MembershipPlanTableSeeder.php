<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MembershipPlanTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $branches = [
            [
                'type' => 'Silver Membership',
                'price' => '499',
                'branch_location' => 'XGW - Francisco Homes SJDM',
                'duration' => '6'
            ],
            [
                'type' => 'Gold Membership',
                'price' => '799',
                'branch_location' => 'XGW - Francisco Homes SJDM',
                'duration' => '12'
            ],
            [
                'type' => 'VIP Silver Membership',
                'price' => '0',
                'branch_location' => 'XGW - Francisco Homes SJDM',
                'duration' => '12'
            ],
            [
                'type' => 'VIP White Membership',
                'price' => '0',
                'branch_location' => 'XGW - Francisco Homes SJDM',
                'duration' => '12'
            ],
            [
                'type' => 'VIP Black Membership',
                'price' => '0',
                'branch_location' => 'XGW - Francisco Homes SJDM',
                'duration' => '12'
            ],
        ];

        foreach ($branches as $branch) {
            DB::table('membership_plans')->insert($branch);
        }
    }
}
