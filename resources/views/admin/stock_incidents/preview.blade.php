<!DOCTYPE html>
<html>

<head>
    <title>Laporan Insiden Stok - Preview</title>
    <!-- Use Bootstrap for styling -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        body {
            background-color: #f8fafc;
            font-family: sans-serif;
        }

        .page {
            background: white;
            width: 210mm;
            min-height: 297mm;
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
        <a href="{{ route('admin.stock-incidents.index') }}" class="btn btn-secondary rounded-pill shadow-sm px-4">
            <i class="bi bi-arrow-left me-2"></i>Kembali
        </a>
        <a href="{{ route('admin.stock-incidents.export') }}"
            class="btn btn-danger rounded-pill shadow-sm px-4 fw-bold">
            <i class="bi bi-file-earmark-pdf me-2"></i>Download PDF
        </a>
        <button onclick="window.print()" class="btn btn-primary rounded-pill shadow-sm px-4 fw-bold">
            <i class="bi bi-printer me-2"></i>Cetak
        </button>
    </div>

    <div class="page">
        <h2 class="text-center fw-bold text-dark mb-1">Laporan Insiden Stok</h2>
        <p class="text-center text-muted mb-4">Bakso Siocay - {{ date('d M Y H:i') }}</p>

        <table class="table table-bordered align-middle">
            <thead class="table-light">
                <tr class="text-center">
                    <th width="5%">No</th>
                    <th width="25%">Produk</th>
                    <th width="10%">Jenis</th>
                    <th width="10%">Qty</th>
                    <th width="15%">Kerugian</th>
                    <th width="10%">Restock</th>
                    <th width="25%">Catatan</th>
                </tr>
            </thead>
            <tbody>
                @foreach($incidents as $index => $incident)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td class="fw-bold">{{ $incident->product->name ?? 'Produk Dihapus' }}</td>
                        <td class="text-center">
                            <span class="badge border bg-light text-dark">{{ $incident->type }}</span>
                        </td>
                        <td class="text-center fw-bold">{{ $incident->quantity }}</td>
                        <td class="text-end text-danger">Rp {{ number_format($incident->loss, 0, ',', '.') }}</td>
                        <td class="text-center">
                            @if($incident->restock)
                                <i class="bi bi-check-lg text-success"></i>
                            @else
                                <i class="bi bi-x-lg text-secondary"></i>
                            @endif
                        </td>
                        <td>{{ $incident->note ?? '-' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</body>

</html>