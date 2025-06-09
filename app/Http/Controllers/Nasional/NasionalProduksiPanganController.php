<?php

namespace App\Http\Controllers\Nasional;

use App\Exports\NasionalProduksiPanganExport;
use App\Http\Controllers\Controller;
use App\Models\ProduksiPangan;
use App\Models\Wilayah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class NasionalProduksiPanganController extends Controller
{
    public function index(Request $request)
    {
        // Ambil id_lokasi representatif untuk setiap provinsi (id pertama)
        $provinsiLokasi = Wilayah::select('provinsi', DB::raw('MIN(id) as id_lokasi'))
            ->groupBy('provinsi')
            ->pluck('id_lokasi', 'provinsi');

        $query = ProduksiPangan::with(['region', 'creator'])
            ->where('status_valid', 'terverifikasi')
            ->whereIn('id_lokasi', $provinsiLokasi); // Hanya record agregat

        if ($request->has('wilayah') && $request->wilayah != '') {
            $query->where('id_lokasi', $request->wilayah);
        }

        if ($request->has('tahun') && $request->tahun != '') {
            $query->where('periode', $request->tahun);
        }

        if ($request->has('komoditas') && $request->komoditas != '') {
            $query->where('komoditas', $request->komoditas);
        }

        $produksiPangan = $query->orderBy('periode', 'desc')->get();

        $wilayahList = Wilayah::select('id', 'provinsi')
            ->distinct('provinsi')
            ->orderBy('provinsi')
            ->get();
        $tahunList = range(2015, 2025);
        $komoditasList = ProduksiPangan::select('komoditas')->distinct()->pluck('komoditas');

        $pendingCount = ProduksiPangan::where('status_valid', 'pending')
            ->whereIn('id_lokasi', $provinsiLokasi)
            ->count();

        return view('nasional.produksi.index', compact(
            'produksiPangan',
            'wilayahList',
            'tahunList',
            'komoditasList',
            'pendingCount'
        ));
    }

    public function pending()
    {
        // Ambil id_lokasi representatif untuk setiap provinsi
        $provinsiLokasi = Wilayah::select('provinsi', DB::raw('MIN(id) as id_lokasi'))
            ->groupBy('provinsi')
            ->pluck('id_lokasi', 'provinsi');

        $pendingProduksi = ProduksiPangan::with(['region', 'creator'])
            ->where('status_valid', 'pending')
            ->whereIn('id_lokasi', $provinsiLokasi) // Hanya record agregat
            ->orderBy('periode', 'desc')
            ->get();

        return view('nasional.produksi.pending', compact('pendingProduksi'));
    }

    public function show(ProduksiPangan $produksiPangan)
    {
        $produksiPangan->load(['region', 'creator']);
        return view('nasional.produksi.show', compact('produksiPangan'));
    }

    public function validasi(Request $request, ProduksiPangan $produksiPangan)
    {
        $request->validate([
            'action' => 'required|in:approve,reject'
        ]);

        // Ambil provinsi dari id_lokasi
        $provinsi = $produksiPangan->region->provinsi;
        $periode = $produksiPangan->periode;
        $komoditas = $produksiPangan->komoditas;

        // Ambil semua id_lokasi untuk provinsi yang sama
        $lokasiProvinsi = Wilayah::where('provinsi', $provinsi)->pluck('id');

        if ($request->action === 'approve') {
            // Setujui semua record untuk provinsi, periode, dan komoditas
            ProduksiPangan::whereIn('id_lokasi', $lokasiProvinsi)
                ->where('periode', $periode)
                ->where('komoditas', $komoditas)
                ->where('status_valid', 'pending')
                ->update(['status_valid' => 'terverifikasi']);
        } else {
            // Tolak dan hapus semua record untuk provinsi, periode, dan komoditas
            ProduksiPangan::whereIn('id_lokasi', $lokasiProvinsi)
                ->where('periode', $periode)
                ->where('komoditas', $komoditas)
                ->where('status_valid', 'pending')
                ->delete();
        }

        return redirect()->route('nasional.produksi.pending')->with('success', 'Data produksi pangan ' . ($request->action === 'approve' ? 'disetujui' : 'ditolak dan dihapus') . '.');
    }

    public function export(Request $request)
    {
        // Ambil id_lokasi representatif untuk setiap provinsi
        $provinsiLokasi = Wilayah::select('provinsi', DB::raw('MIN(id) as id_lokasi'))
            ->groupBy('provinsi')
            ->pluck('id_lokasi', 'provinsi');

        $query = ProduksiPangan::with(['region', 'creator'])
            ->where('status_valid', 'terverifikasi')
            ->whereIn('id_lokasi', $provinsiLokasi);

        if ($request->has('wilayah') && $request->wilayah != '') {
            $query->where('id_lokasi', $request->wilayah);
        }

        if ($request->has('tahun') && $request->tahun != '') {
            $query->where('periode', $request->tahun);
        }

        if ($request->has('komoditas') && $request->komoditas != '') {
            $query->where('komoditas', $request->komoditas);
        }

        return Excel::download(new NasionalProduksiPanganExport($query->get()), 'produksi_pangan_' . date('Ymd') . '.csv');
    }
}
