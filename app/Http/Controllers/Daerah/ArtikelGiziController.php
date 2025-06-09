<?php

namespace App\Http\Controllers\Daerah;

use App\Http\Controllers\Controller;
use App\Models\ArtikelGizi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ArtikelGiziController extends Controller
{
    public function index(Request $request)
    {
        $artikel = ArtikelGizi::all();
        if ($search = $request->query('search')) {
            $artikel = ArtikelGizi::where(function ($q) use ($search) {
                $q->where('judul', 'LIKE', "%{$search}%")
                    ->orWhere('kategori', 'LIKE', "%{$search}%");
            })->get();
        }

        return view('daerah.artikel.index', compact('artikel'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
            'kategori' => 'required|in:anak,ibu_hamil,lansia,lainnya',
        ]);

        ArtikelGizi::create([
            'judul' => $request->judul,
            'isi' => $request->isi,
            'kategori' => $request->kategori,
            'id_penulis' => Auth::user()->id,
            'jumlah_akses' => 0,
        ]);

        return redirect()->route('daerah.artikel.index')->with('success', 'Artikel gizi berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $artikelGizi = ArtikelGizi::findOrFail($id);
        if ($artikelGizi->id_penulis != Auth::user()->id) {
            return redirect()->route('daerah.artikel.index')->withErrors(['error' => 'Anda tidak memiliki akses untuk mengedit artikel ini.']);
        }

        $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
            'kategori' => 'required|in:anak,ibu_hamil,lansia,lainnya',
        ]);

        $artikelGizi->update([
            'judul' => $request->judul,
            'isi' => $request->isi,
            'kategori' => $request->kategori,
        ]);

        return redirect()->route('daerah.artikel.index')->with('success', 'Artikel gizi berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $artikelGizi = ArtikelGizi::findOrFail($id);

        if ($artikelGizi->id_penulis != Auth::user()->id) {
            return redirect()->route('daerah.artikel.index')->withErrors(['error' => 'Anda tidak memiliki akses untuk menghapus artikel ini.']);
        }

        $artikelGizi->delete();

        return redirect()->route('daerah.artikel.index')->with('success', 'Artikel gizi berhasil dihapus.');
    }
}
