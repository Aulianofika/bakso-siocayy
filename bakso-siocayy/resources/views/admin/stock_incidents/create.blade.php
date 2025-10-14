@extends('layouts.admin')

@section('content')
<div class="container">
    <h2>Tambah Insiden Stok</h2>

    <form action="{{ route('admin.stock-incidents.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="product_id" class="form-label">Produk</label>
            <select name="product_id" class="form-select" required>
                <option value="">-- Pilih Produk --</option>
                @foreach($products as $product)
                    <option value="{{ $product->id }}">{{ $product->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="type" class="form-label">Jenis Insiden</label>
            <select name="type" class="form-select" required>
                <option value="Retur">Retur</option>
                <option value="Reject">Reject</option>
                <option value="Hilang">Hilang</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="quantity" class="form-label">Jumlah</label>
            <input type="number" name="quantity" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="loss" class="form-label">Kerugian (Rp)</label>
            <input type="number" name="loss" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">Restock?</label>
            <select name="restock" class="form-select">
                <option value="0">Tidak</option>
                <option value="1">Ya</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="note" class="form-label">Catatan</label>
            <textarea name="note" class="form-control"></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('admin.stock-incidents.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
