<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>MyGarden - Edit Profil</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <base href="{{ url('/') }}/">
    <link href="{{ asset('frontend/img/favicon.ico') }}" rel="icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500&family=Lora:wght@600;700&display=swap" rel="stylesheet">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="{{ asset('frontend/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/css/style.css') }}" rel="stylesheet">

    <style>
        /* REVISI: Background Putih Murni */
        body {
            background-color: #ffffff;
            font-family: 'Open Sans', sans-serif;
            padding-top: 145px; /* Memberi ruang agar tidak tertutup navbar */
        }

        @media (max-width: 992px) {
            body { padding-top: 100px; }
        }

        /* Navbar dengan bayangan halus sesuai halaman lainnya */
        .navbar {
            background: #ffffff !important;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.06) !important;
            border-bottom: 1px solid #f0f0f0;
        }

        /* Card Form Edit Profil */
        .edit-profile-card {
            background: #ffffff;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.05);
            border: 1px solid #f0f0f0;
            padding: 40px;
        }

        /* Foto Profil Circle */
        .profile-img-wrapper {
            position: relative;
            display: inline-block;
        }
        .profile-img {
            width: 150px;
            height: 150px;
            object-fit: cover;
            border-radius: 50%;
            border: 4px solid #f8f9fa;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .btn-primary {
            background-color: #3CB815;
            border-color: #3CB815;
        }
        .btn-primary:hover {
            background-color: #35a312;
            border-color: #35a312;
        }
        
        .text-primary { color: #3CB815 !important; }
        .text-secondary { color: #FF5E00 !important; }

        .form-floating > label {
            color: #6c757d;
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


    <div class="container-xxl py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="edit-profile-card">
                        
                        @if(session()->has('success'))
                            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
                                <i class="fa fa-check-circle me-2"></i> {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <div class="text-center mb-5">
                            <h1 class="display-6 mb-2">Informasi Akun</h1>
                            <p class="text-muted">Perbarui informasi profil Anda untuk kenyamanan bertransaksi.</p>
                        </div>

                        <form action="{{ route('customer.updateProfil') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row g-4">
                                <div class="col-12 text-center mb-4">
                                    <div class="profile-img-wrapper mb-3">
                                        @if (Auth::user()->foto)
                                            <img src="{{ asset('storage/img-customer/'.Auth::user()->foto) }}" class="profile-img">
                                        @else
                                            <img src="{{ asset('storage/img-customer/bee.jpeg') }}" class="profile-img">
                                        @endif
                                    </div>
                                    <div class="mx-auto" style="max-width: 300px;">
                                        <input type="file" name="foto" class="form-control form-control-sm">
                                        <small class="text-muted mt-1 d-block">Gunakan foto formal untuk profil Anda</small>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" name="nama" class="form-control" id="nama" placeholder="Nama" value="{{ old('nama', Auth::user()->nama) }}">
                                        <label for="nama">Nama Lengkap</label>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="email" class="form-control bg-white" id="email" value="{{ Auth::user()->email }}" readonly>
                                        <label for="email">Email (Permanen)</label>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" name="no_hp" class="form-control" id="no_hp" placeholder="No HP" value="{{ old('no_hp', $edit->no_hp) }}">
                                        <label for="no_hp">Nomor Telepon</label>
                                    </div>
                                    @error('no_hp') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>

                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" name="pos" class="form-control" id="pos" placeholder="Kode Pos" value="{{ old('pos', $edit->pos) }}">
                                        <label for="pos">Kode Pos</label>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-floating">
                                        <textarea name="alamat" class="form-control" id="alamat" placeholder="Alamat" style="height: 120px">{{ old('alamat', $edit->alamat) }}</textarea>
                                        <label for="alamat">Alamat Lengkap</label>
                                    </div>
                                </div>

                                <div class="col-12 text-center mt-5">
                                    <button class="btn btn-primary rounded-pill py-3 px-5 shadow" type="submit">Simpan Perubahan</button>
                                </div>
                            </div>
                        </form>
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
</body>

</html>