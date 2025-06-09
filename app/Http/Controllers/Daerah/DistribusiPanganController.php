<?php

namespace App\Http\Controllers\Daerah;

use App\Http\Controllers\Controller;
use App\Models\DistribusiPangan;
use App\Models\Wilayah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DistribusiPanganController extends Controller
{
    public function index(Request $request)
    {
        $query = DistribusiPangan::where('created_by', Auth::user()->id)->with('region');

        if ($search = $request->query('search')) {
            $query->where('komoditas', 'LIKE', "%{$search}%");
        }

        $distribusi = $query->get();
        $wilayah = Wilayah::all();

        return view('daerah.distribusi.index', compact('distribusi', 'wilayah'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_wilayah_tujuan' => 'required|exists:wilayah,id',
            'komoditas' => 'required|string|max:255',
            'jumlah' => 'required|numeric|min:0',
            'tanggal_kirim' => 'required|date',
            'status' => 'required|in:dikirim,ditunda,terlambat,selesai',
        ]);

        DistribusiPangan::create([
            'id_wilayah_tujuan' => $request->id_wilayah_tujuan,
            'komoditas' => $request->komoditas,
            'jumlah' => $request->jumlah,
            'tanggal_kirim' => $request->tanggal_kirim,
            'status' => $request->status,
            'created_by' => Auth::user()->id,
        ]);

        return redirect()->route('daerah.distribusi.index')->with('success', 'Data distribusi pangan berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $distribusiPangan = DistribusiPangan::findOrFail($id);
        if ($distribusiPangan->created_by != Auth::user()->id) {
            return redirect()->route('daerah.distribusi.index')->withErrors(['error' => 'Anda tidak memiliki akses untuk mengedit data ini.']);
        }

        $request->validate([
            'id_wilayah_tujuan' => 'required|exists:wilayah,id',
            'komoditas' => 'required|string|max:255',
            'jumlah' => 'required|numeric|min:0',
            'tanggal_kirim' => 'required|date',
            'status' => 'required|in:dikirim,ditunda,terlambat,selesai',
        ]);

        $distribusiPangan->update([
            'id_wilayah_tujuan' => $request->id_wilayah_tujuan,
            'komoditas' => $request->komoditas,
            'jumlah' => $request->jumlah,
            'tanggal_kirim' => $request->tanggal_kirim,
            'status' => $request->status,
        ]);

        return redirect()->route('daerah.distribusi.index')->with('success', 'Data distribusi pangan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $distribusiPangan = DistribusiPangan::findOrFail($id);

        if ($distribusiPangan->created_by != Auth::user()->id) {
            return redirect()->route('daerah.distribusi.index')->withErrors(['error' => 'Anda tidak memiliki akses untuk menghapus data ini.']);
        }

        $distribusiPangan->delete();

        return redirect()->route('daerah.distribusi.index')->with('success', 'Data distribusi pangan berhasil dihapus.');
    }
}
