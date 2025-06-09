<?php

namespace App\Http\Controllers;

use App\Models\ProduksiPangan;
use App\Models\CadanganPangan;
use App\Models\DistribusiPangan;
use App\Models\HargaPangan;
use App\Models\ArtikelGizi;
use App\Models\PrediksiPangan;
use Illuminate\Support\Facades\DB;
use App\Models\Wilayah;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    public function nasional()
    {
        // Data Produksi Pangan
        $produksiPangan = ProduksiPangan::with(['region', 'creator'])
            ->where('status_valid', 'terverifikasi')
            ->orderBy('created_at', 'desc')
            ->get();

        // Data Cadangan Pangan
        $cadanganPangan = CadanganPangan::with('region')
            ->where('status_valid', 'terverifikasi')
            ->orderBy('created_at', 'desc')
            ->get();

        // Data Harga Pangan
        $hargaPangan = HargaPangan::with(['region', 'creator'])
            ->orderBy('tanggal', 'desc')
            ->get();

        // Data Distribusi Pangan
        $distribusiPangan = DistribusiPangan::with(['region', 'creator'])
            ->orderBy('tanggal_kirim', 'desc')
            ->get();

        // Data Prediksi Pangan
        $prediksiPangan = PrediksiPangan::with(['region', 'creator'])
            ->where('status', 'disetujui')
            ->orderBy('bulan_tahun', 'desc')
            ->get();

        // Data Artikel Gizi
        $artikelGizi = ArtikelGizi::with('author')
            ->orderBy('created_at', 'desc')
            ->get();

        // Grafik Produksi Pangan (Total Jumlah per Komoditas per Bulan)
        $grafikProduksi = ProduksiPangan::selectRaw('komoditas, DATE_FORMAT(created_at, "%Y-%m") as bulan, SUM(jumlah) as total_jumlah')
            ->whereYear('created_at', '<=', 2025)
            ->where('status_valid', 'terverifikasi')
            ->groupBy('komoditas', 'bulan')
            ->orderBy('bulan')
            ->get();

        // Grafik Cadangan Pangan (Total Jumlah per Komoditas)
        $grafikCadangan = CadanganPangan::selectRaw('komoditas, SUM(jumlah) as total_jumlah')
            ->where('status_valid', 'terverifikasi')
            ->groupBy('komoditas')
            ->get();

        // Grafik Harga Pangan (Rata-rata Harga per Komoditas per Bulan)
        $grafikHarga = HargaPangan::selectRaw('komoditas, DATE_FORMAT(tanggal, "%Y-%m") as bulan, AVG(harga_per_kg) as avg_harga')
            ->groupBy('komoditas', 'bulan')
            ->orderBy('bulan')
            ->get();

        // Persiapan data untuk grafik
        $labels = $grafikProduksi->pluck('bulan')->unique()->sort()->values()->toArray();
        $komoditasList = $grafikProduksi->pluck('komoditas')->unique();
        $produksiDatasets = [];

        if ($komoditasList->isEmpty()) {
            Log::warning('No komoditas found for produksi chart.');
            $produksiDatasets[] = [
                'label' => 'Tidak ada data',
                'data' => array_fill(0, count($labels), 0),
                'borderColor' => '#999999',
                'fill' => false
            ];
        } else {
            foreach ($komoditasList as $komoditas) {
                $data = array_fill(0, count($labels), 0);
                foreach ($grafikProduksi->where('komoditas', $komoditas) as $item) {
                    $index = array_search($item->bulan, $labels);
                    if ($index !== false) {
                        $data[$index] = floatval($item->total_jumlah);
                    }
                }
                $produksiDatasets[] = [
                    'label' => $komoditas,
                    'data' => $data,
                    'borderColor' => $this->getColor($komoditas),
                    'fill' => false
                ];
            }
        }

        // Grafik Cadangan
        $cadanganLabels = $grafikCadangan->pluck('komoditas')->toArray();
        $cadanganValues = $grafikCadangan->pluck('total_jumlah')->map(fn($value) => floatval($value))->toArray();

        // Grafik Harga
        $hargaLabels = $grafikHarga->pluck('bulan')->unique()->sort()->values()->toArray();
        $komoditasHarga = $grafikHarga->pluck('komoditas')->unique()->toArray();
        $hargaDatasets = [];
        $colors = ['rgba(255, 99, 132, 0.5)', 'rgba(54, 162, 235, 0.5)', 'rgba(255, 206, 86, 0.5)', 'rgba(75, 192, 192, 0.5)'];
        foreach ($komoditasHarga as $index => $komoditas) {
            $data = array_fill(0, count($hargaLabels), 0);
            foreach ($grafikHarga->where('komoditas', $komoditas) as $item) {
                $index = array_search($item->bulan, $hargaLabels);
                if ($index !== false) {
                    $data[$index] = floatval($item->avg_harga);
                }
            }
            $hargaDatasets[] = [
                'label' => $komoditas,
                'data' => $data,
                'backgroundColor' => $colors[$index % count($colors)],
                'borderColor' => str_replace('0.5', '1', $colors[$index % count($colors)]),
                'borderWidth' => 1,
            ];
        }

        // Notifikasi data pending lebih dari 3 hari
        $pendingCount = ProduksiPangan::where('status_valid', 'pending')
            ->where('created_at', '<', Carbon::now()->subDays(3))
            ->count();

        Log::info('Pending Count:', ['count' => $pendingCount]);
        Log::info('Produksi Datasets:', $produksiDatasets);
        Log::info('Cadangan Labels:', $cadanganLabels);
        Log::info('Harga Datasets:', $hargaDatasets);

        return view('nasional.dashboard', compact(
            'produksiPangan',
            'cadanganPangan',
            'hargaPangan',
            'distribusiPangan',
            'prediksiPangan',
            'artikelGizi',
            'labels',
            'produksiDatasets',
            'cadanganLabels',
            'cadanganValues',
            'hargaLabels',
            'hargaDatasets',
            'pendingCount'
        ));
    }

    public function daerah()
    {
        $user = Auth::user();
        $wilayah = Wilayah::findOrFail($user->id_region);
        $currentYear = date('Y');

        // Statistik
        $totalProduksi = ProduksiPangan::where('id_lokasi', $user->id_region)
            ->where('status_valid', 'terverifikasi')
            ->where('periode', $currentYear)
            ->sum('jumlah');
        $totalCadangan = CadanganPangan::where('id_lokasi', $user->id_region)
            ->where('periode', $currentYear)
            ->sum('jumlah');
        $totalDistribusi = DistribusiPangan::where('created_by', $user->id)
            ->where('status', 'selesai')
            ->count();
        $totalArtikel = ArtikelGizi::where('id_penulis', $user->id)
            ->count();

        // Data untuk Grafik Produksi vs Cadangan
        $produksiData = ProduksiPangan::select('komoditas', DB::raw('SUM(jumlah) as total'))
            ->where('id_lokasi', $user->id_region)
            ->where('periode', $currentYear)
            ->groupBy('komoditas')
            ->get();
        $cadanganData = CadanganPangan::select('komoditas', DB::raw('SUM(jumlah) as total'))
            ->where('id_lokasi', $user->id_region)
            ->where('periode', $currentYear)
            ->groupBy('komoditas')
            ->get();

        $komoditasLabels = array_unique(array_merge(
            $produksiData->pluck('komoditas')->toArray(),
            $cadanganData->pluck('komoditas')->toArray()
        ));
        $produksiValues = [];
        $cadanganValues = [];
        foreach ($komoditasLabels as $komoditas) {
            $produksiValues[] = $produksiData->where('komoditas', $komoditas)->first()->total ?? 0;
            $cadanganValues[] = $cadanganData->where('komoditas', $komoditas)->first()->total ?? 0;
        }

        // Data untuk Grafik Harga Pangan
        $hargaData = HargaPangan::select('komoditas', DB::raw('DATE_FORMAT(tanggal, "%Y-%m") as bulan_tahun'), DB::raw('AVG(harga_per_kg) as avg_harga'))
            ->where('id_lokasi', $user->id_region)
            ->groupBy('komoditas', 'bulan_tahun')
            ->orderBy('bulan_tahun')
            ->get();

        $hargaLabels = $hargaData->pluck('bulan_tahun')->unique()->values()->toArray();
        $komoditasHarga = $hargaData->pluck('komoditas')->unique()->toArray();
        $hargaDatasets = [];
        $colors = ['rgba(255, 99, 132, 0.5)', 'rgba(54, 162, 235, 0.5)', 'rgba(255, 206, 86, 0.5)', 'rgba(75, 192, 192, 0.5)'];
        foreach ($komoditasHarga as $index => $komoditas) {
            $data = [];
            foreach ($hargaLabels as $bulan) {
                $data[] = $hargaData->where('komoditas', $komoditas)->where('bulan_tahun', $bulan)->first()->avg_harga ?? 0;
            }
            $hargaDatasets[] = [
                'label' => $komoditas,
                'data' => $data,
                'backgroundColor' => $colors[$index % count($colors)],
                'borderColor' => str_replace('0.5', '1', $colors[$index % count($colors)]),
                'borderWidth' => 1,
            ];
        }

        return view('daerah.dashboard', [
            'wilayah' => $wilayah,
            'totalProduksi' => $totalProduksi,
            'totalCadangan' => $totalCadangan,
            'totalDistribusi' => $totalDistribusi,
            'totalArtikel' => $totalArtikel,
            'komoditasLabels' => $komoditasLabels,
            'produksiData' => $produksiValues,
            'cadanganData' => $cadanganValues,
            'hargaLabels' => $hargaLabels,
            'hargaDatasets' => $hargaDatasets,
        ]);
    }

    private function getColor($komoditas)
    {
        $colors = [
            'Beras' => '#4CAF50',
            'Jagung' => '#FFC107',
            'Kedelai' => '#2196F3',
        ];
        return $colors[$komoditas] ?? '#000000';
    }
}
