<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categories')->insert([
            ['category' => 'Full-time'],
            ['category' => 'Part-time'],
            ['category' => 'Contract'],
            ['category' => 'Independent contractor'],
            ['category' => 'Temporary'],
            ['category' => 'On-call'],
            ['category' => 'Volunteer'],
        ]);
    }
}
