<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #{{ $order->id }} - MyGarden</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <style>
        body { background: #ffffff; font-family: sans-serif; }
        .invoice-box { padding: 30px; max-width: 800px; margin: auto; border: 1px solid #eee; }
        @media print {
            .no-print { display: none; }
            .invoice-box { border: none; padding: 0; }
        }
    </style>
</head>
<body>

<div class="container my-4">
    <div class="text-right mb-3 no-print">
        <button onclick="window.print()" class="btn btn-success">🖨️ Cetak Nota</button>
        <button onclick="window.close()" class="btn btn-secondary">Tutup Halaman</button>
    </div>

    <div class="invoice-box">
        <div class="text-center mb-4">
            <h2 class="text-success"><strong>MyGarden</strong></h2>
            <p class="text-muted small">Tegal - Jawa Tengah | MyGarden@gmail.com</p>
            <hr>
        </div>

        <div class="row mb-4 small">
            <div class="col-6">
                <strong>DETAIL PESANAN:</strong>
                <p class="mb-0">No. Order: #{{ $order->id }}</p>
                <p class="mb-0">Tanggal: {{ $order->created_at->format('d M Y, H:i') }}</p>
                <p class="mb-0">Kurir: {{ strtoupper($order->kurir) }} ({{ $order->layanan_ongkir }})</p>
                <p class="mb-0">No. Resi: <strong>{{ $order->noresi ?? '-' }}</strong></p>
            </div>
            <div class="col-6 text-right">
                <strong>ALAMAT PENGIRIMAN:</strong>
                <p class="mb-0"><strong>{{ Auth::user()->nama }}</strong></p>
                <p class="mb-0">{!! $order->alamat !!}</p>
                <p class="mb-0">Kode Pos: {{ $order->pos }}</p>
            </div>
        </div>

        <table class="table table-bordered table-sm small">
            <thead class="thead-light">
                <tr>
                    <th>Item Produk</th>
                    <th class="text-center">Harga</th>
                    <th class="text-center">Qty</th>
                    <th class="text-right">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->orderItems as $item)
                <tr>
                    <td>{{ $item->produk->nama_produk }}</td>
                    <td class="text-center">Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                    <td class="text-center">{{ $item->quantity }}</td>
                    <td class="text-right">Rp {{ number_format($item->harga * $item->quantity, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="3" class="text-right border-0">Subtotal Produk</th>
                    <td class="text-right border-0">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <th colspan="3" class="text-right border-0">Ongkos Kirim</th>
                    <td class="text-right border-0">Rp {{ number_format($order->biaya_ongkir, 0, ',', '.') }}</td>
                </tr>
                
                    <th colspan="3" class="text-right border-0">TOTAL BAYAR</th>
                    <td class="text-right border-0">Rp {{ number_format($order->total_harga + $order->biaya_ongkir, 0, ',', '.') }}</td>
                </tr>
            </tfoot>
        </table>
        
        <div class="text-center mt-4 text-muted small">
            <p>Terima kasih telah berbelanja di MyGarden! 🌱</p>
        </div>
    </div>
</div>

<script>
    // Membuat halaman otomatis memicu pop-up printer saat dibuka
    window.onload = function() {
        window.print();
    }
</script>
</body>
</html>