<?php

namespace App\Http\Controllers\Daerah;

use App\Http\Controllers\Controller;
use App\Models\HargaPangan;
use App\Models\Wilayah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HargaPanganController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $query = HargaPangan::where('id_lokasi', $user->id_region)->with('region');

        if ($search = $request->query('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('komoditas', 'LIKE', "%{$search}%")
                    ->orWhere('nama_pasar', 'LIKE', "%{$search}%");
            });
        }

        $harga = $query->get();
        $wilayah = Wilayah::find(Auth::user()->id_region);

        return view('daerah.harga.index', compact('harga', 'wilayah'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_pasar' => 'required|string|max:255',
            'komoditas' => 'required|string|max:255',
            'harga_per_kg' => 'required|numeric|min:0',
            'tanggal' => 'required|date',
            'id_lokasi' => 'required|exists:wilayah,id',
        ]);

        if ($request->id_lokasi != Auth::user()->id_region) {
            return back()->withErrors(['id_lokasi' => 'Anda hanya dapat menambahkan data untuk wilayah Anda.']);
        }

        HargaPangan::create([
            'nama_pasar' => $request->nama_pasar,
            'komoditas' => $request->komoditas,
            'harga_per_kg' => $request->harga_per_kg,
            'tanggal' => $request->tanggal,
            'id_lokasi' => $request->id_lokasi,
            'created_by' => Auth::user()->id,
        ]);

        return redirect()->route('daerah.harga.index')->with('success', 'Data harga pangan berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $hargaPangan = HargaPangan::findOrFail($id);
        if ($hargaPangan->id_lokasi != Auth::user()->id_region) {
            return redirect()->route('daerah.harga.index')->withErrors(['error' => 'Anda tidak memiliki akses untuk mengedit data ini.']);
        }

        $request->validate([
            'nama_pasar' => 'required|string|max:255',
            'komoditas' => 'required|string|max:255',
            'harga_per_kg' => 'required|numeric|min:0',
            'tanggal' => 'required|date',
            'id_lokasi' => 'required|exists:wilayah,id',
        ]);

        if ($request->id_lokasi != Auth::user()->id_region) {
            return back()->withErrors(['id_lokasi' => 'Anda hanya dapat mengedit data untuk wilayah Anda.']);
        }

        $hargaPangan->update([
            'nama_pasar' => $request->nama_pasar,
            'komoditas' => $request->komoditas,
            'harga_per_kg' => $request->harga_per_kg,
            'tanggal' => $request->tanggal,
            'id_lokasi' => $request->id_lokasi,
        ]);

        return redirect()->route('daerah.harga.index')->with('success', 'Data harga pangan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $hargaPangan = HargaPangan::findOrFail($id);

        if ($hargaPangan->id_lokasi != Auth::user()->id_region) {
            return redirect()->route('daerah.harga.index')->withErrors(['error' => 'Anda tidak memiliki akses untuk menghapus data ini.']);
        }

        $hargaPangan->delete();

        return redirect()->route('daerah.harga.index')->with('success', 'Data harga pangan berhasil dihapus.');
    }
}
