<!DOCTYPE html>
<html>

<head>
    <title>Laporan Stok Produk</title>
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

    <h2>Laporan Stok Produk</h2>
    <div class="meta">
        Bakso Siocay - {{ date('d M Y H:i') }}
    </div>

    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="25%">Nama Produk</th>
                <th width="20%">Kategori</th>
                <th width="15%">Harga Jual</th>
                <th width="15%">Harga Modal</th>
                <th width="10%">Stok</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $index => $product)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->category->name ?? '-' }}</td>
                    <td>Rp {{ number_format($product->price_sale, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($product->price_cost, 0, ',', '.') }}</td>
                    <td>{{ $product->stock }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>

</html>