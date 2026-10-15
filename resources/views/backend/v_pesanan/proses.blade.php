@extends('backend.v_layouts.app') 
@section('content') 

<div class="row">
    <div class="col-12"> 
        <div class="card mb-3 shadow-sm"> 
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0 text-dark font-weight-bold">{{ $subJudul }}</h5>
            </div>
            <div class="card-body"> 
                <div class="table-responsive"> 
                    <table id="dataTable" class="table table-bordered table-hover w-100"> 
                        <thead class="thead-light"> 
                            <tr> 
                                <th class="text-center" width="5%">No</th> 
                                <th width="10%">ID Order</th> 
                                <th width="15%">Tanggal</th> 
                                <th width="15%">Total</th> 
                                <th width="10%">Status</th> 
                                <th>Pelanggan</th> 
                                <th class="text-center" width="15%">Aksi</th> 
                            </tr> 
                        </thead> 
                        <tbody> 
                            @foreach ($index as $row) 
                            <tr> 
                                <td class="text-center">{{ $loop->iteration }}</td> 
                                <td class="font-weight-bold">#{{ $row->id }}</td> 
                                <td>{{ $row->created_at->format('d M Y H:i') }}</td> 
                                <td>Rp {{ number_format($row->total_harga + $row->biaya_ongkir, 0, ',', '.') }}</td> 
                                <td> 
                                    @if ($row->status == 'Paid') 
                                        <span class="badge badge-primary px-3 py-2">Proses</span> 
                                    @else 
                                        <span class="badge badge-warning text-white px-3 py-2">{{ $row->status }}</span> 
                                    @endif 
                                </td> 
                             <td>
    <small class="text-muted">{{ $row->customer->user->email ?? '-' }}</small>
</td>
                                <td class="text-center"> 
                                    <div class="btn-group" role="group">
                                        <!-- Tombol Detail -->
                                        <a href="{{ route('backend.pesanan.detail', $row->id) }}" class="btn btn-info btn-sm" title="Detail Order">
                                            <i class="fa fa-eye"></i> Detail
                                        </a>
                                        
                                        <!-- Tombol Cetak -->
                                        <a href="{{ route('backend.pesanan.invoice', $row->id) }}" class="btn btn-secondary btn-sm" title="Cetak Invoice" target="_blank"> 
                                            <i class="fas fa-print"></i> Cetak
                                        </a>
                                    </div>
                                </td> 
                            </tr> 
                            @endforeach 
                        </tbody> 
                    </table> 
                </div> 
            </div> 
        </div> 
    </div>
</div>

@endsection