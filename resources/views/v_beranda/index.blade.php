@extends('v_layouts.app')

@section('content')

{{-- Bagian Video Tutorial YouTube (3 Kolom Sejajar) --}}
<div class="container-xxl py-5">
    <div class="container">
        <div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 500px;">
            <h1 class="display-5 mb-3 fw-bold">Video Tutorial Menanam</h1>
            <p class="text-primary fs-5">Tips praktis untuk kebun rumah yang lebih subur</p>
        </div>
        <div class="row g-4">
            <!-- Video 1 -->
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                <div class="card border-0 shadow-sm overflow-hidden h-100">
                    <div class="position-relative">
                        <img class="img-fluid w-100" src="https://img.youtube.com/vi/6PH32ZV6CYk/maxresdefault.jpg" alt="Tutorial Lahan Sempit">
                        <div class="position-absolute top-50 start-50 translate-middle">
                            <a href="https://www.youtube.com/watch?v=6PH32ZV6CYk" target="_blank" class="btn btn-lg btn-danger rounded-circle py-3 px-4 shadow">
                                <i class="fa fa-play text-white"></i>
                            </a>
                        </div>
                    </div>
                    <div class="card-body text-center p-4">
                        <h5 class="fw-bold">Berkebun di Lahan Sempit</h5>
                        <p class="text-muted small">Cara cerdas memanfaatkan halaman rumah menjadi kebun produktif.</p>
                        <a href="https://www.youtube.com/watch?v=6PH32ZV6CYk" target="_blank" class="btn btn-outline-primary btn-sm mt-auto">Tonton Sekarang</a>
                    </div>
                </div>
            </div>

            <!-- Video 2 -->
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                <div class="card border-0 shadow-sm overflow-hidden h-100">
                    <div class="position-relative">
                        <img class="img-fluid w-100" src="https://img.youtube.com/vi/xP0ILY__kO4/maxresdefault.jpg" alt="Tutorial Pupuk Organik">
                        <div class="position-absolute top-50 start-50 translate-middle">
                            <a href="https://www.youtube.com/watch?v=xP0ILY__kO4" target="_blank" class="btn btn-lg btn-danger rounded-circle py-3 px-4 shadow">
                                <i class="fa fa-play text-white"></i>
                            </a>
                        </div>
                    </div>
                    <div class="card-body text-center p-4">
                        <h5 class="fw-bold">Rahasia Pupuk Organik Cair</h5>
                        <p class="text-muted small">Buat nutrisi tanaman terbaik dari bahan dapur untuk hasil melimpah.</p>
                        <a href="https://www.youtube.com/watch?v=xP0ILY__kO4" target="_blank" class="btn btn-outline-primary btn-sm mt-auto">Tonton Sekarang</a>
                    </div>
                </div>
            </div>

            <!-- Video 3 -->
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.5s">
                <div class="card border-0 shadow-sm overflow-hidden h-100">
                    <div class="position-relative">
                        <img class="img-fluid w-100" src="https://img.youtube.com/vi/c2Hd4gTQAVk/maxresdefault.jpg" alt="Tutorial Media Tanam">
                        <div class="position-absolute top-50 start-50 translate-middle">
                            <a href="https://www.youtube.com/watch?v=c2Hd4gTQAVk" target="_blank" class="btn btn-lg btn-danger rounded-circle py-3 px-4 shadow">
                                <i class="fa fa-play text-white"></i>
                            </a>
                        </div>
                    </div>
                    <div class="card-body text-center p-4">
                        <h5 class="fw-bold">Racikan Media Tanam Subur</h5>
                        <p class="text-muted small">Komposisi tanah dan nutrisi tepat agar tanaman baru tidak mudah layu.</p>
                        <a href="https://www.youtube.com/watch?v=c2Hd4gTQAVk" target="_blank" class="btn btn-outline-primary btn-sm mt-auto">Tonton Sekarang</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection