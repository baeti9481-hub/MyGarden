@extends('backend.v_layouts.app')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                {{-- PERBAIKAN 1: Ganti $edit->id menjadi $kategori->id --}}
                <form action="{{ route('backend.kategori.update', $kategori->id) }}" method="post"> 
                    @method('put')
                    @csrf
                    
                    <div class="card-body">
                        <h4 class="card-title"> {{ $judul }} </h4>
                        
                        <div class="form-group m-t-20">
                            <label>Nama Kategori</label>
                            <input type="text" name="nama_kategori" 
                                   {{-- PERBAIKAN 2: Ganti $edit->nama_kategori menjadi $kategori->nama_kategori --}}
                                   value="{{ old('nama_kategori', $kategori->nama_kategori) }}" 
                                   class="form-control @error('nama_kategori') is-invalid @enderror" 
                                   placeholder="Masukkan Nama Kategori">
                            @error('nama_kategori')
                                <span class="invalid-feedback alert-danger" role="alert">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>

                    </div>
                    <div class="border-top">
                        <div class="card-body">
                            <button type="submit" class="btn btn-primary">Ubah</button>
                            <a href="{{ route('backend.kategori.index') }}">
                                <button type="button" class="btn btn-secondary">Kembali</button>
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection