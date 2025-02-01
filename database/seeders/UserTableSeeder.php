<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $positionIds = DB::table('positions')->pluck('id');

        foreach (range(1, 45) as $index) {
            DB::table('users')->insert([
                'name' => $faker->name(),
                'email' => $faker->unique()->safeEmail(),
                'phone' => '+380' . $faker->numberBetween(100000000, 999999999),
                'position_id' => $positionIds->random(),
                'password' => Hash::make('password123'),
                'photo' => 'https://randomuser.me/api/portraits/women/' . $faker->numberBetween(1, 99) . '.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
