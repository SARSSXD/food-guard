<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'Id_users' => 1,
                'name' => 'Admin Nasional',
                'email' => 'admin@foodguard.com',
                'password' => Hash::make('password'),
                'role' => 'nasional',
                'Id_region' => null,
                'created_at' => now(),
            ],
            [
                'Id_users' => 2,
                'name' => 'Admin Jawa Barat',
                'email' => 'admin.jabar@region.foodguard.com',
                'password' => Hash::make('password'),
                'role' => 'daerah',
                'Id_region' => 1,
                'created_at' => now(),
            ],
            [
                'Id_users' => 3,
                'name' => 'Admin Jawa Timur',
                'email' => 'admin.jatim@region.foodguard.com',
                'password' => Hash::make('password'),
                'role' => 'daerah',
                'Id_region' => 2,
                'created_at' => now(),
            ],
            [
                'Id_users' => 4,
                'name' => 'Budi Santoso',
                'email' => 'budi@public.foodguard.com',
                'password' => Hash::make('password'),
                'role' => 'user',
                'Id_region' => 1,
                'created_at' => now(),
            ],
            [
                'Id_users' => 5,
                'name' => 'Siti Aminah',
                'email' => 'siti@public.foodguard.com',
                'password' => Hash::make('password'),
                'role' => 'user',
                'Id_region' => 2,
                'created_at' => now(),
            ],
            [
                'Id_users' => 6,
                'name' => 'Andi Wijaya',
                'email' => 'andi@public.foodguard.com',
                'password' => Hash::make('password'),
                'role' => 'user',
                'Id_region' => 2,
                'created_at' => now(),
            ],
        ];

        DB::table('users')->insert($users);
    }
}
