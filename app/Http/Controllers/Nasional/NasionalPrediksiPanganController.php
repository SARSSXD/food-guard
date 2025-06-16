<?php

namespace App\Http\Controllers\Nasional;

use App\Http\Controllers\Controller;
use App\Models\PrediksiPangan;
use App\Models\PesanPrediksiPangan;
use App\Models\Wilayah;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\NasionalPrediksiPanganExport;
use Illuminate\Support\Facades\DB;

class NasionalPrediksiPanganController extends Controller
{
    public function index(Request $request)
    {
        // Ambil provinsi unik dan ID wilayah agregat (MIN(id) per provinsi)
        $wilayahList = Wilayah::select('provinsi', DB::raw('MIN(id) as id'))
            ->groupBy('provinsi')
            ->orderBy('provinsi')
            ->get();

        // Ambil daftar tahun, komoditas, dan jenis
        $tahunList = PrediksiPangan::select(DB::raw('YEAR(bulan_tahun) as tahun'))
            ->distinct()
            ->orderBy('tahun', 'desc')
            ->pluck('tahun');
        $komoditasList = PrediksiPangan::select('komoditas')
            ->distinct()
            ->orderBy('komoditas')
            ->pluck('komoditas');
        $jenisList = ['produksi', 'cadangan'];

        // Query data prediksi agregat
        $aggregateIds = Wilayah::select(DB::raw('MIN(id) as id'))
            ->groupBy('provinsi')
            ->pluck('id');

        $query = PrediksiPangan::with('region')
            ->whereIn('id_lokasi', $aggregateIds);

        // Filter berdasarkan input
        if ($wilayah = $request->query('wilayah')) {
            $query->where('id_lokasi', $wilayah);
        }
        if ($tahun = $request->query('tahun')) {
            $query->whereYear('bulan_tahun', $tahun);
        }
        if ($komoditas = $request->query('komoditas')) {
            $query->where('komoditas', $komoditas);
        }
        if ($jenis = $request->query('jenis')) {
            $query->where('jenis', $jenis);
        }

        $prediksiPangan = $query->orderBy('bulan_tahun', 'desc')->get();

        // Data untuk grafik (total jumlah per komoditas per tahun, skala nasional)
        $chartData = PrediksiPangan::whereIn('id_lokasi', $aggregateIds)
            ->whereIn('komoditas', ['Beras', 'Padi', 'Jagung', 'Gandum', 'Sagu'])
            ->select(
                DB::raw('YEAR(bulan_tahun) as tahun'),
                'komoditas',
                DB::raw('SUM(jumlah) as total_jumlah')
            )
            ->groupBy('tahun', 'komoditas')
            ->orderBy('tahun')
            ->get();

        $chartLabels = $chartData->pluck('tahun')->unique()->sort()->values();
        $chartDatasets = [];
        foreach (['Beras', 'Padi', 'Jagung', 'Gandum', 'Sagu'] as $komoditas) {
            $data = $chartLabels->map(function ($tahun) use ($chartData, $komoditas) {
                return $chartData->where('tahun', $tahun)->where('komoditas', $komoditas)->sum('total_jumlah');
            })->toArray();
            $chartDatasets[] = [
                'label' => $komoditas,
                'data' => $data,
                'backgroundColor' => sprintf('rgba(%d, %d, %d, 0.5)', rand(0, 255), rand(0, 255), rand(0, 255)),
                'borderColor' => sprintf('rgba(%d, %d, %d, 1)', rand(0, 255), rand(0, 255), rand(0, 255)),
                'borderWidth' => 1,
            ];
        }

        return view('nasional.prediksi.index', compact(
            'prediksiPangan',
            'wilayahList',
            'tahunList',
            'komoditasList',
            'jenisList',
            'chartLabels',
            'chartDatasets'
        ));
    }

    public function storeMessage(Request $request)
    {
        $request->validate([
            'provinsi' => 'required|string',
            'komoditas' => 'required|string',
            'bulan_tahun' => 'required|string',
            'pesan' => 'required|string',
        ]);

        PesanPrediksiPangan::create([
            'provinsi' => $request->provinsi,
            'komoditas' => $request->komoditas,
            'bulan_tahun' => $request->bulan_tahun,
            'pesan' => $request->pesan,
            'created_by' => auth()->id(),
        ]);

        return redirect()->route('nasional.prediksi.index')->with('success', 'Pesan berhasil dikirim.');
    }

    public function export(Request $request)
    {
        $aggregateIds = Wilayah::select(DB::raw('MIN(id) as id'))
            ->groupBy('provinsi')
            ->pluck('id');

        $query = PrediksiPangan::with('region')
            ->whereIn('id_lokasi', $aggregateIds);

        if ($wilayah = $request->input('wilayah')) {
            $query->where('id_lokasi', $wilayah);
        }
        if ($tahun = $request->input('tahun')) {
            $query->whereYear('bulan_tahun', $tahun);
        }
        if ($komoditas = $request->input('komoditas')) {
            $query->where('komoditas', $komoditas);
        }
        if ($jenis = $request->input('jenis')) {
            $query->where('jenis', $jenis);
        }

        $data = $query->get();

        return Excel::download(new NasionalPrediksiPanganExport($data), 'prediksi_pangan_' . date('Ymd') . '.xlsx');
    }
}
