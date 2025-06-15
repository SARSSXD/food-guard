<?php

namespace App\Http\Controllers\Nasional;

use App\Http\Controllers\Controller;
use App\Models\CadanganPangan;
use App\Models\Wilayah;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\NasionalCadanganPanganExport;
use Illuminate\Support\Facades\DB;

class NasionalCadanganPanganController extends Controller
{
    public function index(Request $request)
    {
        // Ambil provinsi unik dan ID wilayah agregat (MIN(id) per provinsi)
        $wilayahList = Wilayah::select('provinsi', DB::raw('MIN(id) as id'))
            ->groupBy('provinsi')
            ->orderBy('provinsi')
            ->get();

        $provinsiLokasi = Wilayah::select('provinsi', DB::raw('MIN(id) as id_lokasi'))
            ->groupBy('provinsi')
            ->pluck('id_lokasi', 'provinsi');
        // Ambil daftar tahun dan komoditas
        $tahunList = CadanganPangan::select('periode')
            ->distinct()
            ->orderBy('periode', 'desc')
            ->pluck('periode');
        $komoditasList = CadanganPangan::select('komoditas')
            ->distinct()
            ->orderBy('komoditas')
            ->pluck('komoditas');

        // Hitung jumlah pengajuan pending
        $pendingCount = CadanganPangan::where('status_valid', 'pending')
            ->whereIn('id_lokasi', $provinsiLokasi)
            ->count();
        // Query data agregat
        $aggregateIds = Wilayah::select(DB::raw('MIN(id) as id'))
            ->groupBy('provinsi')
            ->pluck('id');

        $query = CadanganPangan::with('region')
            ->whereIn('id_lokasi', $aggregateIds)
            ->where('status_valid', 'terverifikasi');

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

        $cadanganPangan = $query->orderBy('periode', 'desc')->get();

        return view('nasional.cadangan.index', compact(
            'cadanganPangan',
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

        $pendingCadangan = CadanganPangan::with(['region'])
            ->where('status_valid', 'pending')
            ->whereIn('id_lokasi', $provinsiLokasi)
            ->orderBy('periode', 'desc')
            ->get();

        return view('nasional.cadangan.pending', compact('pendingCadangan'));
    }

    public function show(CadanganPangan $cadanganPangan)
    {
        $cadanganPangan->load(['region']);
        return view('nasional.cadangan.show', compact('cadanganPangan'));
    }

    public function validasi(Request $request, CadanganPangan $cadanganPangan)
    {
        $request->validate([
            'action' => 'required|in:approve,reject'
        ]);

        // Ambil provinsi dari id_lokasi
        $provinsi = $cadanganPangan->region->provinsi;
        $periode = $cadanganPangan->periode;
        $komoditas = $cadanganPangan->komoditas;

        // Ambil semua id_lokasi untuk provinsi yang sama
        $lokasiProvinsi = Wilayah::where('provinsi', $provinsi)->pluck('id');

        if ($request->action === 'approve') {
            // Setujui semua record untuk provinsi, periode, dan komoditas
            CadanganPangan::whereIn('id_lokasi', $lokasiProvinsi)
                ->where('periode', $periode)
                ->where('komoditas', $komoditas)
                ->where('status_valid', 'pending')
                ->update(['status_valid' => 'terverifikasi']);
        } else {
            // Tolak dan hapus semua record untuk provinsi, periode, dan komoditas
            CadanganPangan::whereIn('id_lokasi', $lokasiProvinsi)
                ->where('periode', $periode)
                ->where('komoditas', $komoditas)
                ->where('status_valid', 'pending')
                ->delete();
        }

        return redirect()->route('nasional.cadangan.pending')->with('success', 'Data cadangan pangan ' . ($request->action === 'approve' ? 'disetujui' : 'ditolak dan dihapus') . '.');
    }

    public function export(Request $request)
    {
        // Ambil id_lokasi representatif untuk setiap provinsi
        $aggregateIds = Wilayah::select(DB::raw('MIN(id) as id'))
            ->groupBy('provinsi')
            ->pluck('id');

        $query = CadanganPangan::with('region')
            ->whereIn('id_lokasi', $aggregateIds)
            ->where('status_valid', 'terverifikasi');

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

        return Excel::download(new NasionalCadanganPanganExport($data), 'cadangan_pangan_' . date('Ymd') . '.xlsx');
    }
}
