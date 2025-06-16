<?php

namespace Database\Seeders;

use App\Models\PrediksiPangan;
use App\Models\Wilayah;
use App\Models\User;
use Illuminate\Database\Seeder;

class PrediksiPanganSeeder extends Seeder
{
    public function run()
    {
        $commodities = ['Beras', 'Padi', 'Jagung', 'Gandum', 'Sagu'];
        $jenisList = ['produksi', 'cadangan'];
        $metodes = ['ARIMA', 'Regresi Linear', 'Exponential Smoothing'];
        $statuses = ['draft', 'disetujui', 'revisi'];
        $users = User::where('role', 'nasional')->pluck('id')->toArray();
        $months = ['2024-01-01', '2024-06-01', '2024-12-01', '2025-01-01', '2025-06-01', '2025-12-01'];

        // Ambil 5 provinsi unik untuk pengujian
        $provinsis = Wilayah::select('provinsi')
            ->distinct()
            ->inRandomOrder()
            ->take(5)
            ->pluck('provinsi');

        foreach ($provinsis as $provinsi) {
            // Ambil id_lokasi agregat (MIN(id)) untuk provinsi
            $aggregateId = Wilayah::where('provinsi', $provinsi)->min('id');

            foreach ($commodities as $commodity) {
                foreach ($months as $month) {
                    foreach ($jenisList as $jenis) {
                        PrediksiPangan::create([
                            'jenis' => $jenis,
                            'komoditas' => $commodity,
                            'id_lokasi' => $aggregateId,
                            'bulan_tahun' => $month,
                            'jumlah' => rand(100, 1000) + (rand(0, 99) / 100),
                            'metode' => $metodes[array_rand($metodes)],
                            'status' => $statuses[array_rand($statuses)],
                            'created_by' => $users[array_rand($users)],
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    }
                }
            }
        }
    }
}
