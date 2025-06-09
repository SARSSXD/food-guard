<?php

namespace App\Http\Controllers\Nasional;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NasionalHargaPanganController extends Controller
{
    public function index(Request $request)
    {
        return view('nasional.dashboard');
    }
}
