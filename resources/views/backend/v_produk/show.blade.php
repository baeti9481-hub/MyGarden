@extends('backend.v_layouts.app')
@section('content')
<div class="container-fluid">
    {{-- Notifikasi Sukses --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">{{ $judul }}</h4>
                    
                    <div class="mb-3">
                        <a href="{{ route('backend.produk.index') }}">
                            <button type="button" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Kembali</button>
                        </a>
                    </div>

                    <div class="row">
                        
                        {{-- Kolom Kiri: Detail Produk (Tidak ada perubahan) --}}
                        <div class="col-md-6">
                            <h3>Detail Produk Utama</h3>
                            
                            <div class="form-group">
                                <label>Kategori</label>
                                <select name="kategori_id" class="form-control @error('kategori_id') is-invalid @enderror" disabled>
                                    <option value="" selected> - Pilih Kategori - </option>
                                    @foreach ($kategori as $row)
                                    <option value="{{ $row->id }}" {{ old('kategori_id', $show->kategori_id) == $row->id ? 'selected' : '' }}>
                                        {{ $row->nama_kategori }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('kategori_id')
                                <span class="invalid-feedback alert-danger" role="alert">
                                    {{ $message }}
                                </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>Nama Produk</label>
                                <input type="text" name="nama_produk" value="{{ old('nama_produk', $show->nama_produk) }}" class="form-control @error('nama_produk') is-invalid @enderror" placeholder="Masukkan Nama Produk" disabled>
                                @error('nama_produk')
                                <span class="invalid-feedback alert-danger" role="alert">
                                    {{ $message }}
                                </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>Detail</label>
                                <textarea name="detail" class="form-control @error('detail') is-invalid @enderror" id="ckeditor" disabled>{{ old('detail', $show->detail) }}</textarea>
                                @error('detail')
                                <span class="invalid-feedback alert-danger" role="alert">
                                    {{ $message }}
                                </span>
                                @enderror
                            </div>
                            
                            <div class="form-group">
                                <label>Foto Utama</label> <br>
                                <img src="{{ asset('storage/img-produk/' . $show->foto) }}" class="foto-preview img-fluid border p-2" width="100%">
                            </div>
                        </div>

                        {{-- Kolom Kanan: Foto Tambahan & Upload --}}
                        <div class="col-md-6">
                            <h3>Manajemen Foto Tambahan</h3>

                            <div id="foto-container">
                                <div class="row">
                                    @if($show->fotoProduk->isEmpty())
                                        <div class="col-12"><p class="text-muted">Tidak ada foto tambahan saat ini.</p></div>
                                    @else
                                        @foreach($show->fotoProduk as $gambar)
                                        <div class="col-md-6 mb-3">
                                            <img src="{{ asset('storage/img-produk/' . $gambar->foto) }}" class="img-fluid border p-2 mb-2" alt="Foto Tambahan">
                                            
                                            {{-- Form Hapus Foto Tambahan (BENAR) --}}
                                            <form action="{{ route('backend.foto_produk.destroy', $gambar->id) }}" method="post" style="display: inline-block;">
                                                @csrf
                                                @method('delete')
                                                <button type="submit" class="btn btn-danger btn-sm w-100 show_confirm" data-konf-delete="Foto Tambahan">
                                                    <i class="fas fa-trash"></i> Hapus
                                                </button>
                                            </form>
                                        </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                            
                            <hr>
                            
                            {{-- FORM UPLOAD BARU (Disembunyikan, lalu ditampilkan dengan JS) --}}
                            <h4>Upload Foto Baru</h4>
                            <div id="upload-form-wrapper" style="display:none;">
                                <form action="{{ route('backend.foto_produk.store') }}" method="post" enctype="multipart/form-data" class="border p-3">
                                    @csrf
                                    <input type="hidden" name="produk_id" value="{{ $show->id }}">
                                    <div class="form-group">
                                        <label for="foto_upload">Pilih Gambar Tambahan (Mendukung Multi-File)</label>
                                        <input type="file" name="foto_produk[]" class="form-control-file @error('foto_produk') is-invalid @enderror" multiple required>
                                        @error('foto_produk.*')
                                            <div class="invalid-feedback alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <button type="submit" class="btn btn-success">
                                        <i class="fas fa-upload"></i> Upload & Simpan
                                    </button>
                                </form>
                            </div>

                            {{-- Tombol Toggle Form Upload --}}
                            <button type="button" class="btn btn-primary mt-2" id="toggle-upload-form">
                                <i class="fas fa-plus"></i> Tambah Foto
                            </button>

                        </div>
                    </div>
                </div>

                <div class="border-top">
                    <div class="card-body">
                        <a href="{{ route('backend.produk.index') }}">
                            <button type="button" class="btn btn-secondary">Kembali</button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

<script>
    // SCRIPT INI HANYA UNTUK MENGONTROL TAMPILAN FORM (hide/show)
    document.addEventListener('DOMContentLoaded', function() {
        const toggleButton = document.getElementById('toggle-upload-form');
        const uploadForm = document.getElementById('upload-form-wrapper');

        // Mengubah fungsi tombol agar menampilkan/menyembunyikan form
        toggleButton.addEventListener('click', function() {
            if (uploadForm.style.display === 'none') {
                uploadForm.style.display = 'block';
                toggleButton.textContent = 'Sembunyikan Form Upload';
            } else {
                uploadForm.style.display = 'none';
                toggleButton.textContent = 'Tambah Foto';
            }
        });
    });
    
    // Pastikan Anda juga menyertakan script untuk preview gambar dan CKEditor
</script>