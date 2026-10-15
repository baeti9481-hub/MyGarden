@extends('backend.v_layouts.app')
@section('content')
<div class="row">

    <div class="col-12">
        <a href="{{ route('backend.produk.create') }}">
            <button type="button" class="btn btn-primary mb-3"><i class="fas fa-plus"></i> Tambah</button>
        </a>
        <div class="card">
            <div class="card-body">
                {{-- AREA JUDUL DAN PENCARIAN DI SEBELAH KANAN --}}
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="card-title mb-0"> {{ $judul }} </h5>
                    
                    <form action="{{ url()->current() }}" method="GET" class="form-inline">
                        <div class="input-group input-group-sm" style="width: 250px;">
                            <input type="text" name="search" class="form-control" placeholder="Cari nama produk..." value="{{ request('search') }}">
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-default bg-light border">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            
                <div class="table-responsive">
                    <table id="zero_config" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Gambar</th>
                                <th>Kategori</th>
                                <th>Status</th>
                                <th>Nama Produk</th>
                                <th>Harga</th>
                                <th>Stok</th>
                                <th>Admin</th> 
                                <th>Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($index as $row)
                            <tr>
                                {{-- Penomoran dinamis mengikuti halaman aktif --}}
                                <td> {{ ($index->currentPage() - 1) * $index->perPage() + $loop->iteration }}</td>
                                <td style="display: flex; justify-content: center; align-items: center"> 
                                    <img src="{{ asset('storage/img-produk/' .$row->foto) }}" width="100"> 
                                </td>
                                <td> {{ $row->kategori->nama_kategori ?? 'N/A' }} </td>
                                <td>
                                    @if ($row->status == 1)
                                        <span class="badge badge-success">Publis</span>
                                    @elseif($row->status == 0)
                                        <span class="badge badge-secondary">Blok</span>
                                    @endif
                                </td>
                                <td> {{ $row->nama_produk }} </td>
                                <td> Rp. {{ number_format($row->harga, 0, ',', '.') }} </td>
                                <td> {{ $row->stok }} </td>
                                <td> {{ $row->user->nama ?? 'N/A' }} </td>
                                <td>
                                    <a href="{{ route('backend.produk.edit', $row->id) }}" title="Ubah Data">
                                        <button type="button" class="btn btn-cyan btn-sm text-white"><i class="far fa-edit"></i> Ubah</button>
                                    </a>
                                    <a href="{{ route('backend.produk.show', $row->id) }}" title="Tambah/Lihat Gambar">
                                        <button type="button" class="btn btn-warning btn-sm text-white"><i class="fas fa-plus"></i> Gambar</button>
                                    </a>

                                    <form method="POST" action="{{ route('backend.produk.destroy', $row->id) }}" 
                                          style="display: inline-block;" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                        @method('DELETE')
                                        @csrf
                                        <button type="submit" class="btn btn-danger btn-sm" title="Hapus Data">
                                            <i class="fas fa-trash"></i> Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- BAGIAN BARU: INFO ENTRIES DAN TOMBOL PREVIOUS/NEXT --}}
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <div>
                        <small class="text-muted">
                            Showing {{ $index->firstItem() ?? 0 }} to {{ $index->lastItem() ?? 0 }} of {{ $index->total() ?? 0 }} entries
                        </small>
                    </div>
                    <div>
                        {{ $index->links('pagination::bootstrap-4') }}
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection