<table>
    <thead>
        <tr>
            <th colspan="7" style="font-weight: bold; font-size: 14px; text-align: center;">Laporan Insiden Stok</th>
        </tr>
        <tr>
            <th colspan="7" style="text-align: center;">Tanggal Cetak: {{ now()->translatedFormat('d F Y') }}</th>
        </tr>
        <tr>
            <th colspan="7"></th>
        </tr>
        <tr>
            <th style="font-weight: bold; border: 1px solid #000000; background-color: #f2f2f2;">No</th>
            <th style="font-weight: bold; border: 1px solid #000000; background-color: #f2f2f2;">Tanggal</th>
            <th style="font-weight: bold; border: 1px solid #000000; background-color: #f2f2f2;">Produk</th>
            <th style="font-weight: bold; border: 1px solid #000000; background-color: #f2f2f2;">Jenis</th>
            <th style="font-weight: bold; border: 1px solid #000000; background-color: #f2f2f2;">Jumlah</th>
            <th style="font-weight: bold; border: 1px solid #000000; background-color: #f2f2f2;">Kerugian (Rp)</th>
            <th style="font-weight: bold; border: 1px solid #000000; background-color: #f2f2f2;">Restock</th>
            <th style="font-weight: bold; border: 1px solid #000000; background-color: #f2f2f2;">Catatan</th>
        </tr>
    </thead>
    <tbody>
        @forelse($incidents as $index => $incident)
            <tr>
                <td style="border: 1px solid #000000;">{{ $index + 1 }}</td>
                <td style="border: 1px solid #000000;">{{ $incident->created_at->format('d/m/Y H:i') }}</td>
                <td style="border: 1px solid #000000;">{{ $incident->product->name ?? 'Produk Dihapus' }}</td>
                <td style="border: 1px solid #000000;">{{ $incident->type }}</td>
                <td style="border: 1px solid #000000;">{{ $incident->quantity }}</td>
                <td style="border: 1px solid #000000; text-align: right;">{{ $incident->loss }}</td>
                <td style="border: 1px solid #000000;">{{ $incident->restock ? 'Ya' : 'Tidak' }}</td>
                <td style="border: 1px solid #000000;">{{ $incident->note }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="8" style="text-align: center; border: 1px solid #000000;">Tidak ada data insiden stok.</td>
            </tr>
        @endforelse
    </tbody>
</table>