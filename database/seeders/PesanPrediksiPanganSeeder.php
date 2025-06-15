<?php

namespace Database\Seeders;

use App\Models\PesanPrediksiPangan;
use App\Models\User;
use App\Models\Wilayah;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class PesanPrediksiPanganSeeder extends Seeder
{
    public function run()
    {
        $adminNasional = User::where('role', 'nasional')->first();
        $adminDaerah = User::where('email', 'admin.jawa-timur.surabaya@region.foodguard.com')->first();
        $wilayahSurabaya = Wilayah::where('provinsi', 'Jawa Timur')->where('kota', 'Surabaya')->first();

        $pesanPrediksi = [
            [
                'provinsi' => 'Jawa Timur',
                'komoditas' => 'Beras',
                'bulan_tahun' => '2025-07',
                'pesan' => 'Prediksi produksi beras di Surabaya meningkat 10% dibandingkan bulan sebelumnya.',
                'created_by' => $adminDaerah->id,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'provinsi' => 'Jawa Timur',
                'komoditas' => 'Jagung',
                'bulan_tahun' => '2025-07',
                'pesan' => 'Prediksi cadangan jagung menurun karena distribusi ke wilayah lain meningkat.',
                'created_by' => $adminDaerah->id,
                'created_at' => Carbon::now()->subDays(3),
                'updated_at' => Carbon::now()->subDays(3),
            ],
            [
                'provinsi' => 'Jawa Barat',
                'komoditas' => 'Beras',
                'bulan_tahun' => '2025-08',
                'pesan' => 'Prediksi produksi beras stabil dengan jumlah sekitar 120 ton.',
                'created_by' => $adminNasional->id,
                'created_at' => Carbon::now()->subDays(4),
                'updated_at' => Carbon::now()->subDays(4),
            ],
            [
                'provinsi' => 'DKI Jakarta',
                'komoditas' => 'Kedelai',
                'bulan_tahun' => '2025-08',
                'pesan' => 'Prediksi cadangan kedelai menurun karena tingginya permintaan industri tempe.',
                'created_by' => $adminNasional->id,
                'created_at' => Carbon::now()->subDays(6),
                'updated_at' => Carbon::now()->subDays(6),
            ],
        ];

        foreach ($pesanPrediksi as $pesan) {
            PesanPrediksiPangan::create($pesan);
        }
    }
}