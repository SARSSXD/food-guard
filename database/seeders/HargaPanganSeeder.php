<?php

namespace Database\Seeders;

use App\Models\HargaPangan;
use App\Models\User;
use App\Models\Wilayah;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

/**
 * Class HargaPanganSeeder
 *
 * Seeds the harga_pangan table with sample data.
 */
class HargaPanganSeeder extends Seeder
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
            HargaPangan::create([
                'nama_pasar' => 'Pasar Tradisional',
                'komoditas' => $commodity,
                'harga_per_kg' => rand(10000, 20000),
                'id_lokasi' => $regions[array_rand($regions)] ?? null,
                'tanggal' => Carbon::now()->subDays(rand(0, 30)),
                'created_by' => $users[array_rand($users)] ?? null,
            ]);
        }
    }
}
