<?php

namespace App\Http\Controllers\Daerah;

use App\Http\Controllers\Controller;
use App\Models\ProduksiPangan;
use App\Models\Wilayah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProduksiPanganController extends Controller
{
    public function index(Request $request)
    {
        $query = ProduksiPangan::where('id_lokasi', Auth::user()->id_region)->with('region');

        if ($search = $request->query('search')) {
            $query->where('komoditas', 'LIKE', "%{$search}%");
        }

        $produksi = $query->get();
        $wilayah = Wilayah::find(Auth::user()->id_region);

        return view('daerah.produksi.index', compact('produksi', 'wilayah'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'komoditas' => 'required|string|max:255',
            'jumlah' => 'required|numeric|min:0',
            'periode' => 'required|digits:4|integer|min:1900|max:' . date('Y'),
            'id_lokasi' => 'required|exists:wilayah,id',
        ]);

        if ($request->id_lokasi != Auth::user()->id_region) {
            return back()->withErrors(['id_lokasi' => 'Anda hanya dapat menambahkan data untuk wilayah Anda.']);
        }

        ProduksiPangan::create([
            'komoditas' => $request->komoditas,
            'jumlah' => $request->jumlah,
            'periode' => $request->periode,
            'id_lokasi' => $request->id_lokasi,
            'status_valid' => 'pending',
            'created_by' => Auth::user()->id,
        ]);

        return redirect()->route('daerah.produksi.index')->with('success', 'Data produksi pangan berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $produksiPangan = ProduksiPangan::findOrFail($id);
        if ($produksiPangan->id_lokasi != Auth::user()->id_region) {
            return redirect()->route('daerah.produksi.index')->withErrors(['error' => 'Anda tidak memiliki akses untuk mengedit data ini.']);
        }

        $request->validate([
            'komoditas' => 'required|string|max:255',
            'jumlah' => 'required|numeric|min:0',
            'periode' => 'required|digits:4|integer|min:1900|max:' . date('Y'),
            'id_lokasi' => 'required|exists:wilayah,id',
        ]);

        if ($request->id_lokasi != Auth::user()->id_region) {
            return back()->withErrors(['id_lokasi' => 'Anda hanya dapat mengedit data untuk wilayah Anda.']);
        }

        $produksiPangan->update([
            'komoditas' => $request->komoditas,
            'jumlah' => $request->jumlah,
            'periode' => $request->periode,
            'id_lokasi' => $request->id_lokasi,
            'status_valid' => 'pending',
        ]);

        return redirect()->route('daerah.produksi.index')->with('success', 'Data produksi pangan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $produksiPangan = ProduksiPangan::findOrFail($id);

        if ($produksiPangan->id_lokasi != Auth::user()->id_region) {
            return redirect()->route('daerah.produksi.index')->withErrors(['error' => 'Anda tidak memiliki akses untuk menghapus data ini.']);
        }

        $produksiPangan->delete();

        return redirect()->route('daerah.produksi.index')->with('success', 'Data produksi pangan berhasil dihapus.');
    }
}
