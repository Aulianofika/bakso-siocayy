@extends('layouts.admin')

@section('content')
<div class="container">
    <h2>Edit Pengiriman</h2>

    <form action="{{ route('admin.shipments.update', $shipment->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="order_id" class="form-label">Pesanan</label>
            <select name="order_id" class="form-select" required>
                @foreach($orders as $order)
                    <option value="{{ $order->id }}" {{ $shipment->order_id == $order->id ? 'selected' : '' }}>
                        #{{ $order->id }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="destination" class="form-label">Tujuan</label>
            <input type="text" name="destination" class="form-control" value="{{ $shipment->destination }}" required>
        </div>

        <div class="mb-3">
            <label for="shipment_date" class="form-label">Tanggal Pengiriman</label>
            <input type="date" name="shipment_date" class="form-control" value="{{ $shipment->shipment_date }}" required>
        </div>

        <div class="mb-3">
            <label for="courier" class="form-label">Kurir</label>
            <input type="text" name="courier" class="form-control" value="{{ $shipment->courier }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('admin.shipments.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
