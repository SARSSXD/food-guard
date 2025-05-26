<?php

namespace App\Http\Controllers;

use App\Models\ProduksiPangan;
use App\Models\Lokasi;

class HomeController extends Controller
{
    public function index()
    {
        $produksiPangan = ProduksiPangan::with('lokasi')->get();
        $lokasi = Lokasi::all();
        return view('welcome', compact('produksiPangan', 'lokasi'));
    }
}
