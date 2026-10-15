<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, ...$guards)
{
    if (Auth::check()) {
        // Cek role user yang login
        if (Auth::user()->role == 'admin') {
            return redirect()->route('backend.beranda'); 
        } else {
            return redirect('/beranda'); // Arahkan ke frontend untuk customer
        }
    }

    return $next($request);
}
}