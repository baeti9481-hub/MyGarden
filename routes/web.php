<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\BerandaController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\RajaOngkirController;
use App\Http\Controllers\RajaOngkirControllerV2;

/*
|--------------------------------------------------------------------------
| 1. RUTE PUBLIK
|--------------------------------------------------------------------------
*/
Route::get('/', function () { return redirect()->route('beranda'); });
Route::get('/beranda', [BerandaController::class, 'index'])->name('beranda');
Route::get('/Produk/{kategori?}', [ProdukController::class, 'produkFrontend'])->name('produk.frontend');
Route::get('/produk/detail/{id}', [ProdukController::class, 'detailFrontend'])->name('produk.detail');
Route::get('/tentangkami', function () { return view('v_tentangkami.tentangkami'); });
Route::get('/lokasi', function () { return view('v_lokasi.lokasi'); })->name('lokasi');

/*
|--------------------------------------------------------------------------
| 2. AUTHENTICATION (Login, Logout, & Google)
|--------------------------------------------------------------------------
*/
Route::get('backend/login', [LoginController::class, 'loginBackend'])->middleware('guest')->name('login');
Route::post('backend/login', [LoginController::class, 'authenticate'])->middleware('guest')->name('backend.login.post');
Route::post('/logout', [CustomerController::class, 'logout'])->name('logout');

Route::get('/auth/redirect', [CustomerController::class, 'redirect'])->name('auth.redirect');
Route::get('/auth/google/callback', [CustomerController::class, 'callback'])->name('auth.callback');

/*
|--------------------------------------------------------------------------
| 3. AREA BACKEND (ADMIN)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'admin'])->prefix('backend')->name('backend.')->group(function () {
    Route::get('/beranda', [BerandaController::class, 'berandaBackend'])->name('beranda');
    
    Route::resource('user', UserController::class);
    Route::resource('kategori', KategoriController::class);
    Route::resource('produk', ProdukController::class);
    Route::get('/customer', [CustomerController::class, 'index'])->name('customer.index');

    Route::post('/foto-produk/store', [ProdukController::class, 'storeFoto'])->name('foto_produk.store');
    Route::delete('/foto-produk/{id}', [ProdukController::class, 'destroyFoto'])->name('foto_produk.destroy');

    Route::get('/pesanan-proses', [OrderController::class, 'statusProses'])->name('pesanan.proses');
    Route::get('/pesanan-selesai', [OrderController::class, 'statusSelesai'])->name('pesanan.selesai');
    Route::get('/pesanan/detail/{id}', [OrderController::class, 'statusDetail'])->name('pesanan.detail');
    Route::put('/pesanan/update/{id}', [OrderController::class, 'statusUpdate'])->name('pesanan.update');
    Route::get('/pesanan/invoice/{id}', [OrderController::class, 'invoiceBackend'])->name('pesanan.invoice');

    Route::get('/laporan/formuser', [UserController::class, 'formUser'])->name('laporan.formuser');
    Route::post('/laporan/cetakuser', [UserController::class, 'cetakUser'])->name('laporan.cetakuser');
    Route::get('/laporan/formproduk', [ProdukController::class, 'formProduk'])->name('laporan.formproduk');
    Route::post('/laporan/cetakproduk', [ProdukController::class, 'cetakproduk'])->name('laporan.cetakproduk');
    Route::get('/laporan/formpesanan',
    [OrderController::class, 'formpesanan'])
    ->name('laporan.formpesanan');

Route::post('/laporan/cetakpesanan',
    [OrderController::class, 'cetakPesanan'])
    ->name('laporan.cetakpesanan');
});

/*
|--------------------------------------------------------------------------
| 4. AREA CUSTOMER (Wajib Login)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    // Profil
    Route::get('/customer/akun', [CustomerController::class, 'akun'])->name('customer.akun');
    Route::post('/customer/update-profil', [CustomerController::class, 'updateProfil'])->name('customer.updateProfil');

    // Keranjang
    Route::get('cart', [OrderController::class, 'viewCart'])->name('order.cart');
    Route::post('add-to-cart/{id}', [OrderController::class, 'addToCart'])->name('order.addToCart');
    Route::post('cart/update/{id}', [OrderController::class, 'updateCart'])->name('order.updateCart');
    Route::post('remove/{id}', [OrderController::class, 'removeFromCart'])->name('order.remove');

   // 1. Pastikan memanggil select_shipping (sesuai fungsi di controller)
Route::get('select-shipping', [OrderController::class, 'select_shipping'])->name('order.select_shipping');

// 2. Pastikan rute update-ongkir sudah benar
Route::post('/update-ongkir', [OrderController::class, 'updateongkir'])->name('order.updateongkir');

// 3. Payment
Route::get('/order/payment', [OrderController::class, 'select_payment'])->name('order.select_payment');
Route::get('/order/complete', [OrderController::class, 'complete'])->name('order.complete');

    
    // Riwayat, Detail, & Invoice
    Route::get('/order/history', [OrderController::class, 'orderHistory'])->name('order.history');
    Route::get('/order/detail/{id}', [OrderController::class, 'orderDetail'])->name('order.detail');
    Route::get('/order/invoice/{id}', [OrderController::class, 'invoice'])->name('order.invoice');
});
Route::post('/midtrans/callback', [OrderController::class, 'midtransCallback']);

/*
|--------------------------------------------------------------------------
| 5. RAJA ONGKIR API
|--------------------------------------------------------------------------

Route::get('/provinces', [RajaOngkirController::class, 'getProvinces']); 
Route::get('/cities', [RajaOngkirController::class, 'getCities']); 
Route::post('/cost', [RajaOngkirController::class, 'getCost']); 
Route::get('/districts', [RajaOngkirController::class, 'getDistricts']);
Route::get('/cek-ongkir', function () { return view('ongkir'); });

/*
|--------------------------------------------------------------------------
| 5. RAJA ONGKIR API V2
|--------------------------------------------------------------------------
*/
Route::get('/cek-ongkir', function () { return view('cek-ongkir'); });
Route::get('/ongkir/get-destination', [RajaOngkirControllerV2::class, 'getDestination']);
Route::post('/ongkir/calculate', [RajaOngkirControllerV2::class, 'calculateOngkir']);