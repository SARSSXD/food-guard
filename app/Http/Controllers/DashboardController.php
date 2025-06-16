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
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function nasional(Request $request)
    {
        // Ambil ID wilayah agregat
        $aggregateIds = Wilayah::select(DB::raw('MIN(id) as id'))
            ->groupBy('provinsi')
            ->pluck('id');

        // Ambil daftar filter
        $provinsiList = Wilayah::select('provinsi', DB::raw('MIN(id) as id'))
            ->groupBy('provinsi')
            ->orderBy('provinsi')
            ->get();
        $komoditasList = ['Beras', 'Padi', 'Jagung', 'Gandum', 'Sagu'];
        $tahunList = ProduksiPangan::select('periode as tahun')
            ->union(CadanganPangan::select('periode as tahun'))
            ->union(HargaPangan::select(DB::raw('YEAR(tanggal) as tahun')))
            ->distinct()
            ->orderBy('tahun', 'desc')
            ->pluck('tahun');

        // Ambil input filter
        $provinsi = $request->query('provinsi');
        $komoditas = $request->query('komoditas');
        $tahun = $request->query('tahun');

        // Kartu Statistik
        $queryProduksi = ProduksiPangan::whereIn('id_lokasi', $aggregateIds)
            ->where('status_valid', 'terverifikasi');
        $queryCadangan = CadanganPangan::whereIn('id_lokasi', $aggregateIds);
        $queryHarga = HargaPangan::whereIn('id_lokasi', $aggregateIds)
            ->whereIn('komoditas', $komoditasList);

        if ($provinsi) {
            $queryProduksi->where('id_lokasi', $provinsi);
            $queryCadangan->where('id_lokasi', $provinsi);
            $queryHarga->where('id_lokasi', $provinsi);
        }
        if ($komoditas) {
            $queryProduksi->where('komoditas', $komoditas);
            $queryCadangan->where('komoditas', $komoditas);
            $queryHarga->where('komoditas', $komoditas);
        }
        if ($tahun) {
            $queryProduksi->where('periode', $tahun);
            $queryCadangan->where('periode', $tahun);
            $queryHarga->whereYear('tanggal', $tahun);
        }

        $totalProduksi = $queryProduksi->sum('jumlah');
        $totalCadangan = $queryCadangan->sum('jumlah');
        $avgHarga = $queryHarga->avg('harga_per_kg') ?? 0;

        // Grafik 1: Line Chart (Tren Produksi dan Cadangan)
        $queryChartProduksi = ProduksiPangan::whereIn('id_lokasi', $aggregateIds)
            ->whereIn('komoditas', $komoditasList)
            ->where('status_valid', 'terverifikasi')
            ->select(
                'periode as tahun',
                'komoditas',
                DB::raw('SUM(jumlah) as total_jumlah')
            )
            ->groupBy('tahun', 'komoditas')
            ->orderBy('tahun');
        $queryChartCadangan = CadanganPangan::whereIn('id_lokasi', $aggregateIds)
            ->whereIn('komoditas', $komoditasList)
            ->select(
                'periode as tahun',
                'komoditas',
                DB::raw('SUM(jumlah) as total_jumlah')
            )
            ->groupBy('tahun', 'komoditas')
            ->orderBy('tahun');

        if ($provinsi) {
            $queryChartProduksi->where('id_lokasi', $provinsi);
            $queryChartCadangan->where('id_lokasi', $provinsi);
        }
        if ($komoditas) {
            $queryChartProduksi->where('komoditas', $komoditas);
            $queryChartCadangan->where('komoditas', $komoditas);
        }
        if ($tahun) {
            $queryChartProduksi->where('periode', $tahun);
            $queryChartCadangan->where('periode', $tahun);
        }

        $chartDataProduksi = $queryChartProduksi->get();
        $chartDataCadangan = $queryChartCadangan->get();

        $chartLabelsLine = $chartDataProduksi->pluck('tahun')
            ->merge($chartDataCadangan->pluck('tahun'))
            ->unique()
            ->sort()
            ->values();

        $colors = [
            'Beras' => ['border' => 'rgba(255, 99, 132, 1)', 'bg' => 'rgba(255, 99, 132, 0.5)'],
            'Padi' => ['border' => 'rgba(54, 162, 235, 1)', 'bg' => 'rgba(54, 162, 235, 0.5)'],
            'Jagung' => ['border' => 'rgba(75, 192, 192, 1)', 'bg' => 'rgba(75, 192, 192, 0.5)'],
            'Gandum' => ['border' => 'rgba(255, 206, 86, 1)', 'bg' => 'rgba(255, 206, 86, 0.5)'],
            'Sagu' => ['border' => 'rgba(153, 102, 255, 1)', 'bg' => 'rgba(153, 102, 255, 0.5)'],
        ];

        $chartDatasetsLine = [];
        foreach ($komoditasList as $komoditasItem) {
            if (!$komoditas || $komoditas == $komoditasItem) {
                $dataProduksi = $chartLabelsLine->map(function ($tahunItem) use ($chartDataProduksi, $komoditasItem) {
                    return $chartDataProduksi->where('tahun', $tahunItem)->where('komoditas', $komoditasItem)->sum('total_jumlah');
                })->toArray();
                $chartDatasetsLine[] = [
                    'label' => "Produksi $komoditasItem",
                    'data' => $dataProduksi,
                    'borderColor' => $colors[$komoditasItem]['border'],
                    'fill' => false,
                    'tension' => 0.3,
                    'pointRadius' => 5,
                    'pointHoverRadius' => 7,
                ];

                $dataCadangan = $chartLabelsLine->map(function ($tahunItem) use ($chartDataCadangan, $komoditasItem) {
                    return $chartDataCadangan->where('tahun', $tahunItem)->where('komoditas', $komoditasItem)->sum('total_jumlah');
                })->toArray();
                $chartDatasetsLine[] = [
                    'label' => "Cadangan $komoditasItem",
                    'data' => $dataCadangan,
                    'borderColor' => $colors[$komoditasItem]['border'],
                    'borderDash' => [5, 5],
                    'fill' => false,
                    'tension' => 0.3,
                    'pointRadius' => 5,
                    'pointHoverRadius' => 7,
                ];
            }
        }

        // Grafik 2: Pie Chart (Distribusi Produksi per Komoditas)
        $pieProduksiData = ProduksiPangan::whereIn('id_lokasi', $aggregateIds)
            ->whereIn('komoditas', $komoditasList)
            ->where('status_valid', 'terverifikasi');
        if ($provinsi) {
            $pieProduksiData->where('id_lokasi', $provinsi);
        }
        if ($komoditas) {
            $pieProduksiData->where('komoditas', $komoditas);
        }
        if ($tahun) {
            $pieProduksiData->where('periode', $tahun);
        }
        $pieProduksiData = $pieProduksiData->select(
            'komoditas',
            DB::raw('SUM(jumlah) as total_jumlah')
        )
            ->groupBy('komoditas')
            ->get();

        $pieProduksiLabels = $pieProduksiData->pluck('komoditas');
        $pieProduksiValues = $pieProduksiData->pluck('total_jumlah');
        $pieProduksiColors = $pieProduksiLabels->map(fn($komoditasItem) => $colors[$komoditasItem]['bg'])->toArray();

        // Grafik 3: Bar Chart (Rata-rata Harga per Komoditas)
        $barHargaData = HargaPangan::whereIn('id_lokasi', $aggregateIds)
            ->whereIn('komoditas', $komoditasList);
        if ($provinsi) {
            $barHargaData->where('id_lokasi', $provinsi);
        }
        if ($komoditas) {
            $barHargaData->where('komoditas', $komoditas);
        }
        if ($tahun) {
            $barHargaData->whereYear('tanggal', $tahun);
        }
        $barHargaData = $barHargaData->select(
            DB::raw('YEAR(tanggal) as tahun'),
            'komoditas',
            DB::raw('AVG(harga_per_kg) as avg_harga')
        )
            ->groupBy('tahun', 'komoditas')
            ->orderBy('tahun')
            ->get();

        $chartLabelsBar = $barHargaData->pluck('tahun')->unique()->sort()->values();
        $chartDatasetsBar = [];
        foreach ($komoditasList as $komoditasItem) {
            if (!$komoditas || $komoditas == $komoditasItem) {
                $data = $chartLabelsBar->map(function ($tahunItem) use ($barHargaData, $komoditasItem) {
                    return $barHargaData->where('tahun', $tahunItem)->where('komoditas', $komoditasItem)->sum('avg_harga');
                })->toArray();
                $chartDatasetsBar[] = [
                    'label' => $komoditasItem,
                    'data' => $data,
                    'backgroundColor' => $colors[$komoditasItem]['bg'],
                    'borderColor' => $colors[$komoditasItem]['border'],
                    'borderWidth' => 1,
                ];
            }
        }

        // Grafik 4: Pie Chart (Distribusi Cadangan per Komoditas)
        $pieCadanganData = CadanganPangan::whereIn('id_lokasi', $aggregateIds)
            ->whereIn('komoditas', $komoditasList);
        if ($provinsi) {
            $pieCadanganData->where('id_lokasi', $provinsi);
        }
        if ($komoditas) {
            $pieCadanganData->where('komoditas', $komoditas);
        }
        if ($tahun) {
            $pieCadanganData->where('periode', $tahun);
        }
        $pieCadanganData = $pieCadanganData->select(
            'komoditas',
            DB::raw('SUM(jumlah) as total_jumlah')
        )
            ->groupBy('komoditas')
            ->get();

        $pieCadanganLabels = $pieCadanganData->pluck('komoditas');
        $pieCadanganValues = $pieCadanganData->pluck('total_jumlah');
        $pieCadanganColors = $pieCadanganLabels->map(fn($komoditasItem) => $colors[$komoditasItem]['bg'])->toArray();

        // Grafik 5: Line Chart (Tren Harga)
        $lineHargaData = HargaPangan::whereIn('id_lokasi', $aggregateIds)
            ->whereIn('komoditas', $komoditasList);
        if ($provinsi) {
            $lineHargaData->where('id_lokasi', $provinsi);
        }
        if ($komoditas) {
            $lineHargaData->where('komoditas', $komoditas);
        }
        if ($tahun) {
            $lineHargaData->whereYear('tanggal', $tahun);
        }
        $lineHargaData = $lineHargaData->select(
            DB::raw('YEAR(tanggal) as tahun'),
            'komoditas',
            DB::raw('AVG(harga_per_kg) as avg_harga')
        )
            ->groupBy('tahun', 'komoditas')
            ->orderBy('tahun')
            ->get();

        $chartLabelsLineHarga = $lineHargaData->pluck('tahun')->unique()->sort()->values();
        $chartDatasetsLineHarga = [];
        foreach ($komoditasList as $komoditasItem) {
            if (!$komoditas || $komoditas == $komoditasItem) {
                $data = $chartLabelsLineHarga->map(function ($tahunItem) use ($lineHargaData, $komoditasItem) {
                    return $lineHargaData->where('tahun', $tahunItem)->where('komoditas', $komoditasItem)->sum('avg_harga');
                })->toArray();
                $chartDatasetsLineHarga[] = [
                    'label' => $komoditasItem,
                    'data' => $data,
                    'borderColor' => $colors[$komoditasItem]['border'],
                    'fill' => false,
                    'tension' => 0.3,
                    'pointRadius' => 5,
                    'pointHoverRadius' => 7,
                ];
            }
        }

        // Log untuk debug
        Log::info('Dashboard Data:', [
            'filters' => ['provinsi' => $provinsi, 'komoditas' => $komoditas, 'tahun' => $tahun],
            'line_labels' => $chartLabelsLine->toArray(),
            'line_datasets' => $chartDatasetsLine,
            'pie_produksi' => ['labels' => $pieProduksiLabels->toArray(), 'values' => $pieProduksiValues->toArray()],
            'bar_harga' => ['labels' => $chartLabelsBar->toArray(), 'datasets' => $chartDatasetsBar],
            'pie_cadangan' => ['labels' => $pieCadanganLabels->toArray(), 'values' => $pieCadanganValues->toArray()],
            'line_harga' => ['labels' => $chartLabelsLineHarga->toArray(), 'datasets' => $chartDatasetsLineHarga],
        ]);

        return view('nasional.dashboard', compact(
            'totalProduksi',
            'totalCadangan',
            'avgHarga',
            'provinsiList',
            'komoditasList',
            'tahunList',
            'provinsi',
            'komoditas',
            'tahun',
            'chartLabelsLine',
            'chartDatasetsLine',
            'pieProduksiLabels',
            'pieProduksiValues',
            'pieProduksiColors',
            'chartLabelsBar',
            'chartDatasetsBar',
            'pieCadanganLabels',
            'pieCadanganValues',
            'pieCadanganColors',
            'chartLabelsLineHarga',
            'chartDatasetsLineHarga'
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
}
