<?php

namespace Database\Seeders;

use App\Models\HargaPangan;
use App\Models\User;
use App\Models\Wilayah;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class HargaPanganSeeder extends Seeder
{
    public function run()
    {
        $commodities = ['Beras', 'Padi', 'Jagung', 'Gandum', 'Sagu'];
        $years = [2023, 2024, 2025];
        $usersDaerah = User::where('role', 'daerah')->pluck('id')->toArray();
        $provinsis = Wilayah::select('provinsi')
            ->distinct()
            ->inRandomOrder()
            ->take(5)
            ->pluck('provinsi');

        $hargaRanges = [
            'Beras' => [
                2023 => [12000, 15000],
                2024 => [13000, 16000],
                2025 => [14000, 18000],
            ],
            'Padi' => [
                2023 => [8000, 10000],
                2024 => [8500, 11000],
                2025 => [9000, 12000],
            ],
            'Jagung' => [
                2023 => [7000, 9000],
                2024 => [7500, 10000],
                2025 => [8000, 11000],
            ],
            'Gandum' => [
                2023 => [10000, 13000],
                2024 => [11000, 14000],
                2025 => [12000, 15000],
            ],
            'Sagu' => [
                2023 => [9000, 11000],
                2024 => [9500, 12000],
                2025 => [10000, 13000],
            ],
        ];

        $pasarNames = ['Bulu', 'Johar', 'Peterongan', 'Karangayu', 'Genuk'];

        foreach ($provinsis as $provinsi) {
            $kotaIds = Wilayah::where('provinsi', $provinsi)
                ->inRandomOrder()
                ->take(3)
                ->pluck('id')
                ->toArray();

            foreach ($commodities as $commodity) {
                foreach ($years as $year) {
                    foreach ($kotaIds as $kotaId) {
                        for ($month = 1; $month <= 12; $month++) {
                            for ($i = 0; $i < 5; $i++) { // 5 entri per bulan
                                $day = rand(1, Carbon::create($year, $month)->daysInMonth);
                                $tanggal = Carbon::create($year, $month, $day);

                                HargaPangan::create([
                                    'nama_pasar' => 'Pasar ' . $pasarNames[array_rand($pasarNames)],
                                    'komoditas' => $commodity,
                                    'harga_per_kg' => rand(
                                        $hargaRanges[$commodity][$year][0],
                                        $hargaRanges[$commodity][$year][1]
                                    ),
                                    'id_lokasi' => $kotaId,
                                    'tanggal' => $tanggal,
                                    'created_by' => $usersDaerah[array_rand($usersDaerah)],
                                ]);
                            }
                        }
                    }
                }
            }
        }
    }
}
