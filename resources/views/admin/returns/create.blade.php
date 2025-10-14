@extends('layouts.admin')
@section('title', 'Tambah Retur')

@section('content')
<div class="container mt-4">
    <h2 class="mb-3 text-success fw-bold">🧾 Tambah Retur Pelanggan</h2>

    <form method="POST" action="{{ route('admin.returns.store') }}">
        @csrf

        <div class="mb-3">
            <label class="form-label">Pilih Pengiriman</label>
            <select name="shipment_id" class="form-select" required>
                <option value="">-- Pilih Pengiriman --</option>
                @foreach($shipments as $ship)
                    <option value="{{ $ship->id }}">#{{ $ship->id }} - {{ $ship->destination }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Produk Diretur</label>
            <select name="product_id" class="form-select" required>
                <option value="">-- Pilih Produk --</option>
                @foreach($products as $product)
                    <option value="{{ $product->id }}">{{ $product->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Jumlah Retur</label>
            <input type="number" name="quantity" class="form-control" required min="1">
        </div>

        <div class="mb-3">
            <label class="form-label">Alasan Retur</label>
            <textarea name="reason" class="form-control" rows="2"></textarea>
        </div>

        <div class="mb-3 form-check">
            <input type="checkbox" name="restock" class="form-check-input" id="restock" value="1">
            <label for="restock" class="form-check-label">Tambahkan ke stok?</label>
        </div>

        <button type="submit" class="btn btn-success">Simpan Retur</button>
        <a href="{{ route('admin.returns.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
