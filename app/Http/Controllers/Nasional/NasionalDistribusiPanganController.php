<?php

namespace App\Http\Controllers\Nasional;

use App\Http\Controllers\Controller;
use App\Models\DistribusiPangan;
use App\Models\PesanHargaPangan;
use App\Models\Wilayah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\NasionalDistribusiPanganExport;

class NasionalDistribusiPanganController extends Controller
{
    public function index(Request $request)
    {
        $query = DistribusiPangan::with(['region', 'creator']);

        if ($wilayah = $request->query('wilayah')) {
            $query->where('id_wilayah_tujuan', $wilayah);
        }

        if ($komoditas = $request->query('komoditas')) {
            $query->where('komoditas', 'LIKE', "%{$komoditas}%");
        }

        if ($tanggal = $request->query('tanggal')) {
            $query->whereDate('tanggal_kirim', $tanggal);
        }

        if ($status = $request->query('status')) {
            $query->where('status', $status);
        }

        $distribusiPangan = $query->orderBy('tanggal_kirim', 'desc')->get();

        $wilayahList = Wilayah::select('id', 'provinsi', 'kota')
            ->distinct('provinsi')
            ->orderBy('provinsi')
            ->get();
        $komoditasList = DistribusiPangan::select('komoditas')
            ->distinct()
            ->pluck('komoditas');
        $statusList = ['dikirim', 'ditunda', 'terlambat', 'selesai'];

        return view('nasional.distribusi.index', compact(
            'distribusiPangan',
            'wilayahList',
            'komoditasList',
            'statusList'
        ));
    }

    public function show($id)
    {
        $distribusiPangan = DistribusiPangan::with(['region', 'creator'])->findOrFail($id);

        return view('nasional.distribusi.show', compact('distribusiPangan'));
    }

    public function export(Request $request)
    {
        $query = DistribusiPangan::with(['region', 'creator']);

        if ($wilayah = $request->input('wilayah')) {
            $query->where('id_wilayah_tujuan', $wilayah);
        }

        if ($komoditas = $request->input('komoditas')) {
            $query->where('komoditas', 'LIKE', "%{$komoditas}%");
        }

        if ($tanggal = $request->input('tanggal')) {
            $query->whereDate('tanggal_kirim', $tanggal);
        }

        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        $data = $query->get();

        return Excel::download(new NasionalDistribusiPanganExport($data), 'distribusi_pangan_' . date('Ymd') . '.xlsx');
    }
}
