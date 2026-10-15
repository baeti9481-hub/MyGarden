@extends('backend.v_layouts.app') 
@section('content')

<div class="row">
    <div class="col-12">
        <!-- Form diarahkan ke backend.pesanan.update dengan method PUT -->
        <form action="{{ route('backend.pesanan.update', $order->id) }}" method="post">
            @method('put')
            @csrf
            <div class="card shadow-sm">
                <div class="card-body">
                    
                    <!-- 1. Header: Judul & Tanggal -->
                    <div class="text-center mb-4">
                        <h3 class="font-weight-bold">Detail Pesanan #{{ $order->id }}</h3>
                        <p class="text-muted">Tanggal: {{ $order->created_at->format('d M Y H:i') }}</p>
                    </div>

                    <!-- 2. Baris Informasi Pelanggan & Ongkos Kirim -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h5 class="font-weight-bold border-bottom pb-2">Pelanggan</h5>
                            @if($order->customer)
                                <p class="mb-0">Nama: {{ $order->customer->user->nama ?? '-' }}</p>
                                <p class="mb-0">Email: {{ $order->customer->user->email ?? '-' }}</p>
                                <p class="mb-0">Hp: {{ $order->customer->no_hp ?? '-' }}</p>
                            @else
                                <p class="text-danger">Data pelanggan tidak ditemukan.</p>
                            @endif
                        </div>
                        <div class="col-md-6 text-right">
                            <h5 class="font-weight-bold border-bottom pb-2 text-right">Ongkos Kirim</h5>
                            <p class="mb-0 text-right">Kurir: {{ strtoupper($order->kurir ?? 'N/A') }}</p>
                            <p class="mb-0 text-right">Layanan: {{ $order->layanan_ongkir ?? '-' }}</p>
                            <p class="mb-0 text-right">Estimasi: {{ $order->estimasi_ongkir ?? '-' }} Hari</p>
                            <p class="mb-0 text-right">Berat: {{ number_format($order->total_berat ?? 0) }} Gram</p>
                        </div>
                    </div>

                    <!-- 3. Tabel Rincian Produk -->
                    <h5 class="font-weight-bold mb-3">Produk</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="thead-light text-center">
                                <tr>
                                    <th width="50%">Produk</th>
                                    <th width="15%">Harga</th>
                                    <th width="10%">Quantity</th>
                                    <th width="25%">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $totalHarga = 0; @endphp
                                @foreach($order->orderItems as $item)
                                    @php $totalHarga += $item->harga * $item->quantity; @endphp
                                    <tr>
                                        <td>
                                            <div class="media">
                                                @if($item->produk->foto)
                                                    <img src="{{ asset('storage/img-produk/'.$item->produk->foto) }}" class="mr-3 rounded shadow-sm" width="80" alt="Produk">
                                                @endif
                                                <div class="media-body">
                                                    <h6 class="mt-0 font-weight-bold">{{ $item->produk->nama_produk }} #{{ $item->produk->kategori->nama_kategori }}</h6>
                                                    <small class="text-muted d-block">• Berat: {{ $item->produk->berat }} Gram</small>
                                                    <small class="text-muted d-block">• Stok: {{ $item->produk->stok }} Gram</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center align-middle text-nowrap">Rp. {{ number_format($item->harga, 0, ',', '.') }}</td>
                                        <td class="text-center align-middle">{{ $item->quantity }}</td>
                                        <td class="text-right align-middle font-weight-bold text-nowrap">Rp. {{ number_format($item->harga * $item->quantity, 0, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="3" class="text-right border-0 font-weight-normal">Subtotal</th>
                                    <th class="text-right border-0">Rp. {{ number_format($totalHarga, 0, ',', '.') }}</th>
                                </tr>
                                <tr>
                                    <th colspan="3" class="text-right border-0 font-weight-normal">Ongkos Kirim</th>
                                    <th class="text-right border-0">Rp. {{ number_format($order->biaya_ongkir, 0, ',', '.') }}</th>
                                </tr>
                                <tr class="bg-light">
                                    <th colspan="3" class="text-right h5 font-weight-bold border-top">TOTAL BAYAR</th>
                                    <th class="text-right h5 font-weight-bold border-top">Rp. {{ number_format($totalHarga + $order->biaya_ongkir, 0, ',', '.') }}</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <hr class="my-4">

                    <!-- 4. Form Penginputan Resi, Status, Alamat, dan Kode Pos -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3 text-left">
                                <label class="font-weight-bold">No. Resi</label>
                                <input type="text" name="noresi" value="{{ old('noresi', $order->noresi) }}" class="form-control" placeholder="Masukkan Nomor Resi">
                                @error('noresi') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="form-group mb-3 text-left">
                                <label class="font-weight-bold text-left">Status</label>
                                <select name="status" class="form-control">
                                    <option value="Paid" {{ $order->status == 'Paid' ? 'selected' : '' }}>Proses</option>
                                    <option value="Kirim" {{ $order->status == 'Kirim' ? 'selected' : '' }}>Kirim</option>
                                    <option value="Selesai" {{ $order->status == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                                </select>
                                @error('status') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                        </div>
                        <div class="col-md-6 text-left">
                            <div class="form-group mb-3">
                                <label class="font-weight-bold">Alamat</label>
                                <textarea name="alamat" class="form-control" rows="3" placeholder="Masukkan Alamat Pengiriman">{{ old('alamat', $order->alamat) }}</textarea>
                                @error('alamat') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="form-group mb-3">
                                <label class="font-weight-bold">Kode Pos</label>
                                <input type="text" name="pos" value="{{ old('pos', $order->pos) }}" class="form-control" placeholder="Masukkan Kode Pos">
                                @error('pos') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 5. Footer: Tombol Aksi -->
                <div class="card-footer bg-white text-right pb-4">
                    <button type="submit" class="btn btn-primary px-5 shadow-sm mr-2">Simpan</button>
                    <a href="{{ route('backend.pesanan.proses') }}" class="btn btn-secondary px-4">Kembali</a>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection