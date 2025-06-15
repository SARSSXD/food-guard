<?php

namespace App\Http\Controllers\Nasional;

use App\Http\Controllers\Controller;
use App\Models\HargaPangan;
use App\Models\PesanHargaPangan;
use App\Models\Wilayah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\NasionalHargaPanganExport;

class NasionalHargaPanganController extends Controller
{
    public function index(Request $request)
    {
        $query = HargaPangan::with(['region', 'creator']);

        if ($wilayah = $request->query('wilayah')) {
            $query->where('id_lokasi', $wilayah);
        }

        if ($komoditas = $request->query('komoditas')) {
            $query->where('komoditas', 'LIKE', "%{$komoditas}%");
        }

        $hargaPangan = $query->orderBy('tanggal', 'desc')->get();

        $wilayahList = Wilayah::select('id', 'provinsi', 'kota')
            ->distinct('provinsi')
            ->orderBy('provinsi')
            ->get();
        $komoditasList = HargaPangan::select('komoditas')
            ->distinct()
            ->pluck('komoditas');

        return view('nasional.harga.index', compact(
            'hargaPangan',
            'wilayahList',
            'komoditasList'
        ));
    }

    public function kirimPesan(Request $request)
    {
        dd ($request->all());
        $request->validate([
            'id_wilayah' => 'required|exists:wilayah,id',
            'komoditas' => 'required|string|max:255',
            'tahun' => 'required|string|size:4',
            'pesan' => 'required|string|max:1000',
        ]);

        PesanHargaPangan::create([
            'id_wilayah' => $request->id_wilayah,
            'komoditas' => $request->komoditas,
            'tahun' => $request->tahun,
            'pesan' => $request->pesan,
            'created_by' => Auth::id(),
        ]);

        return redirect()->route('nasional.harga.index')->with('success', 'Pesan berhasil dikirim.');
    }

    public function export(Request $request)
    {
        $query = HargaPangan::with(['region', 'creator']);

        if ($wilayah = $request->input('wilayah')) {
            $query->where('id_lokasi', $wilayah);
        }

        if ($komoditas = $request->input('komoditas')) {
            $query->where('komoditas', 'LIKE', "%{$komoditas}%");
        }

        $data = $query->get();

        return Excel::download(new NasionalHargaPanganExport($data), 'harga_pangan_' . date('Ymd') . '.xlsx');
    }
}
