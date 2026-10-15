<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>MyGarden - History Pesanan</title>
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
        body { background-color: #ffffff; font-family: 'Open Sans', sans-serif; }
        
        .main-content-wrapper { min-height: 75vh; margin-top: 140px; padding-bottom: 50px; }

        /* Navbar Shadow halus */
        .navbar {
            background: #ffffff !important;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.06) !important;
            border-bottom: 1px solid #f0f0f0;
        }

        /* Title Style - Warna MERAH awal */
        .history-title {
            border-bottom: 1px solid #f0f0f0;
            padding-bottom: 15px;
            margin-bottom: 30px;
            position: relative;
        }
        .history-title::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: -1px;
            width: 80px;
            height: 3px;
            background-color: #ff6b6b;
        }

        /* Table Design */
        .history-card {
            background: #ffffff;
            border-radius: 15px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.05);
            border: 1px solid #f0f0f0;
            padding: 25px;
        }
        .table-history thead th {
            background-color: #3CB815;
            border: none;
            text-transform: uppercase;
            font-size: 12px;
            letter-spacing: 1px;
            color: #ffffff;
            padding: 15px;
            font-weight: 700;
        }
        .table-history thead tr th:first-child {
             border-top-left-radius: 8px;
        }
        .table-history thead tr th:last-child {
            border-top-right-radius: 8px;
        }

        .table-history tbody td {
            padding: 15px;
            vertical-align: middle;
            border-bottom: 1px solid #f1f1f1;
            color: #555;
        }

        /* Action Buttons */
        .btn-detail {
            background-color: #ff6b6b;
            color: white !important;
            border: none;
            padding: 8px 16px;
            font-size: 11px;
            font-weight: 700;
            border-radius: 4px;
            transition: 0.3s;
            text-transform: uppercase;
        }
        .btn-detail:hover { background-color: #ee5253; transform: translateY(-2px); }

        .btn-invoice {
            background-color: #6c757d;
            color: white !important;
            border: none;
            padding: 8px 16px;
            font-size: 11px;
            font-weight: 700;
            border-radius: 4px;
            margin-left: 5px;
            transition: 0.3s;
            text-transform: uppercase;
            text-decoration: none;
            display: inline-block;
        }
        .btn-invoice:hover { background-color: #5a6268; transform: translateY(-2px); }

        /* Modal Custom */
        .modal-content { border-radius: 10px; overflow: hidden; }
        .modal-header { background-color: #ff6b6b; color: white; border: none; }
        .order-info-box { background: #f8f9fa; border-radius: 8px; padding: 15px; }
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

    <div class="container main-content-wrapper">
        <div class="row justify-content-center">
            <div class="col-lg-11 text-start">
                <div class="history-title">
                    <h3 class="fw-bold text-dark mb-0 text-uppercase">History Pesanan</h3>
                </div>

                @if(session('success'))
                    <div class="alert alert-success border-0 shadow-sm mb-4">
                        <i class="fa fa-check-circle me-2"></i>{{ session('success') }}
                    </div>
                @endif

                @if(isset($orders) && $orders->count() > 0)
                <div class="history-card">
                    <div class="table-responsive">
                        <table class="table-history w-100">
                            <thead>
                                <tr>
                                    <th>ID PESANAN</th>
                                    <th>TANGGAL</th>
                                    <th>TOTAL BAYAR</th>
                                    <th>STATUS</th>
                                    <th class="text-center">AKSI</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orders as $row) 
                                <tr> 
                                    <td class="fw-bold">#{{ $row->id }}</td> 
                                    <td>{{ $row->created_at->format('d M Y, H:i') }}</td> 
                                    <td class="fw-bold">Rp {{ number_format($row->total_harga + $row->biaya_ongkir, 0, ',', '.') }}</td> 
                                    <td>
                                        <span class="badge {{ $row->status == 'Paid' ? 'bg-primary' : 'bg-info' }}">
                                            {{ $row->status == 'Paid' ? 'PROSES' : strtoupper($row->status) }}
                                        </span>
                                    </td> 
                                    <td class="text-center">
                                        <button type="button" class="btn-detail" data-bs-toggle="modal" data-bs-target="#detailModal{{ $row->id }}">
                                            LIHAT DETAIL
                                        </button>
                                        
                                        <a href="{{ route('order.invoice', $row->id) }}" target="_blank" class="btn-invoice">
                                            INVOICE
                                        </a>

                                        <div class="modal fade" id="detailModal{{ $row->id }}" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered modal-lg">
                                                <div class="modal-content border-0 shadow-lg">
                                                    <div class="modal-header bg-secondary">
                                                        <h5 class="modal-title text-white">Rincian Transaksi #{{ $row->id }}</h5>
                                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body p-4 text-start">
                                                        <div class="row mb-4">
                                                            <div class="col-6">
                                                                <p class="text-muted mb-1 small">DIKIRIM KE:</p>
                                                                <h6 class="fw-bold mb-0">{{ Auth::user()->nama }}</h6>
                                                                <p class="mb-0 small text-dark">{!! $row->alamat !!}</p>
                                                                <p class="mb-0 small text-dark">Kode Pos: {{ $row->pos }}</p>
                                                            </div>
                                                            <div class="col-6 text-end border-start">
                                                                <p class="text-muted mb-1 small">STATUS:</p>
                                                                <h6 class="text-danger fw-bold">{{ strtoupper($row->status) }}</h6>
                                                                <p class="mb-0 small">No. Resi: {{ $row->noresi ?? 'Belum Tersedia' }}</span></p>
                                                            </div>
                                                        </div>

                                                        <table class="table table-sm">
                                                            <thead class="bg-light">
                                                                <tr>
                                                                    <th>Produk</th>
                                                                    <th class="text-center">Qty</th>
                                                                    <th class="text-end">Subtotal</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach($row->orderItems as $item)
                                                                <tr>
                                                                    <td>{{ $item->produk->nama_produk }}</td>
                                                                    <td class="text-center">{{ $item->quantity }}</td>
                                                                    <td class="text-end">Rp {{ number_format($item->harga * $item->quantity, 0, ',', '.') }}</td>
                                                                </tr>
                                                                @endforeach
                                                            </tbody>
                                                            <tfoot class="bg-light fw-bold">
                                                                <tr>
                                                                    <td colspan="2" class="text-end small">Ongkir ({{ strtoupper($row->kurir) }})</td>
                                                                    <td class="text-end">Rp {{ number_format($row->biaya_ongkir, 0, ',', '.') }}</td>
                                                                </tr>
                                                                <tr class="text-danger">
                                                                    <td colspan="2" class="text-end h5 fw-bold">TOTAL BAYAR</td>
                                                                    <td class="text-end h5 fw-bold">Rp {{ number_format($row->total_harga + $row->biaya_ongkir, 0, ',', '.') }}</td>
                                                                </tr>
                                                            </tfoot>
                                                        </table>
                                                    </div>
                                                    <div class="modal-footer bg-light">
                                                        <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">Tutup</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td> 
                                </tr> 
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @else
                <div class="text-center py-5">
                    <i class="fa fa-history fa-4x text-light mb-3"></i>
                    <h4 class="text-muted">Belum ada history pesanan.</h4>
                    <a href="{{ route('produk.frontend') }}" class="btn btn-primary px-5 py-2 mt-3 rounded-pill shadow-sm">Belanja Sekarang</a>
                </div>
                @endif
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
                        <a class="btn btn-square btn-outline-light rounded-circle me-1" href=""><i class="fab fa-twitter"></i></a>
                        <a class="btn btn-square btn-outline-light rounded-circle me-1" href=""><i class="fab fa-facebook-f"></i></a>
                        <a class="btn btn-square btn-outline-light rounded-circle me-1" href=""><i class="fab fa-youtube"></i></a>
                        <a class="btn btn-square btn-outline-light rounded-circle me-0" href=""><i class="fab fa-linkedin-in"></i></a>
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
                        <input class="form-control bg-transparent w-100 py-3 ps-4 pe-5" type="text" placeholder="Email Anda">
                        <button type="button" class="btn btn-primary py-2 position-absolute top-0 end-0 mt-2 me-2">Daftar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
      
    <a href="#" class="btn btn-lg btn-primary btn-lg-square rounded-circle back-to-top"><i class="bi bi-arrow-up"></i></a>

    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="frontend/lib/wow/wow.min.js"></script>
    <script src="frontend/lib/easing/easing.min.js"></script>
    <script src="frontend/lib/waypoints/waypoints.min.js"></script>
    <script src="frontend/lib/owlcarousel/owl.carousel.min.js"></script>

    <script src="{{ asset('frontend/js/main.js') }}"></script>
</body>

</html>