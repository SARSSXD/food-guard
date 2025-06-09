<?php

namespace App\Http\Controllers;

use App\Models\ProduksiPangan;
use App\Models\CadanganPangan;
use App\Models\DistribusiPangan;
use App\Models\HargaPangan;
use App\Models\ArtikelGizi;
use Illuminate\Support\Facades\DB;
use App\Models\Wilayah;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    public function nasional()
    {
        $produksiPangan = ProduksiPangan::with('region', 'creator')->orderBy('waktu', 'desc')->get();

        // Data untuk grafik
        $grafikData = ProduksiPangan::selectRaw('komoditas, MONTH(waktu) as bulan, SUM(volume) as total_volume')
            ->whereYear('waktu', '<=', 2025) // Batasi hingga tahun 2025
            ->groupBy('komoditas', 'bulan')
            ->orderBy('bulan')
            ->get();

        Log::info('Grafik Data:', $grafikData->toArray());
        Log::info('Produksi Pangan Count:', ['count' => $produksiPangan->count()]);

        $labels = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
        $datasets = [];
        $komoditasList = $grafikData->pluck('komoditas')->unique();

        if ($komoditasList->isEmpty()) {
            Log::warning('No komoditas found for chart.');
            $datasets[] = [
                'label' => 'Tidak ada data',
                'data' => array_fill(0, 12, 0),
                'borderColor' => '#999999',
                'fill' => false
            ];
        } else {
            foreach ($komoditasList as $komoditas) {
                $data = array_fill(0, 12, 0);
                foreach ($grafikData->where('komoditas', $komoditas) as $item) {
                    $data[$item->bulan - 1] = floatval($item->total_volume); // Pastikan float
                }
                $datasets[] = [
                    'label' => $komoditas,
                    'data' => $data,
                    'borderColor' => $this->getColor($komoditas),
                    'fill' => false
                ];
            }
        }

        // Notifikasi data pending lebih dari 3 hari
        $pendingCount = ProduksiPangan::where('status_valid', 'pending')
            ->where('waktu', '<', Carbon::now()->subDays(3))
            ->count();

        Log::info('Pending Count:', ['count' => $pendingCount]);

        return view('nasional.dashboard', compact('produksiPangan', 'labels', 'datasets', 'pendingCount'));
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
