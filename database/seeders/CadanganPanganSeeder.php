<?php

namespace Database\Seeders;

use App\Models\CadanganPangan;
use App\Models\Wilayah;
use Illuminate\Database\Seeder;

class CadanganPanganSeeder extends Seeder
{
    public function run()
    {
        $regions = Wilayah::pluck('id')->toArray();
        $commodities = ['Beras', 'Jagung', 'Kedelai'];
        $years = [2020, 2021, 2022, 2023, 2024, 2025];

        foreach ($commodities as $commodity) {
            CadanganPangan::create([
                'komoditas' => $commodity,
                'jumlah' => rand(50, 500) + (rand(0, 99) / 100), 
                'periode' => $years[array_rand($years)],
                'id_lokasi' => $regions[array_rand($regions)] ?? 112, 
                'status_valid' => 'pending',
            ]);
        }
    }
}