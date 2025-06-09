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
        // Ambil id_lokasi representatif untuk setiap provinsi (id pertama)
        $provinsiLokasi = Wilayah::select('provinsi', DB::raw('MIN(id) as id_lokasi'))
            ->groupBy('provinsi')
            ->pluck('id_lokasi', 'provinsi');

        $query = CadanganPangan::with(['region'])
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

        $cadanganPangan = $query->orderBy('periode', 'desc')->get();

        $wilayahList = Wilayah::select('id', 'provinsi')
            ->distinct('provinsi')
            ->orderBy('provinsi')
            ->get();
        $tahunList = range(2015, 2025);
        $komoditasList = CadanganPangan::select('komoditas')->distinct()->pluck('komoditas');

        $pendingCount = CadanganPangan::where('status_valid', 'pending')
            ->whereIn('id_lokasi', $provinsiLokasi)
            ->count();

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
        $provinsiLokasi = Wilayah::select('provinsi', DB::raw('MIN(id) as id_lokasi'))
            ->groupBy('provinsi')
            ->pluck('id_lokasi', 'provinsi');

        $query = CadanganPangan::with(['region'])
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

        return Excel::download(new NasionalCadanganPanganExport($query->get()), 'cadangan_pangan_' . date('Ymd') . '.csv');
    }
}
