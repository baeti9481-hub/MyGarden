<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Frontend MyGarden</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <link href="frontend/img/favicon.ico" rel="icon">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500&family=Lora:wght@600;700&display=swap"
        rel="stylesheet">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Baris 21-22 -->
<link href="{{ asset('frontend/lib/animate/animate.min.css') }}" rel="stylesheet">
<link href="{{ asset('frontend/lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">

<!-- Baris 24 -->
<link href="{{ asset('frontend/css/bootstrap.min.css') }}" rel="stylesheet">

<!-- Baris 26 -->
<link href="{{ asset('frontend/css/style.css') }}" rel="stylesheet">
</head>

<body>
    <div id="spinner"
        class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-border text-primary" role="status"></div>
    </div>
    <div class="container-fluid fixed-top px-0 wow fadeIn" data-wow-delay="0.1s">
        <div class="top-bar row gx-0 align-items-center d-none d-lg-flex">
            <div class="col-lg-6 px-5 text-start">
                <small><i class="fa fa-map-marker-alt me-2"></i>Tegal-Jawa Tengah</small>
                <small class="ms-4"><i class="fa fa-envelope me-2"></i>MyGarden@gmail.com</small>
            </div>
            <div class="col-lg-6 px-5 text-end">
                <small>Follow Kami:</small>
                <a class="text-body ms-3" href=""><i class="fab fa-facebook-f"></i></a>
                <a class="text-body ms-3" href=""><i class="fab fa-twitter"></i></a>
                <a class="text-body ms-3" href=""><i class="fab fa-linkedin-in"></i></a>
                <a class="text-body ms-3" href=""><i class="fab fa-instagram"></i></a>
            </div>
        </div>

        <nav class="navbar navbar-expand-lg navbar-light py-lg-0 px-lg-5 wow fadeIn" data-wow-delay="0.1s">
            <a href="index.html" class="navbar-brand ms-4 ms-lg-0">
                <h1 class="fw-bold text-primary m-0"><span class="text-secondary">My</span>Garden</h1>
            </a>
            <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse"
                data-bs-target="#navbarCollapse">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
    <div class="navbar-nav ms-auto p-4 p-lg-0 align-items-center">
    <a href="{{ route('beranda') }}" class="nav-item nav-link active">Beranda</a>
    <a href="{{ route('produk.frontend') }}" class="nav-item nav-link">Produk</a>
    <a href="{{ url('/tentangkami') }}" class="nav-item nav-link">Tentang Kami</a>
    <a href="{{ route('lokasi') }}" class="nav-item nav-link">Lokasi</a>   

   @auth
    <div class="nav-item dropdown">
        <a href="#" class="nav-link dropdown-toggle fw-bold text-primary" data-bs-toggle="dropdown">
            <i class="fa fa-user me-1"></i> {{ auth()->user()->nama }}
        </a>

        <div class="dropdown-menu m-0 shadow-sm border-0">
                                <a href="{{ route('customer.akun') }}" class="dropdown-item">
                                    </i>Akun Saya
                                </a>
                                <a href="{{ route('order.history') }}" class="dropdown-item">
                                    </i>Riwayat Pesanan
                                </a>
                                <hr class="dropdown-divider">
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger border-0 bg-transparent w-100 text-start">
                                       </i>Logout
                                    </button>
                                </form>
                            </div>
                        </div>
@else
    <a href="{{ route('auth.redirect') }}" class="btn btn-outline-danger rounded-pill px-3 ms-3">
        <i class="fab fa-google me-2"></i> Login with Google
    </a>
@endauth

                    {{-- CART --}}
                    <div class="d-none d-lg-flex ms-2">

                        <a class="btn-sm-square bg-white rounded-circle ms-3 position-relative shadow-sm border"
                            href="{{ route('order.cart') }}">

                            <small class="fa fa-shopping-bag text-body"></small>

                            @auth

                                @php
                                    $cartCount = \App\Models\Order::where('customer_id', Auth::user()->customer->id)
                                        ->where('status', 'pending')
                                        ->first();
                                @endphp

                                @if($cartCount && $cartCount->orderItems->count() > 0)

                                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
                                        style="font-size: 0.6rem;">

                                        {{ $cartCount->orderItems->count() }}
                                    </span>

                                @endif

                            @endauth

                        </a>

                    </div>

                </div>
            </div>
        </nav>
    </div>
    <!-- Navbar End -->
    <div class="container-fluid p-0 mb-5 wow fadeIn" data-wow-delay="0.1s">
        <div id="header-carousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img class="w-100" src="frontend/img/carousel-3.png" alt="Image">
                    <div class="carousel-caption">
                        <div class="container">
                            <div class="row justify-content-start">
                                <div class="col-lg-7">
                                    <h1 class="display-2 mb-5 animated slideInDown">Kebun Impian, Dimulai dari Bibit Pilihan</h1>
                                
                            
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <img class="w-100" src="frontend/img/carousel-3.png" alt="Image">
                    <div class="carousel-caption">
                        <div class="container">
                            <div class="row justify-content-start">
                                <div class="col-lg-7">
                                    <h1 class="display-2 mb-5 animated slideInDown">Kebun Impian, Dimulai dari Bibit Pilihan</h1>
                                
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#header-carousel"
                data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#header-carousel"
                data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>
    <div class="container-xxl py-5">
        <div class="container">
            <div class="row g-5 align-items-center">
                <div class="col-lg-6 wow fadeIn" data-wow-delay="0.1s">
                    <div class="about-img position-relative overflow-hidden p-5 pe-0">
                        <img class="img-fluid w-100" src="frontend/img/sarung.jpeg">
                    </div>
                </div>
                <div class="col-lg-6 wow fadeIn" data-wow-delay="0.5s">
                    <h1 class="display-4 mb-4">Tumbuhkan Kebahagiaan di Setiap Jengkal Lahan</h1>
                    <p class="mb-4">Wujudkan Kebun Impian Anda di Rumah Bersama Tani Fresh</p>
                    <p class="mb-3"><i class="fa fa-check text-primary me-3"></i>🏡 Ubah Lahan Sempit Jadi Asri (Tersedia paket hidroponik & pot)</p>
                    <p class="mb-3"><i class="fa fa-check text-primary me-3"></i>✨ Varietas Asli & Terkurasi (Bukan sekadar bibit biasa)</p>
                    <p class="mb-3"><i class="fa fa-check text-primary me-3"></i>🥗 Panen Sehat dari Halaman Sendiri (Nutrisi alami untuk hasil maksimal)</p>
                    <p class="mb-3"><i class="fa fa-check text-primary me-3"></i>🛠️ Alat Berkebun Berkualitas (Awet, kuat, dan nyaman digunakan)</p>
                </div>
            </div>
        </div>
    </div>
    <!-- Bagian Fitur Kami -->
<div class="container-fluid bg-icon my-5 py-6" style="background-color: #3cb815 !important;"> {{-- Pakai !important agar warna hijau pasti muncul --}}
    <div class="container">
        <div class="section-header text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 500px;">
            <h1 class="display-5 mb-3 text-white fw-bold">Fitur Kami</h1> {{-- Pakai text-white agar tulisan putih --}}
            <p class="text-white fs-5">Tani Fresh hadir menyediakan bibit dan hasil pertanian segar, berkualitas, dan terpercaya.</p>
        </div>
        
        <div class="row g-4">
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                <div class="bg-white text-center h-100 p-4 p-xl-5 rounded shadow">
                    <img class="img-fluid mb-4" src="frontend/img/icon-1.png" alt="">
                    <h4 class="mb-3 fw-bold">Produk Organik</h4>
                    <p class="mb-4 text-muted small">Menyediakan buah dan sayur organik pilihan terbaik.</p>
                    <a class="btn btn-outline-primary border-2 py-2 px-4 rounded-pill" href="">Baca Selengkapnya</a>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                <div class="bg-white text-center h-100 p-4 p-xl-5 rounded shadow">
                    <img class="img-fluid mb-4" src="frontend/img/icon-2.png" alt="">
                    <h4 class="mb-3 fw-bold">Bibit Berkualitas</h4>
                    <p class="mb-4 text-muted small">Menyediakan bibit buah dan sayuran berkualitas dan siap tanam.</p>
                    <a class="btn btn-outline-primary border-2 py-2 px-4 rounded-pill" href="">Baca Selengkapnya</a>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.5s">
                <div class="bg-white text-center h-100 p-4 p-xl-5 rounded shadow">
                    <img class="img-fluid mb-4" src="frontend/img/icon-3.png" alt="">
                    <h4 class="mb-3 fw-bold">Proses Alami</h4>
                    <p class="mb-4 text-muted small">Produk diproses secara alami dan menjaga kesegaran.</p>
                    <a class="btn btn-outline-primary border-2 py-2 px-4 rounded-pill" href="">Baca Selengkapnya</a>
                </div>
            </div>
        </div>
    </div>
</div>
        
                        <div>
                            <!-- @yieldAwal -->
                            @yield('content')
                            <!-- @yieldAkhir-->
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