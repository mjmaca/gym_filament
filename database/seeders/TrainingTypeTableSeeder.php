<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TrainingTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $branches = [
            [
                'description' => 'Exercise Fitness Coaching',
                'session_number' => '1',
                'session_price' => '350',
                'branch_location' => 'XGW - Francisco Homes SJDM',
                'session_duration' => '10'
            ],
            [
                'description' => 'Exercise Fitness Coaching',
                'session_number' => '12',
                'session_price' => '3500',
                'branch_location' => 'XGW - Francisco Homes SJDM',
                'session_duration' => '40'
            ],
            [
                'description' => 'Exercise Fitness Coaching',
                'session_number' => '26',
                'session_price' => '6500',
                'branch_location' => 'XGW - Francisco Homes SJDM',
                'session_duration' => '80'
            ],
            [
                'description' => 'Exercise Fitness Coaching',
                'session_number' => '60',
                'session_price' => '13500',
                'branch_location' => 'XGW - Francisco Homes SJDM',
                'session_duration' => '120'
            ],
            [
                'description' => 'Exercise Fitness Coaching',
                'session_number' => '90',
                'session_price' => '18500',
                'branch_location' => 'XGW - Francisco Homes SJDM',
                'session_duration' => '200'
            ],

            [
                'description' => 'Total Body Transformation Coaching',
                'session_number' => '1',
                'session_price' => '800',
                'branch_location' => 'XGW - Francisco Homes SJDM',
                'session_duration' => '10'
            ],
            [
                'description' => 'Total Body Transformation Coaching',
                'session_number' => '12',
                'session_price' => '8400',
                'branch_location' => 'XGW - Francisco Homes SJDM',
                'session_duration' => '40'
            ],
            [
                'description' => 'Total Body Transformation Coaching',
                'session_number' => '26',
                'session_price' => '16900',
                'branch_location' => 'XGW - Francisco Homes SJDM',
                'session_duration' => '80'
            ],
            [
                'description' => 'Total Body Transformation Coaching',
                'session_number' => '30',
                'session_price' => '18000',
                'branch_location' => 'XGW - Francisco Homes SJDM',
                'session_duration' => '120'
            ],

            [
                'description' => 'Muay Thai',
                'session_number' => '1',
                'session_price' => '400',
                'branch_location' => 'XGW - Francisco Homes SJDM',
                'session_duration' => '10'
            ],
            [
                'description' => 'Muay Thai',
                'session_number' => '12',
                'session_price' => '4000',
                'branch_location' => 'XGW - Francisco Homes SJDM',
                'session_duration' => '40'
            ],
            [
                'description' => 'Muay Thai',
                'session_number' => '26',
                'session_price' => '7000',
                'branch_location' => 'XGW - Francisco Homes SJDM',
                'session_duration' => '80'
            ],
            [
                'description' => 'Muay Thai',
                'session_number' => '60',
                'session_price' => '14500',
                'branch_location' => 'XGW - Francisco Homes SJDM',
                'session_duration' => '120'
            ],

            [
                'description' => 'Boxing',
                'session_number' => '1',
                'session_price' => '350',
                'branch_location' => 'XGW - Francisco Homes SJDM',
                'session_duration' => '10'
            ],
            [
                'description' => 'Boxing',
                'session_number' => '12',
                'session_price' => '3500',
                'branch_location' => 'XGW - Francisco Homes SJDM',
                'session_duration' => '40'
            ],
            [
                'description' => 'Boxing',
                'session_number' => '26',
                'session_price' => '6500',
                'branch_location' => 'XGW - Francisco Homes SJDM',
                'session_duration' => '80'
            ],
            [
                'description' => 'Boxing',
                'session_number' => '60',
                'session_price' => '13500',
                'branch_location' => 'XGW - Francisco Homes SJDM',
                'session_duration' => '120'
            ],
        ];

        foreach ($branches as $branch) {
            DB::table('training_types')->insert($branch);
        }
    }
}
