@extends('layouts.admin')

@section('title', 'Tambah Produk')

@section('content')
<div class="container mt-4">
    <h2>Tambah Produk</h2>
    <a href="{{ route('admin.products.index') }}" class="btn btn-secondary mb-3">Kembali</a>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
    @endif

    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label class="form-label">Nama Produk</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Kategori</label>
            <select name="category_id" class="form-select" required>
                <option value="">-- Pilih Kategori --</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Harga Pokok</label>
            <input type="number" name="price_cost" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Harga Jual</label>
            <input type="number" name="price_sale" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Stok</label>
            <input type="number" name="stock" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Gambar Produk</label>
            <input type="file" name="image" class="form-control" accept="image/*">
        </div>

        <button class="btn btn-primary">Simpan</button>
    </form>
</div>
@endsection
