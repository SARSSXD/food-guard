<?php

namespace App\Http\Controllers\Nasional;

use App\Http\Controllers\Controller;
use App\Models\PrediksiPangan;
use App\Models\PesanPrediksiPangan;
use App\Models\Wilayah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NasionalPrediksiPanganController extends Controller
{
    public function index(Request $request)
    {
        $query = PrediksiPangan::with(['region', 'creator']);

        if ($provinsi = $request->query('provinsi')) {
            $query->where('id_lokasi', $provinsi);
        }
        if ($komoditas = $request->query('komoditas')) {
            $query->where('komoditas', 'LIKE', "%{$komoditas}%");
        }
        if ($jenis = $request->query('jenis')) {
            $query->where('jenis', $jenis);
        }
        if ($tahun = $request->query('tahun')) {
            $query->whereYear('bulan_tahun', $tahun);
        }

        $prediksi = $query->orderBy('bulan_tahun', 'desc')->get();
        $wilayahList = Wilayah::select('id', 'provinsi')->distinct('provinsi')->orderBy('provinsi')->get();
        $komoditasList = PrediksiPangan::select('komoditas')->distinct()->pluck('komoditas');
        $jenisList = ['produksi', 'cadangan'];
        $tahunList = range(2020, date('Y') + 1); // Dynamic year range

        // Data untuk grafik
        $chartData = $this->getChartData($request->provinsi, $request->komoditas, $request->jenis);

        return view('nasional.prediksi.index', compact(
            'prediksi',
            'wilayahList',
            'komoditasList',
            'jenisList',
            'tahunList',
            'chartData'
        ));
    }

    private function getChartData($provinsi, $komoditas, $jenis)
    {
        $query = PrediksiPangan::selectRaw('DATE_FORMAT(bulan_tahun, "%Y-%m") as month, SUM(jumlah) as total')
            ->groupBy('month')
            ->orderBy('month');

        if ($provinsi) {
            $query->where('id_lokasi', $provinsi);
        }
        if ($komoditas) {
            $query->where('komoditas', $komoditas);
        }
        if ($jenis) {
            $query->where('jenis', $jenis);
        }

        $data = $query->get();

        return [
            'labels' => $data->pluck('month'),
            'datasets' => [
                [
                    'label' => 'Jumlah Prediksi (Ton)',
                    'data' => $data->pluck('total'),
                    'borderColor' => 'rgba(54, 162, 235, 1)',
                    'backgroundColor' => 'rgba(54, 162, 235, 0.2)',
                    'fill' => true,
                ]
            ]
        ];
    }

    public function store(Request $request)
    {
        $request->validate([
            'jenis' => 'required|in:produksi,cadangan',
            'komoditas' => 'required|string|max:255',
            'id_lokasi' => 'required|exists:wilayah,id',
            'bulan_tahun' => 'required|date_format:Y-m-01',
            'jumlah' => 'required|numeric|min:0',
            'metode' => 'required|string|max:255',
            'status' => 'required|in:draft,disetujui,revisi',
        ]);

        PrediksiPangan::create([
            'jenis' => $request->jenis,
            'komoditas' => $request->komoditas,
            'id_lokasi' => $request->id_lokasi,
            'bulan_tahun' => $request->bulan_tahun,
            'jumlah' => $request->jumlah,
            'metode' => $request->metode,
            'status' => $request->status,
            'created_by' => Auth::id(),
        ]);

        return redirect()->route('nasional.prediksi.index')->with('success', 'Prediksi berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $prediksi = PrediksiPangan::findOrFail($id);

        $request->validate([
            'status' => 'required|in:draft,disetujui,revisi',
            'pesan' => 'required_if:status,revisi|string|max:1000',
        ]);

        $prediksi->update([
            'status' => $request->status,
        ]);

        if ($request->status === 'revisi' && $request->pesan) {
            PesanPrediksiPangan::create([
                'provinsi' => $prediksi->region->provinsi,
                'komoditas' => $prediksi->komoditas,
                'bulan_tahun' => \Carbon\Carbon::parse($prediksi->bulan_tahun)->format('Y-m'),
                'pesan' => $request->pesan,
                'created_by' => Auth::id(),
            ]);
        }

        return redirect()->route('nasional.prediksi.index')->with('success', 'Status prediksi berhasil diupdate.');
    }

    public function kirimPesan(Request $request)
    {
        $request->validate([
            'provinsi' => 'required|string|max:255',
            'komoditas' => 'required|string|max:255',
            'bulan_tahun' => 'required|string|max:7',
            'pesan' => 'required|string|max:1000',
        ]);

        PesanPrediksiPangan::create([
            'provinsi' => $request->provinsi,
            'komoditas' => $request->komoditas,
            'bulan_tahun' => $request->bulan_tahun,
            'pesan' => $request->pesan,
            'created_by' => Auth::id(),
        ]);

        return redirect()->route('nasional.prediksi.index')->with('success', 'Pesan berhasil dikirim.');
    }
}
