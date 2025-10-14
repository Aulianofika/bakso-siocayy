@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4 text-purple fw-bold">💼 Daftar Pesanan</h2>

    {{-- Notifikasi sukses --}}
    @if(session('success'))
        <div class="alert alert-success shadow-sm">{{ session('success') }}</div>
    @endif

    {{-- Tombol Tambah Pesanan & Filter --}}
    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
        <a href="{{ route('admin.orders.create') }}" class="btn btn-purple">
            + Tambah Pesanan
        </a>
        <form method="GET" class="d-flex gap-2 flex-wrap">
            <select name="status_order" class="form-select w-auto">
                <option value="">-- Status Pesanan --</option>
                <option value="Pending" {{ request('status_order')=='Pending'?'selected':'' }}>Pending</option>
                <option value="Diproses" {{ request('status_order')=='Diproses'?'selected':'' }}>Diproses</option>
                <option value="Selesai" {{ request('status_order')=='Selesai'?'selected':'' }}>Selesai</option>
            </select>
            <select name="status_payment" class="form-select w-auto">
                <option value="">-- Status Pembayaran --</option>
                <option value="Belum Bayar" {{ request('status_payment')=='Belum Bayar'?'selected':'' }}>Belum Bayar</option>
                <option value="DP" {{ request('status_payment')=='DP'?'selected':'' }}>DP</option>
                <option value="Lunas" {{ request('status_payment')=='Lunas'?'selected':'' }}>Lunas</option>
            </select>
            <button type="submit" class="btn btn-outline-purple">Filter</button>
        </form>
    </div>

    {{-- Tabel Daftar Pesanan --}}
    <div class="table-responsive shadow rounded-3">
        <table class="table align-middle table-hover mb-0">
            <thead class="table-light border-bottom fw-semibold text-center">
                <tr>
                    <th>ID</th>
                    <th>Pelanggan</th>
                    <th>Total</th>
                    <th>Status Pesanan</th>
                    <th>Status Pembayaran</th>
                    <th>Dibayar</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                    <tr class="text-center">
                        <td>{{ $order->id }}</td>
                        {{-- gunakan relasi customer() --}}
                        <td>{{ $order->customer->name ?? '-' }}</td>
                        <td class="fw-semibold">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>

                        {{-- Status Pesanan --}}
                        <td>
                            @php
                                $color = match($order->status_order) {
                                    'Pending' => 'bg-warning text-dark',
                                    'Diproses' => 'bg-info text-white',
                                    'Selesai' => 'bg-success text-white',
                                    default => 'bg-secondary text-white',
                                };
                            @endphp
                            <span class="badge {{ $color }}">{{ $order->status_order }}</span>
                        </td>

                        {{-- Status Pembayaran --}}
                        <td>
                            @php
                                $payColor = match($order->status_payment) {
                                    'Belum Bayar' => 'bg-danger text-white',
                                    'DP' => 'bg-warning text-dark',
                                    'Lunas' => 'bg-success text-white',
                                    default => 'bg-secondary text-white',
                                };
                            @endphp
                            <span class="badge {{ $payColor }}">{{ $order->status_payment }}</span>
                        </td>

                        {{-- Jumlah dibayar --}}
                        <td>Rp {{ number_format($order->amount_paid, 0, ',', '.') }}</td>

                        {{-- Aksi --}}
                        <td>
                            <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-sm btn-outline-primary">Detail</a>
                            <a href="{{ route('admin.orders.edit', $order->id) }}" class="btn btn-sm btn-outline-warning">Edit</a>
                            <form action="{{ route('admin.orders.destroy', $order->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus pesanan ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">
                            <em>Belum ada pesanan.</em>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="mt-3">
        {{ $orders->links() }}
    </div>
</div>

{{-- Style tambahan --}}
<style>
    .btn-purple, .btn-outline-purple {
        background-color: #a56cc1;
        border-color: #a56cc1;
        color: white;
    }
    .btn-outline-purple:hover, .btn-purple:hover {
        background-color: #8b4ea4;
        border-color: #8b4ea4;
        color: white;
    }
    .text-purple {
        color: #8b4ea4;
    }
</style>
@endsection
