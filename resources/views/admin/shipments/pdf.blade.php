<!DOCTYPE html>
<html>

<head>
    <title>Laporan Pengiriman</title>
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
    </style>
</head>

<body>

    <h2>Laporan Pengiriman</h2>
    <div class="meta">
        Bakso Siocay - {{ date('d M Y H:i') }}
    </div>

    <table>
        <thead>
            <tr>
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
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $shipment->order->invoice_number }}</td>
                    <td>{{ $shipment->order->user->name ?? '-' }}</td>
                    <td>{{ $shipment->order->nama_penerima ?? '-' }}</td>
                    <td>{{ \Illuminate\Support\Str::limit($shipment->destination, 50) }}</td>
                    <td>{{ $shipment->courier }}</td>
                    <td>{{ $shipment->status }}</td>
                    <td>{{ $shipment->shipment_date }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>

</html>