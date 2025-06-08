<?php

namespace App\Http\Controllers;

use App\Models\ProduksiPangan;
use App\Models\Wilayah;

class HomeController extends Controller
{
    public function index()
    {
        $produksiPangan = ProduksiPangan::with('wilayah')->get();
        $wilayah = Wilayah::all();
        return view('welcome', compact('produksiPangan', 'wilayah'));
    }
}
