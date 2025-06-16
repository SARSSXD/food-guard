<?php

namespace Database\Seeders;

use App\Models\PesanPrediksiPangan;
use App\Models\Wilayah;
use App\Models\User;
use Illuminate\Database\Seeder;

class PesanPrediksiPanganSeeder extends Seeder
{
    public function run()
    {
        $commodities = ['Beras', 'Padi', 'Jagung', 'Gandum', 'Sagu'];
        $users = User::where('role', 'nasional')->pluck('id')->toArray();
        $months = ['Januari 2024', 'Juni 2024', 'Desember 2024', 'Januari 2025', 'Juni 2025', 'Desember 2025'];
        $messages = [
            'Harap perhatikan prediksi ini untuk perencanaan stok.',
            'Revisi data diperlukan berdasarkan hasil prediksi terbaru.',
            'Prediksi menunjukkan potensi kekurangan, mohon tindak lanjuti.',
            'Data prediksi ini telah disetujui, silakan implementasikan.',
        ];

        // Ambil 5 provinsi unik untuk pengujian
        $provinsis = Wilayah::select('provinsi')
            ->distinct()
            ->inRandomOrder()
            ->take(5)
            ->pluck('provinsi');

        foreach ($provinsis as $provinsi) {
            foreach ($commodities as $commodity) {
                foreach ($months as $month) {
                    // Buat 1-2 pesan acak per kombinasi
                    if (rand(0, 1)) {
                        PesanPrediksiPangan::create([
                            'provinsi' => $provinsi,
                            'komoditas' => $commodity,
                            'bulan_tahun' => $month,
                            'pesan' => $messages[array_rand($messages)],
                            'created_by' => $users[array_rand($users)],
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    }
                }
            }
        }
    }
}
