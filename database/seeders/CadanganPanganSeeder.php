<?php

namespace Database\Seeders;

use App\Models\CadanganPangan;
use App\Models\Wilayah;
use Illuminate\Database\Seeder;

class CadanganPanganSeeder extends Seeder
{
    public function run()
    {
        $commodities = ['Beras', 'Padi', 'Jagung', 'Gandum', 'Sagu'];
        $years = [2023, 2024, 2025];

        // Ambil 5 provinsi unik untuk pengujian
        $provinsis = Wilayah::select('provinsi')
            ->distinct()
            ->inRandomOrder()
            ->take(5)
            ->pluck('provinsi');

        foreach ($provinsis as $provinsi) {
            // Ambil id_lokasi agregat (MIN(id)) untuk provinsi
            $aggregateId = Wilayah::where('provinsi', $provinsi)->min('id');

            // Ambil 3 kota acak untuk provinsi ini
            $kotaIds = Wilayah::where('provinsi', $provinsi)
                ->where('id', '!=', $aggregateId)
                ->inRandomOrder()
                ->take(3)
                ->pluck('id')
                ->toArray();

            foreach ($commodities as $commodity) {
                foreach ($years as $year) {
                    $totalJumlah = 0;

                    // Buat 3 entri untuk kota
                    foreach ($kotaIds as $kotaId) {
                        $jumlah = rand(30, 300) + (rand(0, 99) / 100); // Jumlah lebih kecil untuk cadangan
                        $totalJumlah += $jumlah;

                        CadanganPangan::create([
                            'komoditas' => $commodity,
                            'jumlah' => $jumlah,
                            'periode' => $year,
                            'id_lokasi' => $kotaId,
                            'status_valid' => rand(0, 1) ? 'terverifikasi' : 'pending',
                        ]);
                    }

                    // Buat 1 entri agregat
                    CadanganPangan::create([
                        'komoditas' => $commodity,
                        'jumlah' => $totalJumlah,
                        'periode' => $year,
                        'id_lokasi' => $aggregateId,
                        'status_valid' => rand(0, 1) ? 'terverifikasi' : 'pending',
                    ]);
                }
            }
        }
    }
}
