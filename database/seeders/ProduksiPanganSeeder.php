<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProduksiPanganSeeder extends Seeder
{
    public function run(): void
    {
        $produksiPangan = [
            [
                'Id_produksipangan' => 1,
                'komoditas' => 'Beras',
                'volume' => 5000.5,
                'Id_lokasi' => 1,
                'waktu' => '2025-05-25',
                'status_valid' => 'pending',
                'created_by' => 2, // Admin Jawa Barat
                'created_at' => now(),
            ],
            [
                'Id_produksipangan' => 2,
                'komoditas' => 'Jagung',
                'volume' => 3000.0,
                'Id_lokasi' => 2,
                'waktu' => '2025-05-24',
                'status_valid' => 'terverifikasi',
                'created_by' => 3, // Admin Jawa Timur
                'created_at' => now(),
            ],
            [
                'Id_produksipangan' => 3,
                'komoditas' => 'Kedelai',
                'volume' => 1500.75,
                'Id_lokasi' => 1,
                'waktu' => '2025-04-23',
                'status_valid' => 'terverifikasi',
                'created_by' => 2, // Admin Jawa Barat
                'created_at' => now(),
            ],
            [
                'Id_produksipangan' => 4,
                'komoditas' => 'Beras',
                'volume' => 4500.25,
                'Id_lokasi' => 3,
                'waktu' => '2025-03-22',
                'status_valid' => 'pending',
                'created_by' => 1, // Admin Nasional
                'created_at' => now(),
            ],
            [
                'Id_produksipangan' => 5,
                'komoditas' => 'Beras',
                'volume' => 6000.0,
                'Id_lokasi' => 1,
                'waktu' => '2025-01-15',
                'status_valid' => 'terverifikasi',
                'created_by' => 2, // Admin Jawa Barat
                'created_at' => now(),
            ],
            [
                'Id_produksipangan' => 6,
                'komoditas' => 'Jagung',
                'volume' => 3200.5,
                'Id_lokasi' => 2,
                'waktu' => '2025-02-10',
                'status_valid' => 'terverifikasi',
                'created_by' => 3, // Admin Jawa Timur
                'created_at' => now(),
            ],
            [
                'Id_produksipangan' => 7,
                'komoditas' => 'Kedelai',
                'volume' => 1700.0,
                'Id_lokasi' => 3,
                'waktu' => '2025-02-15',
                'status_valid' => 'pending',
                'created_by' => 1, // Admin Nasional
                'created_at' => now(),
            ],
        ];

        DB::table('produksi_pangan')->insert($produksiPangan);
    }
}
