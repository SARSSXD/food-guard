<?php

namespace Database\Seeders;

use App\Models\ArtikelGizi;
use App\Models\User;
use Illuminate\Database\Seeder;

/**
 * Class ArtikelGiziSeeder
 *
 * Seeds the artikel_gizi table with sample data.
 */
class ArtikelGiziSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::where('role', 'nasional')->pluck('id')->toArray();

        ArtikelGizi::create([
            'judul' => 'Pola Makan Sehat untuk Anak',
            'isi' => 'Artikel tentang pentingnya gizi seimbang untuk anak-anak.',
            'kategori' => 'anak',
            'id_penulis' => $users[array_rand($users)] ?? null,
            'jumlah_akses' => 0,
        ]);
    }
}
