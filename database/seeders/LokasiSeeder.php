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
                'Id_parent' => null,
            ],
            [
                'Id_lokasi' => 2,
                'name' => 'Jawa Timur',
                'Id_parent' => null,
            ],
            [
                'Id_lokasi' => 3,
                'name' => 'DKI Jakarta',
                'Id_parent' => null,
            ],
        ];

        DB::table('lokasi')->insert($lokasi);
    }
}