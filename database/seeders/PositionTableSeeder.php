<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class PositionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('positions')->insert([
            ['name' => 'Lawyer'],
            ['name' => 'Content manager'],
            ['name' => 'Security'],
            ['name' => 'Designer'],
        ]);
    }
}
