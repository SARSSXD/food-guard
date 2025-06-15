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
        // Ambil provinsi unik dan ID wilayah agregat (MIN(id) per provinsi)
        $wilayahList = Wilayah::select('provinsi', DB::raw('MIN(id) as id'))
            ->groupBy('provinsi')
            ->orderBy('provinsi')
            ->get();

        // Ambil daftar tahun dan komoditas
        $tahunList = ProduksiPangan::select('periode')
            ->distinct()
            ->orderBy('periode', 'desc')
            ->pluck('periode');
        $komoditasList = ProduksiPangan::select('komoditas')
            ->distinct()
            ->orderBy('komoditas')
            ->pluck('komoditas');

        // Hitung jumlah pengajuan pending
        $provinsiLokasi = Wilayah::select('provinsi', DB::raw('MIN(id) as id_lokasi'))
            ->groupBy('provinsi')
            ->pluck('id_lokasi', 'provinsi');
        $pendingCount = ProduksiPangan::where('status_valid', 'pending')
            ->whereIn('id_lokasi', $provinsiLokasi)
            ->count();

        // Query data agregat
        $aggregateIds = Wilayah::select(DB::raw('MIN(id) as id'))
            ->groupBy('provinsi')
            ->pluck('id');

        $query = ProduksiPangan::with('region')
            ->whereIn('id_lokasi', $aggregateIds);

        // Filter berdasarkan input
        if ($wilayah = $request->query('wilayah')) {
            $query->where('id_lokasi', $wilayah);
        }

        if ($tahun = $request->query('tahun')) {
            $query->where('periode', $tahun);
        }

        if ($komoditas = $request->query('komoditas')) {
            $query->where('komoditas', 'LIKE', "%{$komoditas}%");
        }

        $produksiPangan = $query->orderBy('periode', 'desc')->get();

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
        // Ambil data agregat untuk ekspor
        $aggregateIds = Wilayah::select(DB::raw('MIN(id) as id'))
            ->groupBy('provinsi')
            ->pluck('id');

        $query = ProduksiPangan::with('region')
            ->whereIn('id_lokasi', $aggregateIds);

        if ($wilayah = $request->input('wilayah')) {
            $query->where('id_lokasi', $wilayah);
        }

        if ($tahun = $request->input('tahun')) {
            $query->where('periode', $tahun);
        }

        if ($komoditas = $request->input('komoditas')) {
            $query->where('komoditas', 'LIKE', "%{$komoditas}%");
        }

        $data = $query->get();

        return Excel::download(new NasionalProduksiPanganExport($data), 'produksi_pangan_' . date('Ymd') . '.xlsx');
    }
}
