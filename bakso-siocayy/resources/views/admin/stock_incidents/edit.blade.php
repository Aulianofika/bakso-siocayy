@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>Edit Insiden Stok</h1>

    <form action="{{ route('admin.stock-incidents.update', $stockIncident->id) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- Produk --}}
        <div class="mb-3">
            <label for="product_id" class="form-label">Produk</label>
            <select name="product_id" id="product_id" class="form-control" required>
                @foreach($products as $product)
                    <option value="{{ $product->id }}" 
                        {{ $stockIncident->product_id == $product->id ? 'selected' : '' }}>
                        {{ $product->name }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Jenis --}}
        <div class="mb-3">
            <label for="type" class="form-label">Jenis Insiden</label>
            <select name="type" id="type" class="form-control" required>
                <option value="Retur" {{ $stockIncident->type == 'Retur' ? 'selected' : '' }}>Retur</option>
                <option value="Reject" {{ $stockIncident->type == 'Reject' ? 'selected' : '' }}>Reject</option>
                <option value="Hilang" {{ $stockIncident->type == 'Hilang' ? 'selected' : '' }}>Hilang</option>
            </select>
        </div>

        {{-- Jumlah --}}
        <div class="mb-3">
            <label for="quantity" class="form-label">Jumlah</label>
            <input type="number" name="quantity" id="quantity" class="form-control" 
                   value="{{ $stockIncident->quantity }}" required>
        </div>

        {{-- Kerugian --}}
        <div class="mb-3">
            <label for="loss" class="form-label">Kerugian (Rp)</label>
            <input type="number" name="loss" id="loss" class="form-control" 
                   value="{{ $stockIncident->loss }}" required>
        </div>

        {{-- Restock --}}
        <div class="mb-3">
            <label for="restock" class="form-label">Apakah Direstock?</label>
            <select name="restock" id="restock" class="form-control" required>
                <option value="1" {{ $stockIncident->restock ? 'selected' : '' }}>Ya</option>
                <option value="0" {{ !$stockIncident->restock ? 'selected' : '' }}>Tidak</option>
            </select>
        </div>

        {{-- Catatan --}}
        <div class="mb-3">
            <label for="note" class="form-label">Catatan</label>
            <textarea name="note" id="note" class="form-control" rows="3">{{ $stockIncident->note }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('admin.stock-incidents.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
