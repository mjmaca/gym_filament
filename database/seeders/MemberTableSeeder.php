<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class MemberTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        $roles = DB::table('roles')->whereNot('name', 'super_admin')->get();
        foreach ($roles as $role) {
            for ($i = 0; $i < 20; $i++) {
                $userId = Str::random(8);
                $isGuest = $faker->boolean;
                DB::table('members')->insert([
                    'is_guest' => $isGuest,
                    'membership_id' => $isGuest ? null : $userId,
                    'full_name' => $faker->firstName . ' ' . $faker->lastName,
                    'gender' => $faker->randomElement(['male', 'female']),
                    'province' => $faker->state,
                    'city' => $faker->city,
                    'barangay' => $faker->streetName,
                    'street' => $faker->streetAddress,
                    'occupation' => $faker->jobTitle,
                    'mobile_number' => $faker->e164PhoneNumber,
                    'email' => $faker->unique()->safeEmail,
                    'emergency_name' => $faker->name,
                    'emergency_contact' => $faker->e164PhoneNumber,
                    'branch_location' => $faker->randomElement(['Branch A', 'Branch B', 'Branch C']),
                    'birth_date' => $faker->date(),
                    // 'gym_access_discount' => $faker->numberBetween(0, 50),
                    // 'gym_access_expiration_date' => $faker->dateTimeBetween('+1 month', '+1 year')->format('Y-m-d'),
                    // 'gym_access_start_date' => now(),
                    // 'gym_access_price' => $faker->numberBetween(50, 200),
                    // 'gym_access_plan' => $faker->randomElement(['Monthly', 'Yearly']),
                    // 'gym_access_extension' => $faker->numberBetween(0, 3),
                    // 'gym_membership_discount' => $faker->numberBetween(0, 50),
                    // 'gym_membership_expiration_date' => $faker->dateTimeBetween('+1 month', '+1 year')->format('Y-m-d'),
                    // 'gym_membership_start_date' => now(),
                    // 'gym_membership_price' => $faker->numberBetween(200, 500),
                    // 'gym_membership_type' => $faker->randomElement(['Gold', 'Silver']),
                    // 'gym_membership_extension' => $faker->numberBetween(0, 3),
                    // 'pt_session_coach_name' => $faker->name,
                    // 'pt_session_price' => $faker->numberBetween(30, 100),
                    // 'pt_session_expiration_date' => $faker->dateTimeBetween('+1 month', '+6 months')->format('Y-m-d'),
                    // 'pt_session_start_date' => now(),
                    // 'pt_session_extension' => $faker->numberBetween(0, 3),
                    // 'pt_session_type' => $faker->randomElement(['Muay Thai', 'Boxing']),
                    // 'pt_session_total' => $faker->numberBetween(1, 20),
                    // 'pt_session_used' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
