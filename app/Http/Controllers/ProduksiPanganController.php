<?php

namespace App\Http\Controllers;

use App\Models\ProduksiPangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProduksiPanganController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'komoditas' => 'required|string',
            'volume' => 'required|numeric',
            'Id_lokasi' => 'required|exists:lokasi,Id_lokasi',
            'waktu' => 'required|date',
        ]);

        ProduksiPangan::create([
            'komoditas' => $request->komoditas,
            'volume' => $request->volume,
            'Id_lokasi' => $request->Id_lokasi,
            'waktu' => $request->waktu,
            'status_valid' => 'pending',
            'created_by' => Auth::id(),
        ]);

        return redirect()->route('daerah.dashboard')->with('success', 'Data produksi pangan berhasil disimpan.');
    }

    public function validasi($id)
    {
        $data = ProduksiPangan::findOrFail($id);
        if ($data->status_valid == 'pending') {
            $data->update(['status_valid' => 'terverifikasi']);
            return redirect()->route('nasional.dashboard')->with('success', 'Data berhasil divalidasi.');
        }
        return redirect()->route('nasional.dashboard')->with('error', 'Data sudah terverifikasi.');
    }
}
