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
                'name' => 'insert media',
                'group' => 'media',
                'guard_name' => 'web'
            ],
            [
                'name' => 'delete media',
                'group' => 'media',
                'guard_name' => 'web'
            ],
            [
                'name' => 'view media',
                'group' => 'media',
                'guard_name' => 'web'
            ],
        ];

        DB::table('permissions')->insert($permissions);
    }
}
