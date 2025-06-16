<?php

namespace Database\Seeders;

use App\Models\DistribusiPangan;
use App\Models\User;
use App\Models\Wilayah;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class DistribusiPanganSeeder extends Seeder
{
    public function run()
    {
        $commodities = ['Beras', 'Padi', 'Jagung', 'Gandum', 'Sagu'];
        $statuses = ['dikirim', 'ditunda', 'terlambat', 'selesai'];
        $usersDaerah = User::where('role', 'daerah')->pluck('id')->toArray();
        $provinsis = Wilayah::select('provinsi')
            ->distinct()
            ->inRandomOrder()
            ->take(5)
            ->pluck('provinsi');

        foreach ($provinsis as $provinsi) {
            $kotaIds = Wilayah::where('provinsi', $provinsi)
                ->inRandomOrder()
                ->take(3)
                ->pluck('id')
                ->toArray();

            foreach ($commodities as $commodity) {
                for ($i = 0; $i < 3; $i++) { // 3 entri per komoditas per kota
                    foreach ($kotaIds as $kotaId) {
                        DistribusiPangan::create([
                            'id_wilayah_tujuan' => $kotaId,
                            'komoditas' => $commodity,
                            'jumlah' => rand(100, 1000),
                            'tanggal_kirim' => Carbon::now()->subDays(rand(0, 90)),
                            'status' => $statuses[array_rand($statuses)],
                            'created_by' => $usersDaerah[array_rand($usersDaerah)],
                        ]);
                    }
                }
            }
        }
    }
}
