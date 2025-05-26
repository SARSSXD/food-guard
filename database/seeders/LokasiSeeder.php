<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LokasiSeeder extends Seeder
{
    public function run(): void
    {
        $lokasi = [
            [
                'Id_lokasi' => 1,
                'name' => 'Jawa Barat',
                'created_at' => now(),
            ],
            [
                'Id_lokasi' => 2,
                'name' => 'Jawa Timur',
                'created_at' => now(),
            ],
            [
                'Id_lokasi' => 3,
                'name' => 'Jawa Tengah',
                'created_at' => now(),
            ],
        ];

        DB::table('lokasi')->insert($lokasi);
    }
}
