<?php

namespace Database\Seeders;

use App\Models\ProduksiPangan;
use App\Models\User;
use App\Models\Wilayah;
use Illuminate\Database\Seeder;

/**
 * Class ProduksiPanganSeeder
 *
 * Seeds the produksi_pangan table with sample data.
 */
class ProduksiPanganSeeder extends Seeder
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

        $commodities = ['Beras', 'Jagung', 'Kedelai'];

        foreach ($commodities as $commodity) {
            ProduksiPangan::create([
                'komoditas' => $commodity,
                'jumlah' => rand(100, 1000),
                'id_lokasi' => $regions[array_rand($regions)] ?? null,
                'status_valid' => 'pending',
                'created_by' => $users[array_rand($users)] ?? null,
            ]);
        }
    }
}