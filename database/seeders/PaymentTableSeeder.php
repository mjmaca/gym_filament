<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class PaymentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $payments = [
            [
                'membership_id' => 'TUKrneFM',
                'full_name' => 'Ezra Bednar',
                'branch_location' => 'FP - BF Resorts Laspiñas',
                'gym_membership_discount' => 0,
                'gym_membership_expiration_date' => '2025-01-01',
                'gym_membership_start_date' => '2024-07-01',
                'gym_membership_price' => 499.0,
                'gym_membership_type' => 'Silver Membership',
                'gym_membership_extension' => 0,
                'gym_access_discount' => 5,
                'gym_access_expiration_date' => '2025-07-01',
                'gym_access_start_date' => '2024-07-01',
                'gym_access_price' => 10799.0,
                'gym_access_plan' => '1 Year Access',
                'gym_access_extension' => 0,
                'pt_session_coach_name' => null,
                'pt_session_price' => 3500.0,
                'pt_session_expiration_date' => '2024-08-10',
                'pt_session_start_date' => null,
                'pt_session_extension' => 0,
                'pt_session_type' => 'Exercise Fitness Coaching',
                'pt_session_total' => 12,
                'pt_session_used' => 0,
                'payment_method' => 'Cash',
                'amount' => 14258.05,
                'created_at' => '2024-07-01 05:33:04.000',
                'updated_at' => '2024-07-01 05:33:04.000'
            ],
            [
                'membership_id' => '23e6Kqv4',
                'full_name' => 'Malika Reynolds',
                'branch_location' => 'ATL - Bacoor Cavite',
                'gym_membership_discount' => 0,
                'gym_membership_expiration_date' => '2025-07-01',
                'gym_membership_start_date' => '2024-07-01',
                'gym_membership_price' => 799.0,
                'gym_membership_type' => 'Gold Membership',
                'gym_membership_extension' => 0,
                'gym_access_discount' => 0,
                'gym_access_expiration_date' => '2025-01-01',
                'gym_access_start_date' => '2024-07-01',
                'gym_access_price' => 6999.0,
                'gym_access_plan' => '6 Months Access',
                'gym_access_extension' => 0,
                'pt_session_coach_name' => null,
                'pt_session_price' => 6500.0,
                'pt_session_expiration_date' => '2024-09-19',
                'pt_session_start_date' => '2024-07-01',
                'pt_session_extension' => 0,
                'pt_session_type' => 'Total Body Transformation Coaching',
                'pt_session_total' => 26,
                'pt_session_used' => 0,
                'payment_method' => 'Cash',
                'amount' => 14298.0,
                'created_at' => '2024-07-01 05:46:55.000',
                'updated_at' => '2024-07-01 05:46:55.000'
            ]
        ];
        foreach ($payments as $payment) {
            DB::table('payments')->insert($payment);
        }
    }
}
