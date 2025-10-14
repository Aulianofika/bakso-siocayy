@extends('layouts.admin')

@section('title', 'Edit Produk')

@section('content')
<div class="container mt-4">
    <h2>Edit Produk</h2>
    <a href="{{ route('admin.products.index') }}" class="btn btn-secondary mb-3">Kembali</a>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
    @endif

    <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Nama Produk</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $product->name) }}" required>
        </div>
        <div class="mb-3">
    <label for="description" class="form-label">Deskripsi Produk</label>
    <textarea name="description" id="description" class="form-control" rows="3">{{ old('description', $product->description) }}</textarea>  
        </div>

        <div class="mb-3">
            <label class="form-label">Kategori</label>
            <select name="category_id" class="form-select" required>
                <option value="">-- Pilih Kategori --</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Harga Pokok</label>
            <input type="number" name="price_cost" class="form-control" value="{{ old('price_cost', $product->price_cost) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Harga Jual</label>
            <input type="number" name="price_sale" class="form-control" value="{{ old('price_sale', $product->price_sale) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Stok</label>
            <input type="number" name="stock" class="form-control" value="{{ old('stock', $product->stock) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Gambar Produk</label>
            @if($product->image)
                <div class="mb-2">
                    <img src="{{ asset('images/products/'.$product->image) }}" width="100" alt="{{ $product->name }}">
                </div>
            @endif
            <input type="file" name="image" class="form-control" accept="image/*">
        </div>

        <button class="btn btn-primary">Update Produk</button>
    </form>
</div>
@endsection
