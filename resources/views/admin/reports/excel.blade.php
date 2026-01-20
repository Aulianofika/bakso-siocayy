<table>
    <thead>
        <tr>
            <th colspan="6" style="font-weight: bold; font-size: 14px; text-align: center;">{{ $title }}</th>
        </tr>
        <tr>
            <th colspan="6" style="text-align: center;">Periode: {{ $period }}</th>
        </tr>
        <tr>
            <th colspan="6"></th>
        </tr>
        <tr>
            <th style="font-weight: bold; border: 1px solid #000000; background-color: #f2f2f2;">No</th>
            <th style="font-weight: bold; border: 1px solid #000000; background-color: #f2f2f2;">Tanggal</th>
            <th style="font-weight: bold; border: 1px solid #000000; background-color: #f2f2f2;">Invoice</th>
            <th style="font-weight: bold; border: 1px solid #000000; background-color: #f2f2f2;">Pelanggan</th>
            <th style="font-weight: bold; border: 1px solid #000000; background-color: #f2f2f2;">Produk</th>
            <th style="font-weight: bold; border: 1px solid #000000; background-color: #f2f2f2;">Total (Rp)</th>
        </tr>
    </thead>
    <tbody>
        @forelse($orders as $index => $order)
            <tr>
                <td style="border: 1px solid #000000;">{{ $index + 1 }}</td>
                <td style="border: 1px solid #000000;">{{ $order->created_at->format('d/m/Y H:i') }}</td>
                <td style="border: 1px solid #000000; text-align: left;">#{{ $order->invoice_number }}</td>
                <td style="border: 1px solid #000000;">{{ $order->nama_penerima ?? $order->user->name }}</td>
                <td style="border: 1px solid #000000;">
                    @foreach($order->orderItems as $item)
                        <div>{{ $item->product->name }} ({{ $item->quantity }}x)</div>
                    @endforeach
                </td>
                <td style="border: 1px solid #000000; text-align: right;">{{ $order->total_price }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="6" style="text-align: center; border: 1px solid #000000;">Tidak ada data penjualan.</td>
            </tr>
        @endforelse
    </tbody>
    <tfoot>
        <tr>
            <td colspan="5" style="text-align: right; font-weight: bold; border: 1px solid #000000;">Total Pendapatan:
            </td>
            <td style="font-weight: bold; border: 1px solid #000000; text-align: right;">{{ $totalRevenue }}</td>
        </tr>
    </tfoot>
</table>