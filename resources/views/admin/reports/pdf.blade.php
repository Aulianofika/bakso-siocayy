<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>{{ $title }}</title>
    <style>
        body {
            font-family: sans-serif;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .header h1 {
            margin: 0;
            font-size: 24px;
            color: #333;
        }

        .header p {
            margin: 5px 0 0;
            color: #666;
            font-size: 14px;
        }

        .meta {
            margin-bottom: 20px;
            border-bottom: 2px solid #eee;
            padding-bottom: 10px;
        }

        .meta table {
            width: 100%;
        }

        .meta td {
            vertical-align: bottom;
        }

        .meta .period {
            font-size: 18px;
            font-weight: bold;
            color: #16a34a;
        }

        table.data {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            font-size: 12px;
        }

        table.data th,
        table.data td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        table.data th {
            background-color: #f8f9fa;
            font-weight: bold;
            color: #555;
            text-transform: uppercase;
        }

        table.data td.num {
            text-align: right;
        }

        .total {
            text-align: right;
            margin-top: 20px;
            font-size: 16px;
            font-weight: bold;
        }

        .total span {
            color: #16a34a;
            font-size: 20px;
            margin-left: 10px;
        }

        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            font-size: 10px;
            color: #aaa;
            text-align: center;
            border-top: 1px solid #eee;
            padding-top: 10px;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>Bakso Siocay</h1>
        <p>Laporan Pendapatan Penjualan</p>
    </div>

    <div class="meta">
        <table>
            <tr>
                <td>
                    <div style="font-size: 12px; color: #888; margin-bottom: 4px;">Periode Laporan</div>
                    <div class="period">{{ $period }}</div>
                </td>
                <td style="text-align: right;">
                    <div style="font-size: 12px; color: #888;">Tanggal Cetak</div>
                    <div>{{ now()->format('d/m/Y H:i') }}</div>
                </td>
            </tr>
        </table>
    </div>

    <table class="data">
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Invoice</th>
                <th>Pelanggan</th>
                <th>Produk</th>
                <th class="num">Total (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @forelse($orders as $index => $order)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                    <td>#{{ $order->invoice_number }}</td>
                    <td>{{ $order->nama_penerima ?? $order->user->name }}</td>
                    <td>
                        @foreach($order->orderItems as $item)
                            <div>{{ $item->product->name }} ({{ $item->quantity }}x)</div>
                        @endforeach
                    </td>
                    <td class="num">{{ number_format($order->total_price, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align: center;">Tidak ada data penjualan untuk periode ini.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="total">
        Total Pendapatan: <span>Rp {{ number_format($totalRevenue, 0, ',', '.') }}</span>
    </div>

    <div class="footer">
        Dicetak oleh Sistem Admin Bakso Siocay
    </div>
</body>

</html>