@extends('backend.v_layouts.app')
@section('content')
    <h3> {{ $judul }} </h3>
    
    {{-- KOTAK SELAMAT DATANG DENGAN WARNA HIJAU MUDA --}}
    <div class="card bg-light border-success mb-4"> 
        <div class="card-body">
            <h5 class="card-title text-success">Informasi Akun</h5>
            <p>Selamat Datang, <b>{{ Auth::user()->nama }}</b> pada aplikasi Toko Online dengan hak akses yang anda miliki sebagai
                <b>{{ Auth::user()->role == 1 ? 'Super Admin' : 'Admin' }}</b> ini adalah halaman utama dari aplikasi ini.
            </p>
        </div>
    </div>
    
    <div class="row">
        
        {{-- CARD 1: PRODUK (HIJAU) --}}
        <div class="col-md-6 col-lg-4 col-xlg-3 mb-4">
            <a href="{{ route('backend.produk.index') }}" style="text-decoration: none;">
                <div class="card card-hover">
                    <div class="box bg-success text-center">
                        <h1 class="font-light text-white"><i class="mdi mdi-shopping"></i></h1>
                        <h6 class="text-white">Produk</h6> 
                    </div>
                </div>
            </a>
        </div>
        
        {{-- CARD 2: KATEGORI (BIRU) --}}
        <div class="col-md-6 col-lg-4 col-xlg-3 mb-4">
            <a href="{{ route('backend.kategori.index') }}" style="text-decoration: none;">
                <div class="card card-hover">
                    <div class="box bg-info text-center">
                        <h1 class="font-light text-white"><i class="mdi mdi-clipboard-text"></i></h1>
                        <h6 class="text-white">Kategori</h6>
                    </div>
                </div>
            </a>
        </div>
        
        {{-- CARD 3: USER --}}
        <div class="col-md-6 col-lg-4 col-xlg-3 mb-4">
            <a href="{{ route('backend.user.index') }}" style="text-decoration: none;">
                <div class="card card-hover">
                    <div class="box bg-primary text-center">
                        <h1 class="font-light text-white"><i class="mdi mdi-account-multiple"></i></h1>
                        <h6 class="text-white">User</h6> 
                    </div>
                </div>
            </a>
        </div>
        
    </div>

    {{-- SECTION BARU: GRAFIK --}}
    <div class="row">
        <div class="col-12 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-white font-weight-bold">
                    <i class="mdi mdi-chart-bar text-primary mr-2"></i> Grafik Ringkasan Data
                </div>
                <div class="card-body">
                    <div style="position: relative; height:300px; width:100%">
                        <canvas id="myChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('myChart').getContext('2d');
        
        // Contoh Data Statis (Silakan sesuaikan/lempar data dari Controller jika diperlukan nanti)
        const myChart = new Chart(ctx, {
            type: 'bar', // Bisa diganti 'line', 'pie', 'doughnut'
            data: {
                labels: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni'],
                datasets: [{
                    label: 'Estimasi Penjualan Produk',
                    data: [12, 19, 3, 5, 2, 3], // Angka data grafik
                    backgroundColor: [
                        'rgba(40, 167, 69, 0.7)',  // Hijau (bg-success)
                        'rgba(23, 162, 184, 0.7)',  // Biru Muda (bg-info)
                        'rgba(0, 123, 255, 0.7)',   // Biru Tua (bg-primary)
                        'rgba(255, 193, 7, 0.7)',   // Kuning
                        'rgba(220, 53, 69, 0.7)',   // Merah
                        'rgba(108, 117, 125, 0.7)'  // Abu-abu
                    ],
                    borderColor: [
                        '#28a745',
                        '#17a2b8',
                        '#007bff',
                        '#ffc107',
                        '#dc3545',
                        '#6c757d'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
@endsection