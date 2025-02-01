<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $positionIds = DB::table('positions')->pluck('id');

        foreach (range(1, 44) as $index) {
            $randomPhotoUrl = 'https://randomuser.me/api/portraits/women/' . $faker->numberBetween(1, 99) . '.jpg';

            $photoContent = file_get_contents($randomPhotoUrl);
            $photoName = 'optimized/users/' . Str::random(10) . '.jpg';
            Storage::disk('public')->put($photoName, $photoContent);

            DB::table('users')->insert([
                'name' => $faker->name(),
                'email' => $faker->unique()->safeEmail(),
                'phone' => '+380' . $faker->numberBetween(100000000, 999999999),
                'position_id' => $positionIds->random(),
                'password' => Hash::make('password123'),
                'photo' => $photoName,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        
        //TEST USER
        $testUserrandomPhotoUrl = 'https://randomuser.me/api/portraits/women/' . $faker->numberBetween(1, 99) . '.jpg';
        $testUserphotoContent = file_get_contents($testUserrandomPhotoUrl);
        $testUserphotoName = 'optimized/users/' . Str::random(10) . '.jpg';
        Storage::disk('public')->put($testUserphotoName, $testUserphotoContent);
        DB::table('users')->insert([
            [
                'name' => 'John Smith',
                'email' => "user@example.com",
                'phone' => '+380562158442',
                'position_id' => "1",
                'password' => Hash::make('user123'),
                'photo' => $testUserphotoName,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
