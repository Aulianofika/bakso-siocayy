@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h2>Edit Pesanan #{{ $order->id }}</h2>

    <form action="{{ route('admin.orders.update', $order->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="status_order" class="form-label">Status Pesanan</label>
            <select name="status_order" class="form-select" required>
                <option value="Pending" {{ $order->status_order=='Pending'?'selected':'' }}>Pending</option>
                <option value="Diproses" {{ $order->status_order=='Diproses'?'selected':'' }}>Diproses</option>
                <option value="Selesai" {{ $order->status_order=='Selesai'?'selected':'' }}>Selesai</option>
            </select>
            @error('status_order') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label for="status_payment" class="form-label">Status Pembayaran</label>
            <select name="status_payment" class="form-select" required>
                <option value="Belum Bayar" {{ $order->status_payment=='Belum Bayar'?'selected':'' }}>Belum Bayar</option>
                <option value="DP" {{ $order->status_payment=='DP'?'selected':'' }}>DP</option>
                <option value="Lunas" {{ $order->status_payment=='Lunas'?'selected':'' }}>Lunas</option>
            </select>
            @error('status_payment') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label for="amount_paid" class="form-label">Jumlah Dibayar</label>
            <input type="number" name="amount_paid" class="form-control" value="{{ $order->amount_paid }}">
            @error('amount_paid') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <button type="submit" class="btn btn-primary">Update Pesanan</button>
        <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
