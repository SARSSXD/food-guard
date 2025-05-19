<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Menampilkan form login
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Proses login
    public function login(Request $request)
    {
        // Validasi input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        // Ambil kredensial
        $credentials = $request->only('email', 'password');

        // Coba autentikasi
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Ambil role pengguna setelah autentikasi berhasil
            $role = Auth::user()->role;

            // Validasi domain email berdasarkan role
            if (str_ends_with($request->email, '@foodguard.com') && $role !== 'nasional') {
                Auth::logout();
                return back()->withErrors(['email' => 'Email ini hanya untuk admin nasional.']);
            }

            if (str_ends_with($request->email, '@region.foodguard.com') && $role !== 'daerah') {
                Auth::logout();
                return back()->withErrors(['email' => 'Email ini hanya untuk admin daerah.']);
            }

            if (str_ends_with($request->email, '@public.foodguard.com') && $role !== 'user') {
                Auth::logout();
                return back()->withErrors(['email' => 'Email ini hanya untuk pengguna umum.']);
            }

            // Redirect berdasarkan role
            switch ($role) {
                case 'nasional':
                    return redirect()->intended('/nasional/dashboard');
                case 'daerah':
                    return redirect()->intended('/daerah/dashboard');
                case 'user':
                    return redirect()->intended('/user/dashboard');
                default:
                    Auth::logout();
                    return back()->withErrors(['email' => 'Role tidak valid.']);
            }
        }

        // Jika autentikasi gagal
        return back()->withErrors(['email' => 'Email atau password salah.']);
    }

    // Proses logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}
