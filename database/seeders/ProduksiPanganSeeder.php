<?php

namespace Database\Seeders;

use App\Models\ProduksiPangan;
use App\Models\User;
use App\Models\Wilayah;
use Illuminate\Database\Seeder;

class ProduksiPanganSeeder extends Seeder
{
    public function run()
    {
        $regions = Wilayah::pluck('id')->toArray();
        $users = User::where('role', 'daerah')->pluck('id')->toArray();
        $commodities = ['Beras', 'Jagung', 'Kedelai'];
        $years = [2020, 2021, 2022, 2023, 2024, 2025];

        foreach ($commodities as $commodity) {
            ProduksiPangan::create([
                'komoditas' => $commodity,
                'jumlah' => rand(100, 1000) + (rand(0, 99) / 100), // Jumlah dengan desimal
                'periode' => $years[array_rand($years)], // Tahun acak
                'id_lokasi' => $regions[array_rand($regions)] ?? 112, // Default ke 112 jika tidak ada
                'status_valid' => 'pending',
                'created_by' => $users[array_rand($users)] ?? 22, // Default ke user ID 22
            ]);
        }
    }
}