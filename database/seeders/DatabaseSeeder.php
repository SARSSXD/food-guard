<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(LokasiSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(ProduksiPanganSeeder::class);
    }
}
