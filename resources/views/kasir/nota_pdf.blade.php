<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Ref: {{ $kasir->invoice_kode }}</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 11px;
            margin: 20px;
        }

        h3,
        h6 {
            margin: 0;
            padding: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 6px;
            text-align: left;
        }

        .text-right {
            text-align: right;
        }

        .info {
            margin-top: 10px;
            margin-bottom: 10px;
        }
    </style>
</head>

<body>
    <h3>Toko Bangunan NOTO 19</h3>
    <h6>Bancak, Payaman, Mejobo, Kudus</h6>

    <div class="info">
        <strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($kasir->tgl_transaksi)->format('d/m/Y H:i') }}<br>
        <strong>Pembeli:</strong> {{ $kasir->pembeli ?? '-' }}
    </div>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Barang</th>
                <th>Harga</th>
                <th>Jumlah</th>
                <th>Total Item</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($detail as $i => $item)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $item->barang->nama_barang ?? '-' }}</td>
                    <td>Rp{{ number_format($item->harga_satuan, 0, ',', '.') }}</td>
                    <td>{{ $item->jumlah_beli }}</td>
                    <td>Rp{{ number_format($item->total_item, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <p class="text-right">
        <strong>Total Belanja: Rp{{ number_format($kasir->total_belanja, 0, ',', '.') }}</strong><br>
        Dibayar: Rp{{ number_format($kasir->jumlah_bayar, 0, ',', '.') }}<br>
        Kembalian: Rp{{ number_format($kasir->jumlah_kembali, 0, ',', '.') }}<br>
        Catatan: {{ $kasir->catatan ?? '-' }}
    </p>

    <p style="text-align: center; margin-top: 20px;">
        -- Terima Kasih --
    </p>
</body>

</html>
