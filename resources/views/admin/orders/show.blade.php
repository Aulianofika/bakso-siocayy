@extends('layouts.admin')

@section('content')
    <div class="container mt-4">
        <h2>Detail Pesanan #{{ $order->id }}</h2>

        <div class="card mb-4">
            <div class="card-body">
                <p><strong>Pelanggan:</strong> {{ $order->user->name ?? '-' }}</p>
                <p><strong>Total Harga:</strong> Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
                <p><strong>Status Pesanan:</strong> <span class="badge bg-info">{{ $order->status_order }}</span></p>
                @php
                    $payColor = match ($order->status_payment) {
                        'Lunas' => 'bg-success',
                        'Ditolak' => 'bg-danger',
                        'Menunggu Verifikasi' => 'bg-warning text-dark',
                        'Belum Bayar' => 'bg-warning text-dark',
                        default => 'bg-secondary'
                    };
                @endphp
                <p><strong>Status Pembayaran:</strong> <span
                        class="badge {{ $payColor }}">{{ $order->status_payment }}</span></p>

                @if($order->status_payment === 'Ditolak' && $order->rejection_note)
                    <div class="alert alert-danger mt-3 mb-0">
                        <strong>Alasan Penolakan:</strong> {{ $order->rejection_note }}
                    </div>
                @endif

                <p><strong>Jumlah Dibayar:</strong> Rp {{ number_format($order->amount_paid, 0, ',', '.') }}</p>
            </div>
        </div>



        <h4 class="mt-4">Pengiriman</h4>
        <table class="table table-bordered">
            <thead class="table-light">
                <tr>
                    <th>Ekspedisi</th>
                    <th>Tujuan</th>
                    <th>Tanggal</th>
                </tr>
            </thead>
            <tbody>
                @forelse($order->shipments as $ship)
                    <tr>
                        <td>{{ $ship->courier ?? '-' }}</td>
                        <td>{{ $ship->destination ?? '-' }}</td>
                        <td>{{ $ship->shipment_date ?? '-' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center">Belum ada data pengiriman</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

    </div>
@endsection