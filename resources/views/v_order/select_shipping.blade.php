<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>MyGarden - Pilih Pengiriman</title>
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
    
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <style>
        /* REVISI: Mengikuti background Keranjang abu-abu kontras */
        body { 
            background-color: #ffffff;
            font-family: 'Open Sans', sans-serif; 
            padding-top: 160px; 
        }

        @media (max-width: 992px) {
            body { padding-top: 100px; }
        }

        .navbar {
            background: #ffffff !important;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.06) !important;
            border-bottom: 1px solid #f0f0f0;
        }

        .main-content-wrapper {
            min-height: 70vh;
        }

        /* REVISI: Box Pembungkus persis seperti order-summary di Cart */
        /* REVISI: Mengubah sudut melengkung halus agar tidak lancip */
        .card-ongkir {
            background: #ffffff !important;
            border-radius: 20px !important; /* REVISI: Nilai 20px membuat sudut tumpul/bulat seperti cart */
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.05) !important; /* Bayangan halus khas cart */
            border: 1px solid #f0f0f0 !important;
            padding: 40px;
            margin-bottom: 50px;
        }

        .form-ongkir label {
            font-weight: bold;
            font-size: 14px;
            color: #333;
            margin-bottom: 5px;
        }

        /* REVISI: Desain Tabel Lebar Ke Samping Persis Gaya Cart */
        .shopping-cart-table {
            width: 100%;
            margin-top: 25px;
            border-collapse: collapse;
        }

        .shopping-cart-table thead th {
            background-color: #3CB815; /* Header Hijau MyGarden */
            text-transform: uppercase;
            font-size: 13px;
            font-weight: bold;
            letter-spacing: 0.5px;
            color: #ffffff; /* Teks judul putih */
            padding: 12px 10px;
            border: none;
        }

        .shopping-cart-table td {
            padding: 15px 10px;
            border-bottom: 1px solid #e3e6f0;
            font-size: 14px;
            color: #212529;
            vertical-align: middle;
        }

        /* Tombol Hitam Minimalis untuk Cek Ongkir */
        .btn-cek-ongkir {
            background-color: #3CB815;
            color: white;
            font-weight: bold;
            border: none;
            padding: 10px 25px;
            text-transform: none;
            font-size: 13px;
            letter-spacing: 0.5px;
            border-radius: 4px;
        }

        .btn-cek-ongkir:hover {
            background-color: #3CB815;
            color: white;
        }

        /* REVISI: Tombol Bayar Hijau Khas MyGarden di ujung kanan tabel */
        .btn-pilih-pengiriman {
            background-color: #3CB815;
            color: white;
            border: none;
            font-weight: bold;
            font-size: 13px;
            text-transform: none;
            padding: 8px 20px;
            border-radius: 4px;
            transition: 0.2s;
        }

        .btn-pilih-pengiriman:hover {
            background-color: #2e910f;
            color: white;
        }

        .text-secondary { color: #FF5E00 !important; }
        .text-primary { color: #3CB815 !important; }

        /* Form Autocomplete Select2 Bootstrap style */
        .select2-container .select2-selection--single {
            height: 38px !important;
            border: 1px solid #ced4da !important;
            border-radius: 4px !important;
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 36px !important;
            padding-left: 12px;
            color: #212529;
        }
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 36px !important;
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
                
            <div class="card-ongkir bg-white shadow p-4 p-lg-5">
    <div class="section-title border-bottom pb-2 mb-4">
        <h3 class="fw-bold text-dark mb-0" style="font-size: 22px; letter-spacing: 0.5px;">
            <i class="fa fa-truck me-2 text-primary"></i>Pilih Pengiriman
        </h3>
    </div>
    
                    
                    <form id="ongkirForm" class="form-ongkir">
                        @csrf
                        
                        <input type="hidden" id="originSelect" value="469">

                        <div class="mb-3 text-start">
                            <label class="form-label">Kecamatan atau Kota Tujuan :</label>
                            <select id="destinationSelect" class="form-control shadow-sm" style="width:100%"></select>
                        </div>

                        <div class="mb-3 text-start">
                            <label class="form-label">Kurir :</label>
                            <select id="courier" class="form-select shadow-sm">
                                <option value="">Pilih Kurir</option>
                                <option value="jne">JNE</option>
                                <option value="tiki">TIKI</option>
                                <option value="pos">POS Indonesia</option>
                            </select>
                        </div>

                        <div class="mb-4 text-start">
                            <label class="form-label">Alamat Lengkap Pembeli (Nama Jalan, No. Rumah, RT/RW) :</label>
                            <textarea id="detail_alamat" class="form-control shadow-sm" rows="3" placeholder="Contoh: Jl. Sawo No. 4, RT 09/RW 10"></textarea>
                        </div>

                        <input type="hidden" id="weight" value="{{ $totalBerat ?? 2480 }}">
                        
                        @php 
                            $totalBelanjaProduk = $order->orderItems->sum(function($item) {
                                return $item->harga * $item->quantity;
                            });
                        @endphp
                        <input type="hidden" id="total_harga_produk" value="{{ $totalBelanjaProduk }}">

                        <div class="d-flex justify-content-between align-items-center mt-4 mb-3">
                            <a href="{{ route('order.cart') }}" class="text-decoration-none text-muted">
                                <i class="fa fa-arrow-left me-2"></i>Kembali ke Keranjang
                            </a>
                            
                            <button type="submit" class="btn-cek-ongkir">Cek Harga Ongkir</button>
                        </div>
                    </form>
                    <div id="result" class="table-responsive"></div>
                </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('frontend/lib/wow/wow.min.js') }}"></script>
    <script src="{{ asset('frontend/lib/easing/easing.min.js') }}"></script>
    <script src="{{ asset('frontend/lib/waypoints/waypoints.min.js') }}"></script>
    <script src="{{ asset('frontend/lib/owlcarousel/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('frontend/js/main.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
    function pilihLayanan(layanan, biaya, estimasi) {
        const fullAddressText = document.getElementById('detail_alamat').value + ', ' + $("#destinationSelect option:selected").text();

        const payload = {
            kurir: document.getElementById('courier').value.toUpperCase(),
            layanan_ongkir: layanan,
            biaya_ongkir: biaya,
            estimasi_ongkir: estimasi.toUpperCase().replace('DAY', '').replace('HARI', '').trim() + ' Hari',
            total_berat: document.getElementById('weight').value,
            alamat: fullAddressText
        };

        fetch('{{ route("order.updateongkir") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            },
            body: JSON.stringify(payload)
        })
        .then(response => response.json())
        .then(data => {
            window.location.href = "{{ route('order.select_payment') }}";
        })
        .catch(error => alert('Gagal menyimpan data pengiriman.'));
    }

    document.addEventListener('DOMContentLoaded', function () {
        // Init Select2 Kecamatan V2 Komerce
        $('#destinationSelect').select2({
            placeholder: 'Ketik nama kecamatan atau kota tujuan',
            minimumInputLength: 2,
            ajax: {
                url: '/ongkir/get-destination',
                dataType: 'json',
                delay: 500,
                data: function(params) {
                    return { search: params.term };
                },
                processResults: function(data) {
                    const items = data.data || data;
                    if (items && items.length > 0) {
                        const results = items.slice(0, 10).map(item => ({
                            id: item.id || item.subdistrict_id,
                            text: (item.label || `${item.subdistrict_name}, ${item.city_name}`)
                        }));
                        return { results };
                    }
                    return { results: [] };
                }
            }
        });

        document.getElementById('ongkirForm').onsubmit = function(e) {
            e.preventDefault();
            const resultDiv = document.getElementById('result');
            const destSelect = document.getElementById('destinationSelect');
            const courierSelect = document.getElementById('courier');
            const totalWeightGram = document.getElementById('weight').value;
            const subtotalProdukValue = document.getElementById('total_harga_produk').value;

            if(!destSelect.value || !courierSelect.value || !document.getElementById('detail_alamat').value) {
                alert('Mohon lengkapi Kecamatan Tujuan, Pilihan Kurir, dan Alamat Lengkap!');
                return;
            }

            resultDiv.innerHTML = '<div class="text-center p-4"><div class="spinner-border text-success"></div><p class="mt-2 text-muted">Sedang memuat ongkir...</p></div>';

            $.ajax({
                url: '/ongkir/calculate',
                method: 'POST',
                data: {
                    origin: document.getElementById('originSelect').value,
                    destination: destSelect.value,
                    weight: totalWeightGram,
                    courier: courierSelect.value
                },
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                success: function(response) {
                    if (response.data && response.data.length > 0) {
                        // REVISI: Header tabel diganti warna hijau penuh, persis layout Cart kamu!
                        let html = '<table class="shopping-cart-table table align-middle"><thead><tr><th>Layanan</th><th class="text-center">Biaya</th><th class="text-center">Estimasi Pengiriman</th><th class="text-center">Total Berat</th><th class="text-center">Total Harga</th><th class="text-end pe-3">Aksi</th></tr></thead><tbody>';
                        
                        response.data.forEach(item => {
                            let formatBiayaProduk = `Rp ${new Intl.NumberFormat('id-ID').format(subtotalProdukValue)}`;
                            let stringEtdClean = item.etd ? item.etd.toUpperCase().replace('HARI','').replace('DAY','').trim() + ' Hari' : '2-3 Hari';
                            
                            html += `<tr>
                                <td class="fw-bold text-dark ps-2">${item.service}</td>
                                <td class="text-center">Rp ${item.cost.toLocaleString('id-ID')}</td>
                                <td class="text-center">${stringEtdClean}</td>
                                <td class="text-center">${totalWeightGram} Gram</td>
                                <td class="text-center fw-bold text-success">${formatBiayaProduk}</td>
                                <td class="text-end pe-2">
                                    <button type="button" class="btn-pilih-pengiriman shadow-sm" onclick="pilihLayanan('${item.service}', ${item.cost}, '${item.etd || '2-3'}')">Pilih</button>
                                </td>
                            </tr>`;
                        });
                        resultDiv.innerHTML = html + '</tbody></table>';
                    } else {
                        resultDiv.innerHTML = '<div class="alert alert-warning mt-4 text-center border-0">Tidak ada layanan pengiriman yang tersedia untuk kurir ini.</div>';
                    }
                },
                error: function() {
                    resultDiv.innerHTML = '<div class="alert alert-danger mt-4 text-center border-0">Terjadi kesalahan pada sistem hitung cURL server.</div>';
                }
            });
        };
    });
    </script>
</body>
</html>