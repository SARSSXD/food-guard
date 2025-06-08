<?php

namespace Database\Seeders;

use App\Models\CadanganPangan;
use App\Models\Wilayah;
use Illuminate\Database\Seeder;

/**
 * Class CadanganPanganSeeder
 *
 * Seeds the cadangan_pangan table with sample data.
 */
class CadanganPanganSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $regions = Wilayah::pluck('id')->toArray();
        $commodities = ['Beras', 'Jagung', 'Kedelai'];

        foreach ($commodities as $commodity) {
            CadanganPangan::create([
                'komoditas' => $commodity,
                'jumlah' => rand(50, 500),
                'id_lokasi' => $regions[array_rand($regions)] ?? null,
                'status_valid' => 'pending',
            ]);
        }
    }
}
