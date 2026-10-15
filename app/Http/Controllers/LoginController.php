<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Menampilkan Form Login
     */
    public function loginBackend()
    {
        if (Auth::check()) {
            return Auth::user()->role == 1 
                ? redirect()->route('backend.beranda') 
                : redirect()->route('beranda');
        }

        return view('backend.v_login.login', [
            'judul' => 'Login TaniFresh',
        ]);
    }

    /**
     * Proses Autentikasi (Login)
     */
    public function authenticate(Request $request)
{
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required'
    ]);

    if (Auth::attempt($credentials)) {
        
        if (Auth::user()->status == 0) {
            Auth::logout();
            return back()->with('error', 'Akun Anda belum aktif. Silakan hubungi admin.');
        }

        $request->session()->regenerate();

        // ✅ Gunakan redirect biasa, bukan intended()
       if ((int) Auth::user()->role === 1) {
            return redirect()->route('backend.beranda');
        } else {
            return redirect()->route('beranda');
        }
    }
    

    return back()->with('error', 'Login Gagal! Email atau Password salah.');
}

    /**
     * Proses Logout
     */
    public function logoutBackend()
{
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    
    // UBAH BAGIAN INI:
    // Dari route('beranda') menjadi route('backend.login')
    return redirect()->route('backend.login')->with('success', 'Anda telah berhasil keluar.');
}
}