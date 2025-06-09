<?php

namespace App\Http\Controllers\Daerah;

use App\Http\Controllers\Controller;
use App\Models\PrediksiPangan;
use App\Models\Wilayah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PrediksiPanganController extends Controller
{
    public function index(Request $request)
    {
        $query = PrediksiPangan::where('id_lokasi', Auth::user()->id_region)->with('region');

        if ($search = $request->query('search')) {
            $query->where('komoditas', 'LIKE', "%{$search}%")
            ->orwhere('jenis', 'LIKE', "%{$search}%")
            ->orWhere('metode', 'LIKE', "%{$search}%");
        }

        $prediksi = $query->get();
        $wilayah = Wilayah::find(Auth::user()->id_region);

        return view('daerah.prediksi.index', compact('prediksi', 'wilayah'));
    }

    public function update(Request $request, $id)
    {
        $prediksiPangan = PrediksiPangan::findOrFail($id);
        if ($prediksiPangan->id_lokasi != Auth::user()->id_region) {
            return redirect()->route('daerah.prediksi.index')->withErrors(['error' => 'Anda tidak memiliki akses untuk mengedit data ini.']);
        }

        $request->validate([
            'status' => 'required|in:draft,disetujui,revisi',
            'komentar' => 'nullable|string|max:1000',
        ]);

        $prediksiPangan->update([
            'status' => $request->status,
            'komentar' => $request->komentar,
        ]);

        return redirect()->route('daerah.prediksi.index')->with('success', 'Data prediksi pangan berhasil diperbarui.');
    }
}
