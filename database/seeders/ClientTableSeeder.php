<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class ClientTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        $clients = [
            [
                'name' => 'Google',
                'acronym' => 'GOO',
                'address' => '1600 Amphitheatre Parkway',
                'tin' => '123456789',
                'vendor_code' => 'GOO123',
            ],
            [
                'name' => 'Apple',
                'acronym' => 'APL',
                'address' => '1 Apple Park Way',
                'tin' => '987654321',
                'vendor_code' => 'APL456',
            ],
            [
                'name' => 'Microsoft',
                'acronym' => 'MSFT',
                'address' => 'One Microsoft Way',
                'tin' => '246810121',
                'vendor_code' => 'MSFT789',
            ],
            [
                'name' => 'Amazon',
                'acronym' => 'AMZN',
                'address' => '410 Terry Ave N',
                'tin' => '314159265',
                'vendor_code' => 'AMZN654',
            ],
            [
                'name' => 'Facebook',
                'acronym' => 'FB',
                'address' => '1 Hacker Way',
                'tin' => '271828182',
                'vendor_code' => 'FB987',
            ],
            [
                'name' => 'Tesla',
                'acronym' => 'TSLA',
                'address' => '3500 Deer Creek Road',
                'tin' => '161803398',
                'vendor_code' => 'TSLA246',
            ],
            [
                'name' => 'Netflix',
                'acronym' => 'NFLX',
                'address' => '100 Winchester Circle',
                'tin' => '1123581321',
                'vendor_code' => 'NFLX135',
            ],
            [
                'name' => 'Twitter',
                'acronym' => 'TWTR',
                'address' => '1355 Market St',
                'tin' => '9876543210',
                'vendor_code' => 'TWTR246',
            ],
            [
                'name' => 'Uber',
                'acronym' => 'UBER',
                'address' => '1455 Market St',
                'tin' => '3141592653',
                'vendor_code' => 'UBER789',
            ],
            [
                'name' => 'Airbnb',
                'acronym' => 'ABNB',
                'address' => '888 Brannan St',
                'tin' => '2718281828',
                'vendor_code' => 'ABNB123',
            ],
            // Add more client data as needed
        ];

        foreach ($clients as $client) {
            DB::table('clients')->insert([
                'name' => $client['name'],
                'acronym' => $client['acronym'],
                'address' => $client['address'],
                'tin' => $client['tin'],
                'vendor_code' => $client['vendor_code'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
