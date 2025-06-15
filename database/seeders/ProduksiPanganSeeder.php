<?php

namespace Database\Seeders;

use App\Models\ProduksiPangan;
use App\Models\Wilayah;
use App\Models\User;
use Illuminate\Database\Seeder;

class ProduksiPanganSeeder extends Seeder
{
    public function run()
    {
        $commodities = ['Beras', 'Padi', 'Jagung', 'Gandum', 'Sagu'];
        $years = [2023, 2024, 2025]; // Lebih sedikit tahun untuk efisiensi
        $users = User::where('role', 'daerah')->pluck('id')->toArray();

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
                        $jumlah = rand(50, 500) + (rand(0, 99) / 100); // Jumlah acak dengan desimal
                        $totalJumlah += $jumlah;

                        ProduksiPangan::create([
                            'komoditas' => $commodity,
                            'jumlah' => $jumlah,
                            'periode' => $year,
                            'id_lokasi' => $kotaId,
                            'status_valid' => rand(0, 1) ? 'terverifikasi' : 'pending',
                            'created_by' => $users[array_rand($users)],
                        ]);
                    }

                    // Buat 1 entri agregat
                    ProduksiPangan::create([
                        'komoditas' => $commodity,
                        'jumlah' => $totalJumlah,
                        'periode' => $year,
                        'id_lokasi' => $aggregateId,
                        'status_valid' => rand(0, 1) ? 'terverifikasi' : 'pending',
                        'created_by' => $users[array_rand($users)],
                    ]);
                }
            }
        }
    }
}
