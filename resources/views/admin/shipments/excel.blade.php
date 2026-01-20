<table>
    <thead>
        <tr>
            <th colspan="7" style="font-weight: bold; font-size: 14px; text-align: center;">Laporan Pengiriman</th>
        </tr>
        <tr>
            <th colspan="7" style="text-align: center;">Tanggal Cetak: {{ now()->translatedFormat('d F Y') }}</th>
        </tr>
        <tr>
            <th colspan="7"></th>
        </tr>
        <tr>
            <th style="font-weight: bold; border: 1px solid #000000; background-color: #f2f2f2;">No</th>
            <th style="font-weight: bold; border: 1px solid #000000; background-color: #f2f2f2;">Tanggal Kirim</th>
            <th style="font-weight: bold; border: 1px solid #000000; background-color: #f2f2f2;">Invoice</th>
            <th style="font-weight: bold; border: 1px solid #000000; background-color: #f2f2f2;">Penerima</th>
            <th style="font-weight: bold; border: 1px solid #000000; background-color: #f2f2f2;">Tujuan</th>
            <th style="font-weight: bold; border: 1px solid #000000; background-color: #f2f2f2;">Kurir</th>
            <th style="font-weight: bold; border: 1px solid #000000; background-color: #f2f2f2;">Status</th>
        </tr>
    </thead>
    <tbody>
        @forelse($shipments as $index => $shipment)
            <tr>
                <td style="border: 1px solid #000000;">{{ $index + 1 }}</td>
                <td style="border: 1px solid #000000;">
                    {{ $shipment->shipment_date ? \Carbon\Carbon::parse($shipment->shipment_date)->translatedFormat('d M Y') : '-' }}
                </td>
                <td style="border: 1px solid #000000; text-align: left;">{{ $shipment->order->invoice_number ?? '-' }}</td>
                <td style="border: 1px solid #000000;">
                    {{ $shipment->order->nama_penerima ?? $shipment->order->user->name ?? '-' }}</td>
                <td style="border: 1px solid #000000;">{{ $shipment->destination }}</td>
                <td style="border: 1px solid #000000;">{{ $shipment->courier }}</td>
                <td style="border: 1px solid #000000;">{{ $shipment->status }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="7" style="text-align: center; border: 1px solid #000000;">Tidak ada data pengiriman.</td>
            </tr>
        @endforelse
    </tbody>
</table>