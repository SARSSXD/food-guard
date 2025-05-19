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
                'name' => 'Admin Nasional',
                'email' => 'admin@foodguard.com',
                'password' => Hash::make('password'),
                'role' => 'nasional',
                'Id_region' => null, // National admin, no specific region
                'created_at' => now(),
            ],
            [
                'name' => 'Admin Jawa Barat',
                'email' => 'admin.jabar@region.foodguard.com',
                'password' => Hash::make('password'),
                'role' => 'daerah',
                'Id_region' => 1, // Assuming Id_lokasi 1 is Jawa Barat
                'created_at' => now(),
            ],
            [
                'name' => 'Admin Jawa Timur',
                'email' => 'admin.jatim@region.foodguard.com',
                'password' => Hash::make('password'),
                'role' => 'daerah',
                'Id_region' => 2, // Assuming Id_lokasi 2 is Jawa Timur
                'created_at' => now(),
            ],
            [
                'name' => 'Budi Santoso',
                'email' => 'budi@public.foodguard.com',
                'password' => Hash::make('password'),
                'role' => 'user',
                'Id_region' => 1, // Jawa Barat
                'created_at' => now(),
            ],
            [
                'name' => 'Siti Aminah',
                'email' => 'siti@public.foodguard.com',
                'password' => Hash::make('password'),
                'role' => 'user',
                'Id_region' => 2, // Jawa Timur
                'created_at' => now(),
            ],
            [
                'name' => 'Andi Wijaya',
                'email' => 'andi@public.foodguard.com',
                'password' => Hash::make('password'),
                'role' => 'user',
                'Id_region' => 3, // Assuming Id_lokasi 3 is DKI Jakarta
                'created_at' => now(),
            ],
        ];

        DB::table('users')->insert($users);
    }
}