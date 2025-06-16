<?php

namespace App\Http\Controllers;

use App\Models\CadanganPangan;
use App\Models\DistribusiPangan;
use App\Models\HargaPangan;
use App\Models\PrediksiPangan;
use App\Models\ArtikelGizi;
use App\Models\Wilayah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\CadanganPanganExport;

class HomeController extends Controller
{
    public function index()
    {
        return view('landingpage');
    }

    public function cadanganIndex(Request $request)
    {
        $kota = $request->query('kota');
        $kotaList = Wilayah::select('kota')->distinct()->orderBy('kota')->pluck('kota');

        $query = CadanganPangan::where('status_valid', 'terverifikasi')
            ->with('region');

        if ($kota) {
            $query->whereHas('region', function ($q) use ($kota) {
                $q->where('kota', $kota);
            });
        }

        $cadanganData = $query->get();
        $totalCadangan = $cadanganData->sum('jumlah');

        return view('user.cadangan.index', compact(
            'cadanganData',
            'totalCadangan',
            'kotaList',
            'kota'
        ));
    }

    public function cadanganExport(Request $request)
    {
        $kota = $request->input('kota');
        return Excel::download(new CadanganPanganExport($kota), 'cadangan_pangan_' . ($kota ?? 'nasional') . '.xlsx');
    }

    public function hargaIndex(Request $request)
    {
        $kota = $request->query('kota');
        $kotaList = Wilayah::select('kota')->distinct()->orderBy('kota')->pluck('kota');
        $komoditasList = ['Beras', 'Padi', 'Jagung', 'Gandum', 'Sagu'];

        $hargaData = [];
        foreach ($komoditasList as $komoditas) {
            $query = HargaPangan::where('komoditas', $komoditas);
            if ($kota) {
                $query->whereHas('region', function ($q) use ($kota) {
                    $q->where('kota', $kota);
                })->latest('tanggal')->take(1);
            } else {
                $query->select(DB::raw('AVG(harga_per_kg) as avg_harga'))->whereNotNull('harga_per_kg');
            }
            $result = $query->first();
            $hargaData[$komoditas] = $kota ? ($result->harga_per_kg ?? null) : ($result->avg_harga ?? null);
        }

        return view('user.harga.index', compact(
            'hargaData',
            'kotaList',
            'kota',
            'komoditasList'
        ));
    }

    public function distribusiIndex(Request $request)
    {
        $kota = $request->query('kota');
        $kotaList = Wilayah::select('kota')->distinct()->orderBy('kota')->pluck('kota');

        $query = DistribusiPangan::with('region');
        if ($kota) {
            $query->whereHas('region', function ($q) use ($kota) {
                $q->where('kota', $kota);
            });
        }

        $distribusiData = $query->get();
        $totalDistribusi = $distribusiData->sum('jumlah');

        return view('user.distribusi.index', compact(
            'distribusiData',
            'totalDistribusi',
            'kotaList',
            'kota'
        ));
    }

    public function prediksiIndex(Request $request)
    {
        $kota = $request->query('kota');
        $tahun = $request->query('tahun');
        $kotaList = Wilayah::select('kota')->distinct()->orderBy('kota')->pluck('kota');
        $tahunList = PrediksiPangan::select(DB::raw('YEAR(bulan_tahun) as tahun'))
            ->distinct()
            ->orderBy('tahun', 'desc')
            ->pluck('tahun');
        $komoditasList = ['Beras', 'Padi', 'Jagung', 'Gandum', 'Sagu'];

        $query = PrediksiPangan::where('status', 'disetujui')->with('region');
        if ($kota) {
            $query->whereHas('region', function ($q) use ($kota) {
                $q->where('kota', $kota);
            });
        }
        if ($tahun) {
            $query->whereYear('bulan_tahun', $tahun);
        }

        $prediksiData = $query->get();

        $chartLabels = $tahunList;
        $chartDatasets = [];
        $colors = [
            'Beras' => 'rgba(255, 99, 132, 1)',
            'Padi' => 'rgba(54, 162, 235, 1)',
            'Jagung' => 'rgba(75, 192, 192, 1)',
            'Gandum' => 'rgba(255, 206, 86, 1)',
            'Sagu' => 'rgba(153, 102, 255, 1)',
        ];

        foreach ($komoditasList as $komoditas) {
            $data = $chartLabels->map(function ($tahunItem) use ($komoditas, $kota) {
                $query = PrediksiPangan::where('komoditas', $komoditas)
                    ->where('status', 'disetujui')
                    ->whereYear('bulan_tahun', $tahunItem);
                if ($kota) {
                    $query->whereHas('region', function ($q) use ($kota) {
                        $q->where('kota', $kota);
                    });
                }
                return $query->sum('jumlah');
            })->toArray();
            $chartDatasets[] = [
                'label' => $komoditas,
                'data' => $data,
                'borderColor' => $colors[$komoditas],
                'fill' => false,
                'tension' => 0.3,
                'pointRadius' => 5,
                'pointHoverRadius' => 7,
            ];
        }

        return view('user.prediksi.index', compact(
            'prediksiData',
            'kotaList',
            'tahunList',
            'kota',
            'tahun',
            'chartLabels',
            'chartDatasets'
        ));
    }

    public function edukasiIndex(Request $request)
    {
        $kategori = $request->query('kategori');
        $kategoriList = ArtikelGizi::select('kategori')->distinct()->orderBy('kategori')->pluck('kategori');

        $query = ArtikelGizi::with('author');
        if ($kategori) {
            $query->where('kategori', $kategori);
        }

        $artikelData = $query->orderBy('jumlah_akses', 'desc')->get();
        $kategoriCounts = ArtikelGizi::select('kategori', DB::raw('COUNT(*) as total'))
            ->groupBy('kategori')
            ->get()
            ->pluck('total', 'kategori');

        return view('user.edukasi.index', compact(
            'artikelData',
            'kategoriList',
            'kategori',
            'kategoriCounts'
        ));
    }

    public function edukasiShow($id)
    {
        $artikel = ArtikelGizi::with('author')->findOrFail($id);
        $artikel->increment('jumlah_akses');

        return view('user.edukasi.show', compact('artikel'));
    }
}
