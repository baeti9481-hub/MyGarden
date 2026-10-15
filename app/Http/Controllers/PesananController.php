<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pesanan;
use App\Models\Produk; // Pastikan Model Produk ini di-import jika dipakai di bawah

class PesananController extends Controller
{
    // halaman data pesanan
    public function index()
    {
        $judul = 'Data Pesanan';
        $subJudul = 'Daftar Pesanan';

        // KUNCI UTAMA: Tambahkan .user setelah customer
        $index = Pesanan::with('customer.user')->get();

        return view('backend.v_pesanan.index', compact(
            'judul',
            'subJudul',
            'index'
        ));
    }

    // cetak invoice
    public function invoice($id)
    {
        // KUNCI UTAMA: Tambahkan .user di sini juga agar nama pelanggan muncul di nota cetak
        $pesanan = Pesanan::with('customer.user')->findOrFail($id);

        return view('backend.v_pesanan.invoice', compact('pesanan'));
    }

    // pesanan selesai
    public function selesai($id)
    {
        $pesanan = Pesanan::findOrFail($id);

        $pesanan->status = 'Selesai';
        $pesanan->save();

        return redirect()->back()
            ->with('success', 'Pesanan selesai');
    }

    // laporan pesanan
    public function laporan()
    {
        $judul = 'Laporan Pesanan';

        $tanggalAwal = request('tanggal_awal');
        $tanggalAkhir = request('tanggal_akhir');

        // KUNCI UTAMA: Tambahkan .user di sini agar cetak laporan berkala ada nama pelanggannya
        $cetak = Pesanan::with('customer.user')
            ->whereBetween('created_at', [$tanggalAwal, $tanggalAkhir])
            ->get();

        return view('backend.v_laporan.cetak-pesanan', compact(
            'judul',
            'tanggalAwal',
            'tanggalAkhir',
            'cetak'
        ));
    }

    public function formProduk()
    {
        return view('backend.v_produk.form', ['judul' => 'Laporan Data Produk']);
    }
    
    public function cetakProduk(Request $request)
    {
        $request->validate([
            'tanggal_awal' => 'required|date',
            'tanggal_akhir' => 'required|date|after_or_equal:tanggal_awal',
        ]);
        
        $tanggalAwal = $request->input('tanggal_awal');
        $tanggalAkhir = $request->input('tanggal_akhir');
        
        $produk = Produk::whereBetween('updated_at', [$tanggalAwal, $tanggalAkhir])->orderBy('id', 'desc')->get();
        
        return view('backend.v_produk.cetak', [
            'judul' => 'Laporan Produk',
            'tanggalAwal' => $tanggalAwal,
            'tanggalAkhir' => $tanggalAkhir,
            'cetak' => $produk
        ]);
    }
}