<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>MyGarden - Keranjang Belanja</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <base href="{{ url('/') }}/">
    <link href="{{ asset('frontend/img/favicon.ico') }}" rel="icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500&family=Lora:wght@600;700&display=swap" rel="stylesheet">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="{{ asset('frontend/lib/animate/animate.min.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/css/style.css') }}" rel="stylesheet">

    <style>
        /* REVISI: Background Putih Murni */
        body {
            background-color: #ffffff;
            font-family: 'Open Sans', sans-serif;
        }

        /* REVISI: Navbar dengan bayangan halus sesuai halaman detail */
        .navbar {
            background: #ffffff !important;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.06) !important;
            border-bottom: 1px solid #f0f0f0;
        }

        .main-content-wrapper { 
            min-height: 75vh; 
            margin-top: 150px; /* Jarak agar tidak tertutup navbar */
        }

        /* Detail Wrapper Utama agar bayangannya tipis (tidak kaku) */
        .order-summary {
            background: #ffffff;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.05);
            padding: 40px;
            margin-bottom: 50px;
            border: 1px solid #f0f0f0;
        }

        .shopping-cart-table thead th {
    background-color: #3CB815;
    text-transform: uppercase;
    font-size: 12px;
    letter-spacing: 1px;
    color: #ffffff;
    border-bottom: 2px solid #dee2e6;
    padding: 10px 15px; /* Sekalian disamakan agar tidak terlalu tinggi */
}

/* REVISI: Membuat sudut kiri atas header hijau menjadi melengkung */
.shopping-cart-table thead tr th:first-child {
    border-top-left-radius: 15px; /* Sesuaikan nilainya (misal 15px atau 20px) dengan card putihmu */
}

/* REVISI: Membuat sudut kanan atas header hijau menjadi melengkung */
.shopping-cart-table thead tr th:last-child {
    border-top-right-radius: 15px;
}
        

        .cart-qty-input {
            max-width: 60px;
        }
    </style>
</head>

<body>
    <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-border text-primary" role="status"></div>
    </div>

    <div class="container-fluid fixed-top px-0 wow fadeIn" data-wow-delay="0.1s">
        <div class="top-bar row gx-0 align-items-center d-none d-lg-flex border-bottom bg-light py-2">
            <div class="col-lg-6 px-5 text-start">
                <small class="text-muted"><i class="fa fa-map-marker-alt me-2 text-primary"></i>Tegal - Jawa Tengah</small>
                <small class="text-muted ms-4"><i class="fa fa-envelope me-2 text-primary"></i>MyGarden@gmail.com</small>
            </div>
            <div class="col-lg-6 px-5 text-end">
                <small class="text-muted">Follow us:</small>
                <a class="text-body ms-3" href=""><i class="fab fa-facebook-f"></i></a>
                <a class="text-body ms-3" href=""><i class="fab fa-twitter"></i></a>
                <a class="text-body ms-3" href=""><i class="fab fa-linkedin-in"></i></a>
                <a class="text-body ms-3" href=""><i class="fab fa-instagram"></i></a>
            </div>
        </div>

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

    <div class="container py-5 main-content-wrapper">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="order-summary">
                    <div class="section-title mb-4">
                        <h3 class="title fw-bold text-dark">Keranjang Belanja</h3>
                    </div>

                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if($order && $order->orderItems->count() > 0)
                        <div class="table-responsive">
                            <table class="shopping-cart-table table align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Produk</th>
                                        <th class="text-center">Harga</th>
                                        <th class="text-center" style="width: 160px;">Quantity</th>
                                        <th class="text-center">Total</th>
                                        <th class="text-end">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $totalHargaProduk = 0; $totalBerat = 0; @endphp
                                    @foreach($order->orderItems as $item)
                                        @php 
                                            $totalHargaProduk += $item->harga * $item->quantity; 
                                            $totalBerat += $item->produk->berat * $item->quantity; 
                                        @endphp
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <img src="{{ asset('storage/img-produk/thumb_sm_' . $item->produk->foto) }}" class="rounded me-3" style="width: 70px; height: 70px; object-fit: cover;">
                                                    <div>
                                                        <h6 class="mb-0 fw-bold">{{ $item->produk->nama_produk }}</h6>
                                                        <small class="text-muted">{{ $item->produk->berat }} Gram</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-center">Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                                            <td class="text-center">
                                                <form action="{{ route('order.updateCart', $item->id) }}" method="post" class="input-group input-group-sm justify-content-center">
                                                    @csrf
                                                    <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" max="{{ $item->produk->stok }}" class="form-control text-center cart-qty-input">
                                                    <button type="submit" class="btn btn-warning"><i class="fa fa-sync-alt text-white"></i></button>
                                                </form>
                                            </td>
                                            <td class="text-center fw-bold text-primary">Rp {{ number_format($item->harga * $item->quantity, 0, ',', '.') }}</td>
                                            <td class="text-end">
                                                <form action="{{ route('order.remove', $item->produk->id) }}" method="post">
                                                    @csrf
                                                    <button class="btn btn-sm btn-outline-danger shadow-sm"><i class="fa fa-trash"></i></button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-6">
                                <a href="{{ route('produk.frontend') }}"class="text-decoration-none text-muted">
                                    <i class="fa fa-arrow-left me-2"></i>Lanjut Belanja
                                </a>
                            </div>
                            <div class="col-md-6 mt-3 mt-md-0">
                                <div class="bg-light p-4 rounded border text-dark">
                                    <div class="d-flex justify-content-between mb-2">
                                        <span>Subtotal Produk</span>
                                        <span class="fw-bold">Rp {{ number_format($totalHargaProduk, 0, ',', '.') }}</span>
                                    </div>

                                    @if($order->biaya_ongkir > 0)
                                        <div class="d-flex justify-content-between mb-2 text-success fw-bold">
                                            <span>Ongkir ({{ $order->layanan_ongkir }})</span>
                                            <span>Rp {{ number_format($order->biaya_ongkir, 0, ',', '.') }}</span>
                                        </div>
                                        <hr>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <h5 class="fw-bold">Total Bayar</h5>
                                            <h5 class="fw-bold text-primary">Rp {{ number_format($totalHargaProduk + $order->biaya_ongkir, 0, ',', '.') }}</h5>
                                        </div>
                                    @else
                                        <div class="alert alert-info py-2 small mb-3 border-0 text-center">
                                            <i class="fa fa-info-circle me-1"></i> Pilih pengiriman untuk menghitung ongkir.
                                        </div>
                                    @endif

                                  <div class="d-grid mt-3">
    <form action="{{ route('order.select_shipping') }}" method="get">
        <input type="hidden" name="total_price" value="{{ $totalHargaProduk }}">
        <input type="hidden" name="total_weight" value="{{ $totalBerat }}">

        <button type="submit" 
            class="btn w-100 fw-bold py-2 rounded-pill shadow-sm text-white"
            style="background-color: #3CB815; border: none;">

            {{ $order->biaya_ongkir > 0 ? 'Ubah Pengiriman' : 'Pilih Pengiriman' }}
            <i class="fa fa-truck ms-2"></i>
        </button>
    </form>
</div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fa fa-shopping-cart fa-4x text-light mb-3"></i>
                            <h4 class="text-muted">Keranjang belanja kamu kosong.</h4>
                            <a href="{{ route('produk.frontend') }}" class="btn btn-success px-5 py-2 mt-3 rounded-pill shadow-sm">Mulai Belanja</a>
                        </div>
                    @endif
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
</body>

</html>