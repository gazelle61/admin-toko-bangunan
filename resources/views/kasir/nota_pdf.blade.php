<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Ref: {{ $kasir->invoice_kode }}</title>
    <style>
        body {
            font-family: "Courier New", Courier, monospace;
            font-size: 12px;
            margin: 0;
            padding: 0;
        }

        .line {
            border-top: 1px solid #000;
            margin: 5px 0;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .bold {
            font-weight: bold;
        }

        .item-line {
            display: flex;
            justify-content: space-between;
        }

        .totals {
            margin-top: 5px;
        }
    </style>
</head>

<body>
    <div class="text-center bold">
        Toko Bangunan NOTO 19<br>
        Bancak, Payaman, Mejobo, Kudus
    </div>

    <div class="line"></div>

    Tanggal: {{ $kasir->tgl_transaksi }}<br>
    Pembeli: {{ $kasir->pembeli ?? '-' }}

    <div class="line"></div>

    @foreach ($detail as $i => $item)
        <div class="item-line">
            <div>
                {{ $item->barang->nama_barang ?? '-' }}<br>
                Rp{{ number_format($item->harga_satuan, 0, ',', '.') }} x {{ $item->jumlah_beli }}
            </div>
            <div>
                Rp{{ number_format($item->total_item, 0, ',', '.') }}
            </div>
        </div>
    @endforeach

    <div class="line"></div>

    <div class="totals">
        <div class="item-line">
            <div>Total Belanja</div>
            <div>Rp{{ number_format($kasir->total_belanja, 0, ',', '.') }}</div>
        </div>
        <div class="item-line">
            <div>Dibayar</div>
            <div>Rp{{ number_format($kasir->jumlah_bayar, 0, ',', '.') }}</div>
        </div>
        <div class="item-line">
            <div>Kembalian</div>
            <div>Rp{{ number_format($kasir->jumlah_kembali, 0, ',', '.') }}</div>
        </div>
        <div class="item-line">
            <div>Catatan</div>
            <div>{{ $kasir->catatan ?? '-' }}</div>
        </div>
    </div>

    <div class="line"></div>

    <div class="text-center">
        Barang yang sudah dibeli tidak dapat ditukar/dikembalikan.<br>
        -- Terima Kasih --
    </div>
</body>

</html>
