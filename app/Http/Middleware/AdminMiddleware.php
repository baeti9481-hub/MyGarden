<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Cek apakah user sudah login
        if (!Auth::check()) {
            return redirect()->route('login')
                ->with('error', 'Silakan login terlebih dahulu.');
        }

        // Cek apakah user adalah admin (role == 1)
        if (Auth::user()->role != 1) {
            return redirect()->route('beranda')
                ->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }

        // Cek apakah status user aktif
        if (Auth::user()->status == 0) {
            Auth::logout();
            return redirect()->route('login')
                ->with('error', 'Akun Anda tidak aktif.');
        }

        return $next($request);
    }
}