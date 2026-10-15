<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>MyGarden - Konfirmasi Pembayaran</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="{{ asset('frontend/img/favicon.ico') }}" rel="icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500&family=Lora:wght@600;700&display=swap" rel="stylesheet"> 

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="{{ asset('frontend/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/css/style.css') }}" rel="stylesheet">

    <style>
        body { background-color: #ffffff; font-family: 'Open Sans', sans-serif; padding-top: 140px; }
        @media (max-width: 992px) { body { padding-top: 100px; } }
        
        .navbar {
            background: #ffffff !important;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.06) !important;
            border-bottom: 1px solid #f0f0f0;
        }

        .card-payment {
            background: #ffffff;
            border-radius: 15px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.05);
            border: 1px solid #f0f0f0;
        }

        .text-primary { color: #3CB815 !important; }
        .text-secondary { color: #FF5E00 !important; }
    </style>
</head>


    <div class="container-fluid fixed-top px-0 wow fadeIn" data-wow-delay="0.1s">
        

        <nav class="navbar navbar-expand-lg navbar-light py-lg-0 px-lg-5 bg-white">
            <a href="{{ route('beranda') }}" class="navbar-brand ms-4 ms-lg-0">
                <h1 class="fw-bold text-primary m-0"><span class="text-secondary">My</span>Garden</h1>
            </a>
            <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <div class="navbar-nav ms-auto p-4 p-lg-0">
                    <a href="{{ route('beranda') }}" class="nav-item nav-link">Beranda</a>
                    <a href="{{ route('produk.frontend') }}" class="nav-item nav-link">Produk</a>
                    <a href="/tentangkami" class="nav-item nav-link">Tentang Kami</a>
                    <a href="/lokasi" class="nav-item nav-link">Lokasi</a>
                </div>
                <div class="d-flex align-items-center me-4 me-lg-0">
                    @if(Auth::check())
                        <div class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle fw-bold text-primary" data-bs-toggle="dropdown">
                                <i class="fa fa-user me-1"></i> {{ Auth::user()->nama }}
                            </a>
                            <div class="dropdown-menu dropdown-menu-end m-0 shadow-sm border-0">
                                <a href="{{ route('customer.akun') }}" class="dropdown-item">Akun Saya</a>
                                <a href="{{ route('order.history') }}" class="dropdown-item">Riwayat Pesanan</a>
                                <hr class="dropdown-divider">
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger border-0 bg-transparent w-100 text-start">Logout</button>
                                </form>
                            </div>
                        </div>
                    @endif
                    <a class="btn-sm-square bg-white rounded-circle ms-3 position-relative shadow-sm border" href="{{ route('order.cart') }}">
                        <small class="fa fa-shopping-bag text-body"></small>
                        @php
                            $cartCount = \App\Models\Order::where('customer_id', Auth::user()->customer->id)->where('status', 'pending')->first();
                        @endphp
                        @if($cartCount && $cartCount->orderItems->count() > 0)
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.6rem;">
                                {{ $cartCount->orderItems->count() }}
                            </span>
                        @endif
                    </a>
                </div>
            </div>
        </nav>
    </div>

    <div class="container pb-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card card-payment p-4 p-lg-5">
                <div class="text-center mb-5">
                    <h4 class="fw-bold text-dark">Konfirmasi Pesanan & Pembayaran</h4>
                    <p class="text-muted">Periksa kembali pesanan Anda sebelum melakukan pembayaran</p>
                </div>

                <div class="row g-4">
                    <div class="col-lg-7 text-start">
                        <div class="table-responsive">
                            <table class="table align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>PRODUK</th>
                                        <th class="text-center">QTY</th>
                                        <th class="text-end">TOTAL</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($order->orderItems as $item)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="{{ asset('storage/img-produk/' . $item->produk->foto) }}" width="50" height="50" class="rounded me-3" style="object-fit: cover;">
                                                <div>
                                                    <p class="mb-0 fw-bold small text-dark">{{ $item->produk->nama_produk }}</p>
                                                    <small class="text-muted">{{ $item->produk->berat }} gr</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center">{{ $item->quantity }}</td>
                                        <td class="text-end fw-bold">Rp {{ number_format($item->harga * $item->quantity, 0, ',', '.') }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    {{-- Hitung subtotal dari akumulasi harga item --}}
                    @php
                        $subtotal = $order->orderItems->sum(function($item) {
                            return $item->harga * $item->quantity;
                        });
                        $grandTotal = $subtotal + $order->biaya_ongkir;
                    @endphp

                        <div class="col-lg-5">
        <div class="p-4 border rounded bg-light">
            <h5 class="fw-bold mb-4">Ringkasan Biaya</h5>

            <div class="d-flex justify-content-between mb-2">
                <span class="text-muted">Subtotal</span>
                <span class="fw-bold">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
            </div>

            <div class="d-flex justify-content-between mb-2">
                <span class="text-muted">Ongkir ({{ strtoupper($order->kurir) }})</span>
                <span class="fw-bold">Rp {{ number_format($order->biaya_ongkir, 0, ',', '.') }}</span>
            </div>

            <hr>

            <div class="d-flex justify-content-between mb-4">
                <span class="h5 fw-bold">Total Bayar</span>
                <span class="h5 fw-bold text-danger">Rp {{ number_format($grandTotal, 0, ',', '.') }}</span>
            </div>

                            <button id="pay-button" class="btn btn-primary w-100 py-3 fw-bold rounded-pill shadow-sm mb-3">
                                <i class="fa fa-credit-card me-2"></i> BAYAR SEKARANG
                            </button>

                            {{-- TOMBOL UBAH PENGIRIMAN --}}
                            <div class="text-center">
                                <a href="{{ route('order.select_shipping') }}" class="btn btn-link btn-sm text-decoration-none text-muted">
                                    <i class="fa fa-truck me-1"></i> Ubah Metode Pengiriman
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

     <div class="container-fluid bg-dark footer mt-5 pt-5 wow fadeIn" data-wow-delay="0.1s">
        <div class="container py-5">
            <div class="row g-5">
                <div class="col-lg-3 col-md-6">
                    <h1 class="fw-bold text-primary mb-4"><span class="text-secondary">My</span>Garden</h1>
                    <p>Pusat produk tani organik terpercaya. Menyediakan buah dan sayuran segar, serta menyediakan bibit unggul bagi anda yang ingin mulai berkebun.</p>
                    <div class="d-flex pt-2">
                        <a class="btn btn-square btn-outline-light rounded-circle me-1" href=""><i
                                class="fab fa-twitter"></i></a>
                        <a class="btn btn-square btn-outline-light rounded-circle me-1" href=""><i
                                class="fab fa-facebook-f"></i></a>
                        <a class="btn btn-square btn-outline-light rounded-circle me-1" href=""><i
                                class="fab fa-youtube"></i></a>
                        <a class="btn btn-square btn-outline-light rounded-circle me-0" href=""><i
                                class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h4 class="text-light mb-4">Alamat</h4>
                    <p><i class="fa fa-map-marker-alt me-3"></i>Tegal-Jawa Tengah</p>
                    <p><i class="fa fa-phone-alt me-3"></i>+012 345 67890</p>
                    <p><i class="fa fa-envelope me-3"></i>MyGarden@gmail.com</p>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h4 class="text-light mb-4">Tautan Cepat</h4>
                    <a class="btn btn-link" href="">Tentang Kami</a>
                    <a class="btn btn-link" href="">Hubungi Kami</a>
                    <a class="btn btn-link" href="">Layanan Kami</a>
                    <a class="btn btn-link" href="">Syarat & Ketentuan</a>
                    <a class="btn btn-link" href="">Dukungan</a>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h4 class="text-light mb-4">Berlangganan</h4>
                    <p>Dapatkan informasi terbaru dan penawaran menarik langsung di email Anda.</p>
                    <div class="position-relative mx-auto" style="max-width: 400px;">
                        <input class="form-control bg-transparent w-100 py-3 ps-4 pe-5" type="text"
                            placeholder="Email Anda">
                        <button type="button"
                            class="btn btn-primary py-2 position-absolute top-0 end-0 mt-2 me-2">Daftar</button>
                            
                    </div>
                </div>
            </div>
        </div>
     
    <a href="#" class="btn btn-lg btn-primary btn-lg-square rounded-circle back-to-top"><i
            class="bi bi-arrow-up"></i></a>


    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="frontend/lib/wow/wow.min.js"></script>
    <script src="frontend/lib/easing/easing.min.js"></script>
    <script src="frontend/lib/waypoints/waypoints.min.js"></script>
    <script src="frontend/lib/owlcarousel/owl.carousel.min.js"></script>

    <script src="{{ asset('frontend/js/main.js') }}"></script>

    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
    
    <script type="text/javascript">
        document.getElementById('pay-button').onclick = function(e){
            e.preventDefault();
            snap.pay('{{ $snapToken }}', {
                onSuccess: function(result){ window.location.href = "{{ route('order.complete') }}"; },
                onPending: function(result){ window.location.href = "{{ route('order.history') }}"; },
                onError: function(result){ window.location.href = "{{ route('order.history') }}"; },
                onClose: function(){ alert('Anda menutup jendela pembayaran.'); }
            });
        };
    </script>
</body>
</html>