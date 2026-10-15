<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        if (! $request->expectsJson()) {
            // 1. Jika yang akses adalah Admin/User Backend
            if ($request->is('backend/*') || $request->is('backend')) {
                return route('login'); 
            }

            // 2. Jika yang akses adalah Customer (seperti klik Keranjang)
            // Ganti 'beranda' menjadi 'auth.redirect' agar langsung ke Google
            return route('auth.redirect');
        }

        return null;
    }
}