<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsAdmin
{
    public function handle(Request $request, Closure $next)
    {
        // Pastikan user sudah login dan memiliki role 'admin'
        if (Auth::check() && Auth::user()->role === 'admin') {
            return $next($request);
        }

        // Redirect user biasa kembali ke dashboard mereka dengan pesan error
        return redirect()->route('dashboard.home')->with('join_error', 'Akses ditolak. Anda tidak memiliki izin untuk membuka halaman Admin.');
    }
}
