<?php

namespace App\Services;

use App\Models\CadanganPangan;
use App\Models\Wilayah;
use Illuminate\Support\Facades\Auth;

class CadanganPanganService
{
    public function aggregateData($periode, $komoditas, $id_lokasi)
    {
        // Ambil provinsi dari id_lokasi
        $wilayah = Wilayah::findOrFail($id_lokasi);
        $provinsi = $wilayah->provinsi;

        // Ambil semua id_lokasi untuk provinsi yang sama
        $lokasiProvinsi = Wilayah::where('provinsi', $provinsi)->pluck('id');

        // Ambil id_lokasi representatif untuk provinsi (id pertama)
        $id_lokasi_provinsi = $lokasiProvinsi->first();

        // Hitung total jumlah untuk komoditas dan periode di provinsi
        // Hanya record per kota (bukan agregat, dicek dengan id_lokasi != id_lokasi_provinsi)
        $totalJumlah = CadanganPangan::whereIn('id_lokasi', $lokasiProvinsi)
            ->where('komoditas', $komoditas)
            ->where('periode', $periode)
            ->where('status_valid', 'pending')
            ->where('id_lokasi', '!=', $id_lokasi_provinsi) // Hindari record agregat
            ->sum('jumlah');

        // Jika total jumlah > 0, buat atau perbarui record agregat
        if ($totalJumlah > 0) {
            CadanganPangan::updateOrCreate(
                [
                    'periode' => $periode,
                    'komoditas' => $komoditas,
                    'id_lokasi' => $id_lokasi_provinsi,
                    'status_valid' => 'pending',
                ],
                [
                    'jumlah' => $totalJumlah,
                ]
            );
        } else {
            // Jika tidak ada data, hapus record agregat jika ada
            CadanganPangan::where('periode', $periode)
                ->where('komoditas', $komoditas)
                ->where('id_lokasi', $id_lokasi_provinsi)
                ->where('status_valid', 'pending')
                ->delete();
        }
    }
}
