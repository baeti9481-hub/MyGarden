<style>
    table {
        border-collapse: collapse;
        width: 100%;
        border: 1px solid #ccc;
    }

    table tr td {
        padding: 6px;
        font-weight: normal;
        border: 1px solid #ccc;
    }

    table th {
        border: 1px solid #ccc;
        padding: 6px;
    }
</style>

<table>
    <tr>
        <td align="left">
            Perihal : {{ $judul }} <br>
            Tanggal Awal : {{ $tanggalAwal }} 
            s/d 
            Tanggal Akhir : {{ $tanggalAkhir }}
        </td>
    </tr>
</table>

<p></p>

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>ID Order</th>
            <th>Tanggal</th>
            <th>Pelanggan</th>
            <th>Status</th>
            <th>Total</th>
        </tr>
    </thead>

    <tbody>

        @foreach ($cetak as $row)

        <tr>

            <td>
                {{ $loop->iteration }}
            </td>

            <td>
                #{{ $row->id }}
            </td>

            <td>
                {{ date('d-m-Y', strtotime($row->created_at)) }}
            </td>

            <td>
                {{ $row->customer->email ?? '-' }}
            </td>

            <td>
                {{ $row->status }}
            </td>

            <td>
                Rp. {{ number_format($row->total_harga + $row->biaya_ongkir, 0, ',', '.') }}
            </td>

        </tr>

        @endforeach

    </tbody>
</table>

<script>
    window.onload = function() {
        printStruk();
    }

    function printStruk() {
        window.print();
    }
</script>