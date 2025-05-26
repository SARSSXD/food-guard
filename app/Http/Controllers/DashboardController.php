<?php

namespace App\Http\Controllers;

use App\Models\ProduksiPangan;
use App\Models\Lokasi;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    public function nasional()
    {
        $produksiPangan = ProduksiPangan::with('lokasi', 'creator')->orderBy('waktu', 'desc')->get();

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
        $lokasi = Lokasi::all();
        $produksiPangan = ProduksiPangan::with('lokasi')
            ->whereHas('lokasi', function ($query) {
                $query->where('Id_lokasi', Auth::user()->Id_region);
            })
            ->latest()
            ->take(5)
            ->get();
        return view('daerah.dashboard', compact('lokasi', 'produksiPangan'));
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
