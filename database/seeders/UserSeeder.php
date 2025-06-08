<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Wilayah;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * Class UserSeeder
 *
 * Seeds the users table with one national admin, 10 regional admins, and 10 public users.
 */
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Get random regions for Admin Daerah
        $regions = Wilayah::inRandomOrder()->take(10)->get();

        // Create Admin Nasional
        User::create([
            'name' => 'Admin Nasional',
            'email' => 'admin@foodguard.com',
            'password' => Hash::make('password123'),
            'role' => 'nasional',
            'id_region' => null,
        ]);

        // Create 10 Admin Daerah
        foreach ($regions as $index => $region) {
            // Format email: admin.<provinsi>.<kota>@region.foodguard.com
            $provinceSlug = Str::slug($region->provinsi, '-');
            $citySlug = Str::slug($region->kota, '-');
            $email = "admin.{$provinceSlug}.{$citySlug}@region.foodguard.com";

            User::create([
                'name' => "Admin {$region->provinsi} {$region->kota}",
                'email' => $email,
                'password' => Hash::make('password123'),
                'role' => 'daerah',
                'id_region' => $region->id,
            ]);
        }

        // Create 10 User Umum
        $publicUsers = [
            'Budi Santoso',
            'Ani Rahayu',
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
            // Format email: <nama-user>@public.foodguard.com
            $email = Str::slug($userName, '.') . '@public.foodguard.com';

            User::create([
                'name' => $userName,
                'email' => $email,
                'password' => Hash::make('password123'),
                'role' => 'user',
                'id_region' => $regions->random()->id ?? null,
            ]);
        }
    }
}
