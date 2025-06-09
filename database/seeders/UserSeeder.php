<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Wilayah;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    public function run()
    {
        $regions = Wilayah::inRandomOrder()->take(10)->get();

        User::create([
            'name' => 'Admin Nasional',
            'email' => 'admin@foodguard.com',
            'password' => Hash::make('password'),
            'role' => 'nasional',
            'id_region' => null,
        ]);

        foreach ($regions as $index => $region) {
            $provinceSlug = Str::slug($region->provinsi, '-');
            $citySlug = Str::slug($region->kota, '-');
            $email = "admin.{$provinceSlug}.{$citySlug}@region.foodguard.com";

            User::create([
                'name' => "Admin {$region->provinsi} {$region->kota}",
                'email' => $email,
                'password' => Hash::make('password'),
                'role' => 'daerah',
                'id_region' => $region->id,
            ]);
        }

        $publicUsers = [
            'Kautsar Quraisy',
            'Akhmad Faizal',
            'Cahyo Pratama',
            'Dewi Lestari',
            'Eko Susilo',
            'Fitri Amalia',
            'Gita Pratiwi',
            'Hadi Nugroho',
            'Indah Sari',
            'Joko Widodo',
        ];

        foreach ($publicUsers as $userName) {
            $email = Str::slug($userName, '.') . '@public.foodguard.com';

            User::create([
                'name' => $userName,
                'email' => $email,
                'password' => Hash::make('password'),
                'role' => 'user',
                'id_region' => $regions->random()->id ?? null,
            ]);
        }
    }
}
