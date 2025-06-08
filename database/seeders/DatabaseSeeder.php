<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            WilayahSeeder::class,
            UserSeeder::class,
            ProduksiPanganSeeder::class,
            CadanganPanganSeeder::class,
            HargaPanganSeeder::class,
            DistribusiPanganSeeder::class,
            ArtikelGiziSeeder::class,
            PrediksiPanganSeeder::class,
        ]);
    }
}
