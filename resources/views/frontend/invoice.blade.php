<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #{{ $order->invoice_number ?? $order->id }} - Bakso Siocayy</title>
    <style>
        @page {
            size: A4;
            margin: 0;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #333;
            line-height: 1.6;
            margin: 0;
            padding: 40px;
            background-color: #f9f9f9;
            -webkit-print-color-adjust: exact;
        }

        .invoice-container {
            max-width: 800px;
            margin: 0 auto;
            background: #fff;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            position: relative;
            overflow: hidden;
        }

        .watermark {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-30deg);
            font-size: 10rem;
            color: rgba(0, 0, 0, 0.03);
            font-weight: bold;
            z-index: 0;
            pointer-events: none;
            white-space: nowrap;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 50px;
            position: relative;
            z-index: 1;
            border-bottom: 2px solid #f0f0f0;
            padding-bottom: 20px;
        }

        .brand-section h1 {
            color: #2c3e50;
            font-size: 32px;
            font-weight: 800;
            margin: 0;
            letter-spacing: -1px;
        }

        .brand-section p {
            color: #7f8c8d;
            font-size: 14px;
            margin: 5px 0 0;
        }

        .invoice-details {
            text-align: right;
        }

        .invoice-details h2 {
            color: #e74c3c;
            /* Professional Red Accent or could be standard branding color */
            font-size: 24px;
            margin: 0 0 10px;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .invoice-meta {
            font-size: 14px;
            color: #555;
        }

        .invoice-meta span {
            display: block;
            margin-bottom: 3px;
        }

        .invoice-meta strong {
            color: #333;
            min-width: 100px;
            display: inline-block;
        }

        .client-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 40px;
            position: relative;
            z-index: 1;
        }

        .info-box h3 {
            font-size: 12px;
            text-transform: uppercase;
            color: #95a5a6;
            margin-bottom: 10px;
            letter-spacing: 1px;
            font-weight: 700;
        }

        .info-box p {
            margin: 0;
            font-size: 15px;
            font-weight: 500;
        }

        .info-box .address {
            margin-top: 5px;
            font-size: 14px;
            color: #7f8c8d;
            max-width: 300px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
            position: relative;
            z-index: 1;
        }

        th {
            background-color: #2c3e50;
            color: #fff;
            text-align: left;
            padding: 12px 15px;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        td {
            padding: 15px;
            border-bottom: 1px solid #eee;
            color: #333;
            font-size: 14px;
        }

        tr:last-child td {
            border-bottom: 2px solid #2c3e50;
        }

        tbody tr:nth-child(even) {
            background-color: #fdfdfd;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .totals-section {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 40px;
            position: relative;
            z-index: 1;
        }

        .totals-table {
            width: 300px;
            border-collapse: collapse;
        }

        .totals-table td {
            padding: 10px;
            border-bottom: 1px solid #eee;
        }

        .totals-table tr:last-child td {
            border-bottom: none;
            border-top: 2px solid #2c3e50;
            font-size: 18px;
            font-weight: 800;
            color: #2c3e50;
            padding-top: 15px;
        }

        .totals-table .label {
            color: #7f8c8d;
            font-size: 13px;
        }

        .totals-table .value {
            text-align: right;
            font-weight: 600;
        }

        .footer {
            margin-top: 50px;
            padding-top: 20px;
            border-top: 1px solid #eee;
            text-align: center;
            color: #bdc3c7;
            font-size: 12px;
            position: relative;
            z-index: 1;
        }

        .status-badge {
            display: inline-block;
            padding: 8px 15px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-top: 10px;
        }

        .status-lunas {
            background: #e8f8f5;
            color: #27ae60;
            border: 1px solid #27ae60;
        }

        .status-pending {
            background: #fef9e7;
            color: #f1c40f;
            border: 1px solid #f1c40f;
        }

        .status-unpaid {
            background: #fdebd0;
            color: #e67e22;
            border: 1px solid #e67e22;
        }

        .btn-print {
            position: fixed;
            bottom: 30px;
            right: 30px;
            background: #2c3e50;
            color: white;
            border: none;
            padding: 15px 30px;
            border-radius: 50px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s ease;
            z-index: 100;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .btn-print:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.25);
            background: #34495e;
        }

        @media print {
            body {
                background: white;
                padding: 0;
            }

            .invoice-container {
                box-shadow: none;
                padding: 40px;
                max-width: 100%;
            }

            .btn-print {
                display: none;
            }
        }
    </style>
    <!-- Add standard icons for button -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body>

    <button onclick="window.print()" class="btn-print">
        <i class="bi bi-printer"></i> Cetak Invoice
    </button>

    <div class="invoice-container">
        <!-- Watermark -->
        @if($order->status_payment == 'Lunas')
            <div class="watermark" style="color: rgba(39, 174, 96, 0.05);">PAID</div>
        @elseif($order->status_payment == 'Ditolak')
            <div class="watermark" style="color: rgba(231, 76, 60, 0.05);">VOID</div>
        @else
            <div class="watermark">UNPAID</div>
        @endif

        <div class="header">
            <div class="brand-section">
                <h1>Bakso Siocayy</h1>
                <p>Kampung Lapai, Kec. Nanggalo, Kota Padang, Sumatera Barat</p>
                <p>Chairulsalam1211@gmail.com</p>
            </div>
            <div class="invoice-details">
                <h2>INVOICE</h2>
                <div class="invoice-meta">
                    <span><strong>No. Invoice:</strong> #{{ $order->invoice_number ?? $order->id }}</span>
                    <span><strong>Tanggal:</strong> {{ $order->created_at->format('d/m/Y') }}</span>
                    <span><strong>Jatuh Tempo:</strong> {{ $order->created_at->format('d/m/Y') }}</span>

                    @if($order->status_payment == 'Lunas')
                        <div class="status-badge status-lunas">LUNAS</div>
                    @elseif($order->status_payment == 'Belum Bayar')
                        <div class="status-badge status-unpaid">BELUM BAYAR</div>
                    @else
                        <div class="status-badge status-pending">{{ strtoupper($order->status_payment) }}</div>
                    @endif
                </div>
            </div>
        </div>

        <div class="client-info">
            <div class="info-box">
                <h3>Ditagihkan Kepada</h3>
                <p>{{ $order->user->name }}</p>
                <p style="color: #7f8c8d; font-size: 14px;">{{ $order->user->email }}</p>
                @if($order->telepon)
                    <p style="color: #7f8c8d; font-size: 14px;">{{ $order->telepon }}</p>
                @endif
                <div class="address" style="margin-top: 10px;">
                    {{ $order->alamat_lengkap }}
                </div>
            </div>
            <!-- Optional: Ship To could go here -->
            <div class="info-box text-right">
                <h3>Metode Pembayaran</h3>
                <p>{{ ucfirst($order->payment_method) }}</p>
                @if($order->payment_method == 'transfer')
                    <p style="font-size: 13px; color: #7f8c8d;">Bank Transfer</p>
                @else
                    <p style="font-size: 13px; color: #7f8c8d;">Bayar di Tempat</p>
                @endif
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th width="5%">No</th>
                    <th width="50%">Deskripsi Item</th>
                    <th width="15%" class="text-center">Jumlah</th>
                    <th width="15%" class="text-right">Harga Satuan</th>
                    <th width="15%" class="text-right">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order->orderItems as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>
                            <strong>{{ $item->product->name }}</strong>
                            @if($item->product->category)
                                <div style="font-size: 12px; color: #95a5a6;">Kategori: {{ $item->product->category->name }}
                                </div>
                            @endif
                        </td>
                        <td class="text-center">{{ $item->quantity }}</td>
                        <td class="text-right">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                        <td class="text-right fw-bold">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="totals-section">
            <table class="totals-table">
                <tr>
                    <td class="label">Subtotal</td>
                    <td class="value">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                </tr>
                {{-- Add Discount or Shipping rows here if available in data --}}
                <tr>
                    <td class="label">Total Tagihan</td>
                    <td class="value" style="color: #2c3e50;">Rp {{ number_format($order->total_price, 0, ',', '.') }}
                    </td>
                </tr>
            </table>
        </div>

        <div class="footer">
            <p><strong>Terima kasih atas kepercayaan Anda!</strong></p>
            <p>Jika Anda memiliki pertanyaan mengenai invoice ini, silakan hubungi kami di Chairulsalam1211@gmail.com
            </p>
            <p>&copy; {{ date('Y') }} Siocayy. All rights reserved.</p>
        </div>
    </div>

</body>

</html>