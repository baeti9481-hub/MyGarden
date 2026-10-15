<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice Pesanan #{{ $order->id }}</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <style>
        body { background: #white; font-family: sans-serif; }
        .invoice-box { padding: 30px; border: 1px solid #eee; background: #fff; max-width: 800px; margin: auto; }
        @media print {
            .no-print { display: none; }
            .invoice-box { border: none; padding: 0; }
        }
    </style>
</head>
<body>

<div class="container my-4">
    <div class="text-right mb-3 no-print">
        <button onclick="window.print()" class="btn btn-primary">🖨️ Cetak Invoice</button>
        <a href="{{ url()->previous() }}" class="btn btn-secondary">Kembali</a>
    </div>

    <div class="invoice-box shadow-sm">
        <div class="text-center mb-4">
            <h2><strong>MYGARDEN</strong></h2>
            <p class="text-muted">Nota Bukti Pembelian Produk</p>
            <hr>
        </div>

        <div class="row mb-4">
            <div class="col-6">
                <h5><strong>Detail Pesanan:</strong></h5>
                <p class="mb-1">No. Order: #{{ $order->id }}</p>
                <p class="mb-1">Tanggal: {{ $order->created_at->format('d M Y H:i') }}</p>
                <p class="mb-1">Status: <span class="badge badge-success">{{ $order->status }}</span></p>
                <p class="mb-1">No. Resi: {{ $order->noresi ?? '-' }}</p>
            </div>
            <div class="col-6 text-right">
                <h5><strong>Tujuan Pengiriman:</strong></h5>
                <p class="mb-1"><strong>{{ $order->customer->user->nama ?? '-' }}</strong></p>
                <p class="mb-1">{{ $order->customer->no_hp ?? '-' }}</p>
                <p class="mb-1">{!! $order->alamat !!}</p>
                <p class="mb-1">Kode Pos: {{ $order->pos ?? '-' }}</p>
            </div>
        </div>

        <table class="table table-bordered">
            <thead class="thead-light">
                <tr>
                    <th>Produk</th>
                    <th class="text-center">Harga</th>
                    <th class="text-center">Qty</th>
                    <th class="text-right">Total</th>
                </tr>
            </thead>
            <tbody>
                @php $subtotal = 0; @endphp
                @foreach($order->orderItems as $item)
                    @php $subtotal += $item->harga * $item->quantity; @endphp
                    <tr>
                        <td>{{ $item->produk->nama_produk }}</td>
                        <td class="text-center">Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                        <td class="text-center">{{ $item->quantity }}</td>
                        <td class="text-right">Rp {{ number_format($item->harga * $item->quantity, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
           
                <tr>
                    <th colspan="3" class="text-right border-0">Subtotal</th>
                    <td class="text-right border-0">Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <th colspan="3" class="text-right border-0">Ongkos Kirim ({{ strtoupper($order->kurir) }})</th>
                    <td class="text-right border-0">Rp {{ number_format($order->biaya_ongkir, 0, ',', '.') }}</td>
                </tr>
                <tr class="table-secondary">
                    <th colspan="3" class="text-right">Total Bayar</th>
                    <td class="text-right font-weight-bold">Rp {{ number_format($subtotal + $order->biaya_ongkir, 0, ',', '.') }}</td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>

<script>
    // Otomatis membuka pop-up print saat halaman dimuat
    window.onload = function() {
        window.print();
    }
</script>
</body>
</html>