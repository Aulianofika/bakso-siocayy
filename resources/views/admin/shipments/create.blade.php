@extends('layouts.admin')

@section('content')
<div class="container">
    <h2>Tambah Pengiriman</h2>

    <form action="{{ route('admin.shipments.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="order_id" class="form-label">Pesanan</label>
            <select name="order_id" class="form-select" required>
                <option value="">-- Pilih Pesanan --</option>
                @foreach($orders as $order)
                    <option value="{{ $order->id }}">#{{ $order->id }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="destination" class="form-label">Tujuan</label>
            <input type="text" name="destination" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="shipment_date" class="form-label">Tanggal Pengiriman</label>
            <input type="date" name="shipment_date" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="courier" class="form-label">Kurir</label>
            <input type="text" name="courier" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('admin.shipments.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
