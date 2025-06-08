<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Lokasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Menampilkan form login
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Menampilkan form register
    public function showRegisterForm()
    {
        $lokasi = Lokasi::all();
        return view('auth.register', compact('lokasi'));
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

    // Proses register
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'required|in:nasional,daerah,user',
            'Id_region' => 'required_if:role,daerah|nullable|exists:lokasi,Id_lokasi',
        ]);

        // Validasi domain email berdasarkan role
        if ($request->role === 'nasional' && !str_ends_with($request->email, '@foodguard.com')) {
            return back()->withErrors(['email' => 'Email untuk admin nasional harus menggunakan domain @foodguard.com.']);
        }
        if ($request->role === 'daerah' && !str_ends_with($request->email, '@region.foodguard.com')) {
            return back()->withErrors(['email' => 'Email untuk admin daerah harus menggunakan domain @region.foodguard.com.']);
        }
        if ($request->role === 'user' && !str_ends_with($request->email, '@public.foodguard.com')) {
            return back()->withErrors(['email' => 'Email untuk pengguna umum harus menggunakan domain @public.foodguard.com.']);
        }

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => $request->role,
            'Id_region' => $request->role === 'daerah' ? $request->Id_region : null,
            'created_at' => now(),
        ]);

        return redirect()->route('login')->with('success', 'Registrasi berhasil. Silakan login.');
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
