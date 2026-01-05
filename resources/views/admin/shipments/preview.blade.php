<!DOCTYPE html>
<html>

<head>
    <title>Laporan Pengiriman - Preview</title>
    <!-- Use Bootstrap for styling just like the admin panel -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        body {
            background-color: #f8fafc;
            font-family: sans-serif;
        }

        .page {
            background: white;
            width: 297mm;
            min-height: 210mm;
            margin: 30px auto;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        @media print {
            .no-print {
                display: none !important;
            }

            .page {
                box-shadow: none;
                margin: 0;
                width: 100%;
            }
        }
    </style>
</head>

<body class="py-4">

    <div class="container d-flex justify-content-center mb-3 no-print gap-2">
        <a href="{{ route('admin.shipments.index') }}" class="btn btn-secondary rounded-pill shadow-sm px-4">
            <i class="bi bi-arrow-left me-2"></i>Kembali
        </a>
        <a href="{{ route('admin.shipments.export') }}" class="btn btn-danger rounded-pill shadow-sm px-4 fw-bold">
            <i class="bi bi-file-earmark-pdf me-2"></i>Download PDF
        </a>
        <button onclick="window.print()" class="btn btn-primary rounded-pill shadow-sm px-4 fw-bold">
            <i class="bi bi-printer me-2"></i>Cetak
        </button>
    </div>

    <div class="page">
        <h2 class="text-center fw-bold text-dark mb-1">Laporan Pengiriman</h2>
        <p class="text-center text-muted mb-4">Bakso Siocay - {{ date('d M Y H:i') }}</p>

        <table class="table table-bordered align-middle">
            <thead class="table-light">
                <tr class="text-center">
                    <th width="5%">No</th>
                    <th width="15%">Invoice</th>
                    <th width="15%">Nama Pemesan</th>
                    <th width="15%">Penerima</th>
                    <th width="20%">Tujuan</th>
                    <th width="10%">Kurir</th>
                    <th width="10%">Status</th>
                    <th width="10%">Tanggal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($shipments as $index => $shipment)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td class="text-center fw-bold">{{ $shipment->order->invoice_number }}</td>
                        <td>{{ $shipment->order->user->name ?? '-' }}</td>
                        <td>{{ $shipment->order->nama_penerima ?? '-' }}</td>
                        <td>{{ \Illuminate\Support\Str::limit($shipment->destination, 50) }}</td>
                        <td class="text-center">{{ $shipment->courier }}</td>
                        <td class="text-center">
                            <span class="badge bg-light text-dark border">{{ $shipment->status }}</span>
                        </td>
                        <td class="text-center">{{ $shipment->shipment_date }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</body>

</html>