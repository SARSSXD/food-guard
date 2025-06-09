<?php

namespace App\Http\Controllers\Nasional;

use App\Http\Controllers\Controller;
use App\Models\HargaPangan;
use App\Models\PesanHargaPangan;
use App\Models\Wilayah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $request->validate([
            'wilayah' => 'required|string|max:255',
            'komoditas' => 'required|string|max:255',
            'tahun' => 'required|string|max:4',
            'pesan' => 'required|string|max:1000',
        ]);

        PesanHargaPangan::create([
            'wilayah' => $request->wilayah,
            'komoditas' => $request->komoditas,
            'tahun' => $request->tahun,
            'pesan' => $request->pesan,
            'created_by' => Auth::id(),
        ]);

        return redirect()->route('nasional.harga.index')->with('success', 'Pesan berhasil dikirim.');
    }
}
