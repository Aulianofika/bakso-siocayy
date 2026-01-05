<!DOCTYPE html>
<html>

<head>
    <title>Laporan Insiden Stok</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 10pt;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        h2 {
            text-align: center;
            margin-bottom: 5px;
        }

        .meta {
            text-align: center;
            font-size: 0.9em;
            color: #555;
            margin-bottom: 20px;
        }

        .text-center {
            text-align: center;
        }

        .text-end {
            text-align: right;
        }
    </style>
</head>

<body>

    <h2>Laporan Insiden Stok</h2>
    <div class="meta">
        Bakso Siocay - {{ date('d M Y H:i') }}
    </div>

    <table>
        <thead>
            <tr>
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
                    <td>{{ $incident->product->name ?? 'Produk Dihapus' }}</td>
                    <td class="text-center">{{ $incident->type }}</td>
                    <td class="text-center">{{ $incident->quantity }}</td>
                    <td class="text-end">Rp {{ number_format($incident->loss, 0, ',', '.') }}</td>
                    <td class="text-center">{{ $incident->restock ? 'Ya' : 'Tidak' }}</td>
                    <td>{{ $incident->note ?? '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>

</html>