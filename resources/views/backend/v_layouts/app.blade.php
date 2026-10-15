<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link class="rounded" rel="icon" type="image/png" sizes="16x16" href="{{ asset('image/tanifreshku.png') }}">
    <title>Backend MyGarden</title>

    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/extra-libs/multicheck/multicheck.css') }}">
    <link href="{{ asset('backend/libs/datatables.net-bs4/css/dataTables.bootstrap4.css') }}" rel="stylesheet">
    <link href="{{ asset('backend/dist/css/style.min.css') }}" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font@7.2.96/css/materialdesignicons.min.css">

    <style>
        /* ================= STRUCTURE SYSTEM ================= */
        html, body {
            margin: 0;
            padding: 0;
            height: 100%;
        }

        #main-wrapper {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* ================= 1. FIX TOPBAR TO SOFT PASTEL GREEN ================= */
        #main-wrapper .topbar, 
        #main-wrapper .topbar .navbar, 
        #main-wrapper .topbar .navbar-collapse,
        .topbar[data-navbarbg="skin6"],
        [data-navbarbg="skin6"],
        #navbarSupportedContent {
            /* Menggunakan warna hijau mint pastel super lembut anti genjreng */
            background-color: #EDF7EC !important; 
            background: #EDF7EC !important;
            border-bottom: 1px solid #dbebd9 !important;
            z-index: 1050; 
            height: 64px !important;
        }
        
        /* ================= 2. ALIGNMENT LOGO BOX ================= */
        #main-wrapper .topbar .navbar-header,
        .topbar .navbar-header[data-logobg="skin6"] {
            background-color: #EDF7EC !important; 
            background: #EDF7EC !important;
            border-right: 1px solid #dbebd9 !important;
            display: flex !important;
            align-items: center !important; 
            justify-content: flex-start !important; 
            height: 64px !important; 
            width: 240px !important; 
            min-width: 240px !important;
            max-width: 240px !important;
        }

        .topbar .navbar-brand {
            display: flex !important;
            align-items: center !important;
            height: 100% !important;
            padding: 0 !important;
            margin: 0 !important;
        }

        .topbar .navbar-nav .nav-item,
        .topbar .nav-link {
            display: flex !important;
            align-items: center !important;
            height: 64px !important;
            padding-top: 0 !important;
            padding-bottom: 0 !important;
        }

        /* Menyesuaikan warna menu profil kanan ke abu-abu gelap agar serasi dengan hijau lembut */
        .topbar .navbar .nav-link, 
        .topbar .navbar i, 
        .topbar .navbar .nav-link i,
        .topbar .navbar .dropdown-toggle { 
            color: #495057 !important; 
        }

        /* Avatar lingkaran inisial nama menggunakan warna hijau MyGarden utama */
        .avatar-initial {
            width: 35px;
            height: 35px;
            background-color: #3CB815 !important;
            color: #ffffff !important;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            font-weight: bold;
            font-size: 14px;
        }

        /* ================= 3. SIDEBAR SYSTEM ================= */
        .left-sidebar {
            background-color: #ffffff !important;
            border-right: 1px solid #e9ecef;
            padding-top: 0 !important; 
            position: fixed !important;
            top: 64px !important; 
            left: 0 !important;
            width: 240px !important; 
            height: calc(100vh - 64px) !important; 
            z-index: 1000;
            overflow: hidden !important; 
        }

        .scroll-sidebar {
            height: 100% !important;
            overflow-y: auto !important; 
            padding-top: 15px !important; 
            padding-bottom: 80px !important; 
        }

        .sidebar-nav ul {
            padding: 0 !important;
            margin: 0 !important;
        }
        
        .sidebar-nav .sidebar-item .sidebar-link {
            padding: 12px 15px !important; 
            display: flex !important;
            align-items: center !important;
        }

        .left-sidebar .sidebar-link, .left-sidebar .sidebar-link i { color: #495057 !important; }
        .left-sidebar .sidebar-item:hover>.sidebar-link,
        .left-sidebar .sidebar-item.selected>.sidebar-link {
            background-color: #f3f4f6 !important;
            color: #3CB815 !important;
        }
        .left-sidebar .sidebar-item:hover i,
        .left-sidebar .sidebar-item.selected i { color: #3CB815 !important; }

        /* ================= 4. KONTEN TENGAH SYSTEM ================= */
        .page-wrapper {
            background: #f8f9fa;
            display: flex !important;
            flex-direction: column !important;
            min-height: auto !important; 
            height: calc(100vh - 64px) !important; 
            overflow-y: auto !important; 
            padding-top: 0px !important; 
            transition: all 0.2s ease;
        }

        @media (min-width: 768px) {
            .page-wrapper {
                margin-left: 240px !important; 
            }
        }

        .page-wrapper .container-fluid {
            flex: 1 0 auto !important;
            padding: 25px !important;
        }

        .footer {
            flex-shrink: 0 !important;
            background: #ffffff;
        }

        @media (max-width: 767px) {
            .navbar-collapse {
                background-color: #EDF7EC !important;
                display: block !important;
            }
            .page-wrapper { margin-left: 0 !important; }
        }
    </style>
</head>

<body>
    <div class="preloader">
        <div class="lds-ripple">
            <div class="lds-pos"></div>
            <div class="lds-pos"></div>
        </div>
    </div>

    <div id="main-wrapper" data-layout="vertical" data-navbarbg="skin5" data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed" data-boxed-layout="full">
        
        <header class="topbar">
            <nav class="navbar top-navbar navbar-expand-md navbar-dark">
                
                <div class="navbar-header">
                    <a class="navbar-brand" href="{{ route('backend.beranda') }}" style="justify-content: flex-start !important; padding-left: 20px !important; width: 100%;">
                        <span class="logo-text">
                            <h4 class="m-0 font-weight-bold d-inline-block" style="letter-spacing: -0.5px; font-size: 24px; font-family: 'Poppins', sans-serif;">
                                <span style="color: #FF5E00 !important;">My</span><span style="color: #3CB815 !important; font-weight: 800;">Garden</span>
                            </h4>
                        </span>
                    </a>
                </div>

                <div class="navbar-collapse collapse" id="navbarSupportedContent">
                    
                    <ul class="navbar-nav float-right ml-auto">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle waves-effect waves-dark" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                                @if(Auth::check() && Auth::user()->foto && file_exists(storage_path('app/public/img-user/' . Auth::user()->foto)))
                                    <img src="{{ asset('storage/img-user/' . Auth::user()->foto) }}" class="rounded-circle" width="32" height="32" style="object-fit: cover;">
                                @elseif(Auth::check())
                                    <div class="avatar-initial">{{ strtoupper(substr(Auth::user()->nama, 0, 1)) }}</div>
                                @else
                                    <i class="fa fa-user-circle font-24"></i>
                                @endif
                            </a>
                            <div class="dropdown-menu dropdown-menu-right shadow-sm border-0 animated flipInY">
                                @if(Auth::check())
                                    <div class="p-3 border-bottom mb-2 text-center">
                                        <h6 class="mb-0 font-weight-bold text-dark">{{ Auth::user()->nama }}</h6>
                                        <small class="text-muted">{{ Auth::user()->email }}</small>
                                    </div>
                                    <a class="dropdown-item" href="{{ route('backend.user.edit', Auth::user()->id) }}">
                                        <i class="fa fa-user m-r-5 text-muted"></i> Profil Saya
                                    </a>
                                @endif
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item text-danger" href="javascript:void(0)" 
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="fa fa-power-off m-r-5"></i> Keluar
                                </a>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>

        <aside class="left-sidebar" data-sidebarbg="skin2">
            <div class="scroll-sidebar">
                <nav class="sidebar-nav text-start">
                    <ul id="sidebarnav">
                        <li class="sidebar-item">
                            <a class="sidebar-link waves-effect waves-dark" href="{{ route('backend.beranda') }}">
                                <i class="mdi mdi-view-dashboard"></i><span class="hide-menu">Beranda</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link waves-effect waves-dark" href="{{ route('backend.user.index') }}">
                                <i class="mdi mdi-account"></i><span class="hide-menu">User</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link waves-effect waves-dark" href="{{ route('backend.customer.index') }}">
                                <i class="mdi mdi-account-multiple"></i><span class="hide-menu">Customer</span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)">
                                <i class="mdi mdi-shopping"></i><span class="hide-menu">Data Produk</span>
                            </a>
                            <ul aria-expanded="false" class="collapse first-level">
                                <li class="sidebar-item">
                                    <a href="{{ route('backend.kategori.index') }}" class="sidebar-link">
                                        <i class="mdi mdi-tag-multiple"></i><span class="hide-menu"> Kategori </span>
                                    </a>
                                </li>
                                <li class="sidebar-item">
                                    <a href="{{ route('backend.produk.index') }}" class="sidebar-link">
                                        <i class="mdi mdi-store"></i><span class="hide-menu"> Produk </span>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li class="sidebar-item">
                            <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)">
                                <i class="mdi mdi-cart"></i><span class="hide-menu">Data Pesanan</span>
                            </a>
                            <ul aria-expanded="false" class="collapse first-level">
                                <li class="sidebar-item">
                                    <a href="{{ route('backend.pesanan.proses') }}" class="sidebar-link">
                                        <i class="mdi mdi-clock text-warning"></i><span class="hide-menu"> Pesanan Proses </span>
                                    </a>
                                </li>
                                <li class="sidebar-item">
                                    <a href="{{ route('backend.pesanan.selesai') }}" class="sidebar-link">
                                        <i class="mdi mdi-check-all text-success"></i><span class="hide-menu"> Pesanan Selesai </span>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li class="sidebar-item">
                            <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)">
                                <i class="mdi mdi-receipt"></i><span class="hide-menu">Laporan</span>
                            </a>
                            <ul aria-expanded="false" class="collapse first-level">
                                <li class="sidebar-item">
                                    <a class="sidebar-link" href="{{ route('backend.laporan.formuser') }}">
                                        <i class="mdi mdi-file-document"></i><span class="hide-menu"> Laporan User </span>
                                    </a>
                                </li>
                                <li class="sidebar-item">
                                    <a class="sidebar-link" href="{{ route('backend.laporan.formproduk') }}">
                                        <i class="mdi mdi-file-chart"></i><span class="hide-menu"> Laporan Produk </span>
                                    </a>
                                </li>
                                <li class="sidebar-item">
                                    <a class="sidebar-link" href="{{ route('backend.laporan.formpesanan') }}">
                                        <i class="mdi mdi-file-chart"></i><span class="hide-menu"> Laporan Pesanan </span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </nav>
            </div>
        </aside>

        <div class="page-wrapper">
            <div class="container-fluid">
                @yield('content')
            </div>
            
            <footer class="footer text-center border-top py-3 mt-4">
                MyGarden &copy; 2026 | Developed by BAETI & PUTRI
            </footer>
        </div>
    </div>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>

    <script src="{{ asset('backend/libs/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('backend/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('backend/dist/js/sidebarmenu.js') }}"></script>
    <script src="{{ asset('backend/dist/js/custom.min.js') }}"></script>
</body>

</html>