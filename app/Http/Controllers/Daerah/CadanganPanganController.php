<?php

namespace App\Http\Controllers\Daerah;

use App\Http\Controllers\Controller;
use App\Models\CadanganPangan;
use App\Models\Wilayah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CadanganPanganController extends Controller
{
    public function index(Request $request)
    {
        $query = CadanganPangan::where('id_lokasi', Auth::user()->id_region)->with('region');

        if ($search = $request->query('search')) {
            $query->where('komoditas', 'LIKE', "%{$search}%");
        }

        $cadangan = $query->get();
        $wilayah = Wilayah::find(Auth::user()->id_region);

        return view('daerah.cadangan.index', compact('cadangan', 'wilayah'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'komoditas' => 'required|string|max:255',
            'jumlah' => 'required|numeric|min:0',
            'id_lokasi' => 'required|exists:wilayah,id',
        ]);

        if ($request->id_lokasi != Auth::user()->id_region) {
            return back()->withErrors(['id_lokasi' => 'Anda hanya dapat menambahkan data untuk wilayah Anda.']);
        }

        CadanganPangan::create([
            'komoditas' => $request->komoditas,
            'jumlah' => $request->jumlah,
            'id_lokasi' => $request->id_lokasi,
            'status_valid' => 'pending',
        ]);

        return redirect()->route('daerah.cadangan.index')->with('success', 'Data cadangan pangan berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $cadanganPangan = CadanganPangan::findOrFail($id);
        if ($cadanganPangan->id_lokasi != Auth::user()->id_region) {
            return redirect()->route('daerah.cadangan.index')->withErrors(['error' => 'Anda tidak memiliki akses untuk mengedit data ini.']);
        }

        $request->validate([
            'komoditas' => 'required|string|max:255',
            'jumlah' => 'required|numeric|min:0',
            'id_lokasi' => 'required|exists:wilayah,id',
        ]);

        if ($request->id_lokasi != Auth::user()->id_region) {
            return back()->withErrors(['id_lokasi' => 'Anda hanya dapat mengedit data untuk wilayah Anda.']);
        }

        $cadanganPangan->update([
            'komoditas' => $request->komoditas,
            'jumlah' => $request->jumlah,
            'id_lokasi' => $request->id_lokasi,
            'status_valid' => 'pending',
        ]);

        return redirect()->route('daerah.cadangan.index')->with('success', 'Data cadangan pangan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $cadanganPangan = CadanganPangan::findOrFail($id);

        if ($cadanganPangan->id_lokasi != Auth::user()->id_region) {
            return redirect()->route('daerah.cadangan.index')->withErrors(['error' => 'Anda tidak memiliki akses untuk menghapus data ini.']);
        }

        $cadanganPangan->delete();

        return redirect()->route('daerah.cadangan.index')->with('success', 'Data cadangan pangan berhasil dihapus.');
    }
}
