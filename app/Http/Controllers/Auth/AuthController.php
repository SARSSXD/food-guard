<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Wilayah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function showRegisterForm()
    {
        $wilayah = Wilayah::all();
        return view('auth.register', compact('wilayah'));
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = Auth::user();

            if (!$this->validateEmailDomain($request->email, $user->role)) {
                Auth::logout();
                return back()->withErrors(['email' => $this->getEmailErrorMessage($request->email)]);
            }

            switch ($user->role) {
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

        return back()->withErrors(['email' => 'Email atau password salah.']);
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'required|in:nasional,daerah,user',
            'id_region' => 'required_if:role,daerah|nullable|exists:wilayah,id',
        ]);

        if (!$this->validateEmailDomain($request->email, $request->role)) {
            return back()->withErrors(['email' => $this->getEmailErrorMessage($request->email, $request->role)]);
        }

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'id_region' => $request->role === 'daerah' ? $request->id_region : null,
            'created_at' => now(),
        ]);

        return redirect()->route('login')->with('success', 'Registrasi berhasil. Silakan login.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }

    private function validateEmailDomain($email, $role)
    {
        return match ($role) {
            'nasional' => str_ends_with($email, '@foodguard.com'),
            'daerah' => str_ends_with($email, '@region.foodguard.com'),
            'user' => str_ends_with($email, '@public.foodguard.com'),
            default => false,
        };
    }

    private function getEmailErrorMessage($email, $role = null)
    {
        if ($role) {
            return match ($role) {
                'nasional' => 'Email untuk admin nasional harus menggunakan domain @foodguard.com.',
                'daerah' => 'Email untuk admin daerah harus menggunakan domain @region.foodguard.com.',
                'user' => 'Email untuk pengguna umum harus menggunakan domain @public.foodguard.com.',
                default => 'Domain email tidak valid untuk role yang dipilih.',
            };
        }

        if (str_ends_with($email, '@foodguard.com')) {
            return 'Email ini hanya untuk admin nasional.';
        }
        if (str_ends_with($email, '@region.foodguard.com')) {
            return 'Email ini hanya untuk admin daerah.';
        }
        if (str_ends_with($email, '@public.foodguard.com')) {
            return 'Email ini hanya untuk pengguna umum.';
        }

        return 'Domain email tidak valid.';
    }
}
