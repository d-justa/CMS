<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            [
                'name' => 'impersonate user',
                'group' => 'user',
                'guard_name' => 'web'
            ],
            [
                'name' => 'manage general site settings',
                'group' => 'site settings',
                'guard_name' => 'web'
            ],
            [
                'name' => 'manage contact site settings',
                'group' => 'site settings',
                'guard_name' => 'web'
            ],
            [
                'name' => 'manage advanced site settings',
                'group' => 'site settings',
                'guard_name' => 'web'
            ],
        ];

        DB::table('permissions')->insert($permissions);
    }
}
