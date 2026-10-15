<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;

class BerandaController extends Controller
{
    public function berandaBackend()
    {
        return view('backend.v_beranda.index', [
            'judul' => 'Beranda',
            'sub' => 'Halaman Beranda',
        ]);
    }

    public function index()
{
    // Mengambil hanya 4 produk terbaru yang statusnya aktif
    $produk = Produk::where('status', 1)
                    ->latest()
                    ->take(4) // Ganti angka 4 sesuai jumlah yang kamu mau muncul di beranda
                    ->get();

    return view('v_beranda.index', compact('produk'));
}
}
