<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>MyGarden</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500&family=Lora:wght@600;700&display=swap" rel="stylesheet"> 

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="frontend/lib/animate/animate.min.css" rel="stylesheet">
    <link href="frontend/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="frontend/css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="frontend/css/style.css" rel="stylesheet">
</head>

<body>
    <!-- Spinner Start -->
    <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-border text-primary" role="status"></div>
    </div>
    <!-- Spinner End -->


    <!-- Navbar Start -->
    <div class="container-fluid fixed-top px-0 wow fadeIn" data-wow-delay="0.1s">
        <div class="top-bar row gx-0 align-items-center d-none d-lg-flex">
            <div class="col-lg-6 px-5 text-start">
                <small><i class="fa fa-map-marker-alt me-2"></i>Tegal-Jawa Tengah</small>
                <small class="ms-4"><i class="fa fa-envelope me-2"></i>MyGarden@gmail.com</small>
            </div>
            <div class="col-lg-6 px-5 text-end">
                <small>Follow us:</small>
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
            <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <div class="navbar-nav ms-auto p-4 p-lg-0">
     <a href="/beranda" class="nav-item nav-link ">Beranda</a>
    <a href="/Produk" class="nav-item nav-link ">Produk</a>
    <a href="/tentangkami" class="nav-item nav-link active">Tentang Kami</a>
    <a href="/lokasi" class="nav-item nav-link">Lokasi</a>   
</div>
                @if(Auth::check())
        <div class="nav-item dropdown">
            <a href="#" class="nav-link dropdown-toggle fw-bold text-primary" data-bs-toggle="dropdown">
                <i class="fa fa-user me-1"></i> {{ Auth::user()->nama }}
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


    <!-- Page Header Start -->
    <div class="container-fluid page-header mb-5 wow fadeIn" data-wow-delay="0.1s">
        <div class="container">
            <h1 class="display-3 mb-3 animated slideInDown">Tentang Kami</h1>
            <nav aria-label="breadcrumb animated slideInDown">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a class="text-body" href="#">Beranda</a></li>
                    <li class="breadcrumb-item text-dark active" aria-current="page">Tentang Kami</a></li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- Page Header End -->


    <!-- About Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="row g-5 align-items-center">
                <div class="col-lg-6 wow fadeIn" data-wow-delay="0.1s">
                    <div class="about-img position-relative overflow-hidden p-5 pe-0">
                        <img class="img-fluid w-100" src="frontend/img/kebun.jpeg">
                    </div>
                </div>
                <div class="col-lg-6 wow fadeIn" data-wow-delay="0.5s">
                    <h1 class="display-5 mb-4">My Garden</h1>
                    <p class="mb-4">My Garden adalah platform e-commerce yang berdedikasi untuk mendukung kemandirian pangan dan gaya hidup sehat masyarakat melalui digitalisasi rantai pasok pertanian. Kami hadir sebagai solusi terpadu yang tidak hanya menyediakan bibit tanaman unggul, tetapi juga menghadirkan nutrisi tanaman yang optimal serta peralatan berkebun yang mumpuni dalam satu ekosistem yang mudah diakses.
Dengan standar kontrol kualitas yang ketat, kami memastikan setiap produk yang didistribusikan—mulai dari benih hingga perlengkapan tani—memenuhi kriteria terbaik untuk membantu Anda menciptakan kebun yang subur, berkelanjutan, dan ramah lingkungan. Melalui inovasi teknologi, kami berkomitmen untuk menghubungkan kebutuhan pertanian urban secara efisien, transparan, dan terpercaya.</p>
                </div>
            </div>
        </div>
    </div>
    <!-- About End -->


  


    <!-- Feature Start -->
     <div class="container-fluid bg-light bg-icon my-5 py-6">
        <div class="container">
            <div class="section-header text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s"
                style="max-width: 500px;">
                <h1 class="display-5 mb-3">Fitur Kami</h1>
                <p>Tani Fresh hadir menyediakan bibit dan hasil pertanian segar, berkualitas, dan terpercaya.</p>
            </div>
            
            <div class="row g-4">
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="bg-white text-center h-100 p-4 p-xl-5">
                        <img class="img-fluid mb-4" src="frontend/img/icon-1.png" alt="">
                        <h4 class="mb-3">Produk Organik</h4>
                        <p class="mb-4"> Menyediakan buah dan sayur organik pilihan terbaik.</p>
                        <a class="btn btn-outline-primary border-2 py-2 px-4 rounded-pill" href="">Baca Selengkapnya</a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="bg-white text-center h-100 p-4 p-xl-5">
                        <img class="img-fluid mb-4" src="frontend/img/icon-2.png" alt="">
                        <h4 class="mb-3">Bibit Berkualitas</h4>
                        <p class="mb-4">Menyediakan bibit buah dan sayuran berkualitas dan siap tanam.</p>
                        <a class="btn btn-outline-primary border-2 py-2 px-4 rounded-pill" href="">Baca Selengkapnya</a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.5s">
                    <div class="bg-white text-center h-100 p-4 p-xl-5">
                        <img class="img-fluid mb-4" src="frontend/img/icon-3.png" alt="">
                        <h4 class="mb-3">Proses Alami</h4>
                        <p class="mb-4">Produk diproses secara alami dan menjaga kesegaran.</p>
                        <a class="btn btn-outline-primary border-2 py-2 px-4 rounded-pill" href="">Baca Selengkapnya</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Feature End -->


    <!-- Footer Start -->
    <div class="container-fluid bg-dark footer pt-5 wow fadeIn" data-wow-delay="0.1s">
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

    <script src="frontend/js/main.js"></script>
</body>

</html>