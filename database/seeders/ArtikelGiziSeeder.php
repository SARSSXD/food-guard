<?php

namespace Database\Seeders;

use App\Models\ArtikelGizi;
use App\Models\User;
use Illuminate\Database\Seeder;

class ArtikelGiziSeeder extends Seeder
{
    public function run()
    {
        $categories = ['anak', 'ibu_hamil', 'lansia', 'lainnya'];
        $users = User::whereIn('role', ['daerah'])->pluck('id')->toArray();

        $articles = [
            [
                'judul' => 'Manfaat Gizi Beras bagi Kesehatan',
                'isi' => 'Beras adalah sumber karbohidrat utama di Indonesia. \nMengandung energi tinggi dan mendukung pola makan sehat.',
            ],
            [
                'judul' => 'Padi: Pilar Ketahanan Pangan',
                'isi' => 'Padi merupakan tanaman pangan utama. \nProduksinya mendukung stabilitas pangan nasional.',
            ],
            [
                'judul' => 'Jagung sebagai Alternatif Karbohidrat',
                'isi' => 'Jagung kaya serat dan vitamin. \nCocok untuk diversifikasi pangan.',
            ],
            [
                'judul' => 'Gandum dan Produk Olahannya',
                'isi' => 'Gandum sering diolah menjadi tepung. \nPenting untuk industri makanan.',
            ],
            [
                'judul' => 'Sagu: Pangan Tradisional Indonesia',
                'isi' => 'Sagu adalah pangan pokok di wilayah timur Indonesia. \nKaya karbohidrat dan ramah lingkungan.',
            ],
            [
                'judul' => 'Pola Makan Seimbang untuk Keluarga',
                'isi' => 'Keseimbangan gizi penting untuk kesehatan keluarga. \nKonsumsi karbohidrat, protein, dan vitamin secara proporsional.',
            ],
            [
                'judul' => 'Mencegah Stunting dengan Gizi Adekuat',
                'isi' => 'Gizi yang cukup pada 1000 hari pertama kehidupan anak mencegah stunting. \nPerhatikan asupan ibu hamil dan balita.',
            ],
        ];

        foreach ($articles as $article) {
            ArtikelGizi::create([
                'judul' => $article['judul'],
                'isi' => $article['isi'],
                'kategori' => $categories[array_rand($categories)],
                'id_penulis' => $users[array_rand($users)],
                'jumlah_akses' => rand(50, 500),
            ]);
        }
    }
}
