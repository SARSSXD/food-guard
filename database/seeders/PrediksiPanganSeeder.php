<?php

namespace Database\Seeders;

use App\Models\PrediksiPangan;
use App\Models\User;
use App\Models\Wilayah;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

/**
 * Class PrediksiPanganSeeder
 *
 * Seeds the prediksi_pangan table with sample data.
 */
class PrediksiPanganSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $regions = Wilayah::pluck('id')->toArray();
        $users = User::where('role', 'nasional')->pluck('id')->toArray();

        PrediksiPangan::create([
            'jenis' => 'produksi',
            'komoditas' => 'Beras',
            'id_lokasi' => $regions[array_rand($regions)] ?? null,
            'bulan_tahun' => Carbon::now()->addMonth(),
            'jumlah' => rand(100, 1000),
            'metode' => 'AI/ML',
            'status' => 'draft',
            'created_by' => $users[array_rand($users)] ?? null,
        ]);
    }
}