<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('roles')->insert([
            [
                'role' => 'manager',
                'access' => json_encode([
                    'create_employees',
                    'list_records',
                    'delete_records',
                ])
            ],
            [
                'role' => 'employee',
                'access' => json_encode([
                    'create_records',
                    'edit_records',
                    'delete_records',
                ])
            ],
        ]);
    }
}
