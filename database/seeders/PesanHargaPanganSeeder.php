<?php

namespace Database\Seeders;

use App\Models\PesanHargaPangan;
use App\Models\User;
use App\Models\Wilayah;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class PesanHargaPanganSeeder extends Seeder
{
    public function run()
    {
        $adminNasional = User::where('role', 'nasional')->first();
        $adminDaerah = User::where('email', 'admin.jawa-timur.surabaya@region.foodguard.com')->first();
        $wilayahSurabaya = Wilayah::where('provinsi', 'Jawa Timur')->where('kota', 'Surabaya')->first();

        $pesanHarga = [
            [
                'wilayah' => 'Jawa Timur - Surabaya',
                'komoditas' => 'Beras',
                'tahun' => '2025',
                'pesan' => 'Harga beras di Surabaya diperkirakan stabil pada kisaran Rp12.000 - Rp13.000 per kg.',
                'created_by' => $adminDaerah->id,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'wilayah' => 'Jawa Timur - Surabaya',
                'komoditas' => 'Jagung',
                'tahun' => '2025',
                'pesan' => 'Harga jagung cenderung meningkat karena permintaan tinggi, sekitar Rp8.500 - Rp9.000 per kg.',
                'created_by' => $adminDaerah->id,
                'created_at' => Carbon::now()->subDays(2),
                'updated_at' => Carbon::now()->subDays(2),
            ],
            [
                'wilayah' => 'Jawa Barat - Bandung',
                'komoditas' => 'Beras',
                'tahun' => '2025',
                'pesan' => 'Harga beras di Bandung menunjukkan tren kenaikan sebesar 5% dari bulan sebelumnya.',
                'created_by' => $adminNasional->id,
                'created_at' => Carbon::now()->subDays(5),
                'updated_at' => Carbon::now()->subDays(5),
            ],
            [
                'wilayah' => 'DKI Jakarta - Jakarta Pusat',
                'komoditas' => 'Kedelai',
                'tahun' => '2025',
                'pesan' => 'Pasokan kedelai terbatas, harga diperkirakan naik hingga Rp15.000 per kg.',
                'created_by' => $adminNasional->id,
                'created_at' => Carbon::now()->subDays(7),
                'updated_at' => Carbon::now()->subDays(7),
            ],
        ];

        foreach ($pesanHarga as $pesan) {
            PesanHargaPangan::create($pesan);
        }
    }
}
