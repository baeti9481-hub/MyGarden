<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $produk->nama_produk }} - MyGarden</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500&family=Lora:wght@600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="{{ asset('frontend/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/css/style.css') }}" rel="stylesheet">

    <style>
        /* MENGUBAH BACKGROUND BODY MENJADI PUTIH SEPERTI PERMINTAAN ANDA */
        body { background-color: #ffffff; font-family: 'Open Sans', sans-serif; overflow-x: hidden; padding-top: 130px; }
        @media (max-width: 992px) { body { padding-top: 90px; } }

        /* Navbar & Branding */
        .navbar { background: #ffffff; box-shadow: 0 2px 15px rgba(0,0,0,0.1); }
        .text-primary-custom { color: #3CB815 !important; }
        .text-secondary-custom { color: #FF5E00 !important; }

        /* Detail Wrapper Utama (Sedikit disesuaikan agar tetap terlihat kontras di background putih) */
        .detail-wrapper {
            background: #ffffff;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.06); /* Box shadow sedikit dipertegas agar pembatas kartu terlihat jelas */
            padding: 40px;
            margin-bottom: 50px;
            border: 1px solid #f0f0f0; /* Ditambahkan border halus agar estetika layout tetap terjaga */
        }

        .main-img { width: 100%; height: auto; aspect-ratio: 1/1; object-fit: cover; border-radius: 15px; border: 1px solid #f0f0f0; }
        .thumb-img { width: 70px; height: 70px; object-fit: cover; border-radius: 10px; cursor: pointer; border: 2px solid transparent; transition: 0.3s; }
        .thumb-img.active { border-color: #3CB815; }
        
        .info-status-box { background-color: #fbfbfb; border: 1px solid #eeeeee; border-radius: 12px; padding: 15px; }

        .btn-buy { background-color: #3CB815 !important; color: white; border-radius: 50px; font-weight: bold; padding: 15px 30px; transition: 0.3s; border: none; text-transform: uppercase; }
        .btn-buy:hover { background-color: #35a312 !important; transform: translateY(-2px); color: white; }

        .nav-tabs .nav-link { color: #6c757d !important; border: none !important; border-bottom: 3px solid transparent !important; background: transparent !important; font-weight: 600; }
        .nav-tabs .nav-link.active { color: #3CB815 !important; border-bottom: 3px solid #3CB815 !important; }
    </style>
</head>
<body>
    <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-border text-primary" role="status"></div>
    </div>

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


<div class="container">
    <div class="detail-wrapper">
        
        <nav aria-label="breadcrumb" class="mb-5 border-bottom pb-3">
            <ol class="breadcrumb bg-transparent p-0 m-0">
                <li class="breadcrumb-item"><a href="{{ route('beranda') }}" class="text-primary-custom text-decoration-none small">Beranda</a></li>
                <li class="breadcrumb-item"><a href="{{ route('produk.frontend') }}" class="text-primary-custom text-decoration-none small">Produk</a></li>
                <li class="breadcrumb-item active text-muted small" aria-current="page">{{ $produk->nama_produk }}</li>
            </ol>
        </nav>

        <div class="row g-5">
            <div class="col-lg-5">
                <div class="position-sticky" style="top: 150px;">
                    <img id="mainImage" src="{{ asset('storage/img-produk/' . $produk->foto) }}" class="main-img shadow-sm mb-3" alt="{{ $produk->nama_produk }}">
                    @if($produk->fotoProduk->count() > 0)
                    <div class="d-flex gap-2">
                        <img src="{{ asset('storage/img-produk/' . $produk->foto) }}" class="thumb-img active border" onclick="changeImage(this.src, this)">
                        @foreach($produk->fotoProduk as $f)
                            <img src="{{ asset('storage/img-produk/' . $f->foto) }}" class="thumb-img border" onclick="changeImage(this.src, this)">
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>

            <div class="col-lg-7">
                <span class="badge mb-2 px-3 py-2 rounded-pill bg-success shadow-sm">
                    <i class="bi bi-tag-fill me-1"></i> {{ $produk->kategori->nama_kategori }}
                </span>
                <h1 class="fw-bold text-dark mb-3">{{ $produk->nama_produk }}</h1>
                <div class="mb-4">
                    <h2 class="fw-bold d-inline text-primary-custom">Rp {{ number_format($produk->harga, 0, ',', '.') }}</h2>
                    <span class="text-muted small"> / {{ $produk->berat }} gram</span>
                </div>

                <div class="info-status-box row mx-0 mb-4 text-center">
                    <div class="col-6 border-end">
                        <small class="text-muted d-block text-uppercase" style="font-size: 0.7rem; letter-spacing: 1px;">Stok Tersedia</small>
                        <span class="fw-bold text-dark">{{ $produk->stok }} pcs</span>
                    </div>
                    <div class="col-6">
                        <small class="text-muted d-block text-uppercase" style="font-size: 0.7rem; letter-spacing: 1px;">Kondisi</small>
                        <span class="fw-bold text-dark">
                            {{ $produk->kategori->nama_kategori == 'Peralatan' ? 'Baru & Berkualitas' : 'Segar & Organik' }}
                        </span>
                    </div>
                </div>

                <div class="mb-4 pt-3 border-top">
                    <div class="row mb-2">
                        <div class="col-3 text-muted small fw-bold">SKU</div>
                        <div class="col-9 small">: MYG-{{ str_pad($produk->id, 5, '0', STR_PAD_LEFT) }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-3 text-muted small fw-bold">KATEGORI</div>
                        <div class="col-9 small">: {{ $produk->kategori->nama_kategori }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-3 text-muted small fw-bold">BERAT</div>
                        <div class="col-9 small">: {{ $produk->berat }} Gram</div>
                    </div>
                </div>

                <div class="d-flex align-items-center gap-3 mt-5">
                    <form action="{{ route('order.addToCart', $produk->id) }}" method="POST" class="flex-grow-1">
                        @csrf
                        <button type="submit" class="btn btn-buy w-100 shadow-sm py-3">
                            <i class="fa fa-shopping-cart me-2"></i> TAMBAH KE KERANJANG
                        </button>
                    </form>
                    <a href="https://wa.me/6281234567890?text=Halo MyGarden, saya mau tanya produk {{ $produk->nama_produk }}" target="_blank" class="btn btn-outline-success rounded-circle p-3 shadow-sm">
                        <i class="fab fa-whatsapp fs-4"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="mt-5 pt-5 border-top">
            <ul class="nav nav-tabs mb-4 border-0" id="productTab">
                <li class="nav-item"><button class="nav-link active px-4" data-bs-toggle="tab" data-bs-target="#desc">DESKRIPSI</button></li>
                <li class="nav-item"><button class="nav-link px-4" data-bs-toggle="tab" data-bs-target="#review">ULASAN (0)</button></li>
            </ul>
            <div class="tab-content py-2">
                <div class="tab-pane fade show active" id="desc">
                    <div class="text-muted lh-lg" style="text-align: justify;">{!! $produk->detail !!}</div>
                </div>
                <div class="tab-pane fade" id="review">
                    <div class="text-center py-5">
                        <i class="bi bi-chat-left-dots fs-1 text-muted mb-3 d-block"></i>
                        <p class="text-muted">Belum ada ulasan untuk produk ini.</p>
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
</body>

</html>