<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Nota Transaksi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            padding: 4px;
            border: 1px solid #000;
            text-align: left;
        }

        .text-right {
            text-align: right;
        }
    </style>
</head>

<body>
    <h3 style="text-align: center;">Nota Kasir</h3>
    <p><strong>Tanggal:</strong>
        {{ \Carbon\Carbon::parse($penjualan->tgl_transaksi)->translatedFormat('d F Y - H:i:s') }}</p>
    <p><strong>Pembeli:</strong> {{ $penjualan->kontak_pelanggan ?? 'Umum' }}</p>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Barang</th>
                <th class="text-right">Harga Satuan</th>
                <th class="text-right">Jumlah</th>
                <th class="text-right">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($penjualan->detail as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->barang->nama_barang }}</td>
                    <td class="text-right">{{ number_format($item->harga_satuan, 0, ',', '.') }}</td>
                    <td class="text-right">{{ $item->jumlah }}</td>
                    <td class="text-right">{{ number_format($item->harga_satuan * $item->jumlah, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <p><strong>Total:</strong> Rp {{ number_format($penjualan->total_pemasukan, 0, ',', '.') }}</p>
    <p><strong>Bayar:</strong> Rp {{ number_format($penjualan->jumlah_bayar, 0, ',', '.') }}</p>
    <p><strong>Kembalian:</strong> Rp {{ number_format($penjualan->kembalian, 0, ',', '.') }}</p>
</body>

</html>
