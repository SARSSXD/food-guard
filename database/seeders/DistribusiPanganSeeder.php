<?php

namespace Database\Seeders;

use App\Models\DistribusiPangan;
use App\Models\User;
use App\Models\Wilayah;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

/**
 * Class DistribusiPanganSeeder
 *
 * Seeds the distribusi_pangan table with sample data.
 */
class DistribusiPanganSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $regions = Wilayah::pluck('id')->toArray();
        $users = User::where('role', 'daerah')->pluck('id')->toArray();
        $commodities = ['Beras', 'Jagung'];

        foreach ($commodities as $commodity) {
            DistribusiPangan::create([
                'id_wilayah_tujuan' => $regions[array_rand($regions)] ?? null,
                'komoditas' => $commodity,
                'jumlah' => rand(100, 1000),
                'tanggal_kirim' => Carbon::now()->subDays(rand(0, 30)),
                'status' => 'dikirim',
                'created_by' => $users[array_rand($users)] ?? null,
            ]);
        }
    }
}
