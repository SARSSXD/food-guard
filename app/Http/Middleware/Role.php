<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Role
{
    public function handle(Request $request, Closure $next, string $role)
    {
        if (!Auth::check() || Auth::user()->role !== $role) {
            abort(403, 'Akses dilarang. Anda tidak memiliki izin untuk mengakses halaman ini.');
        }
        return $next($request);
    }
}
