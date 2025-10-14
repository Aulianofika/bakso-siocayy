@extends('layouts.admin')

@section('title', 'Produk')

@section('content')
<div class="container mt-4">
    <h2>Produk</h2>
    <a href="{{ route('admin.products.create') }}" class="btn btn-primary mb-3">Tambah Produk</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Kategori</th>
                <th>Harga Pokok</th>
                <th>Harga Jual</th>
                <th>Stok</th>
                <th>Gambar</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $index => $product)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $product->name }}</td>
                <td>{{ $product->category->name }}</td>
                <td>Rp {{ number_format($product->price_cost, 0, ',', '.') }}</td>
                <td>Rp {{ number_format($product->price_sale, 0, ',', '.') }}</td>
                <td>{{ $product->stock }}</td>
                <td>
                    @if($product->image)
                        <img src="{{ asset('images/products/'.$product->image) }}" alt="{{ $product->name }}" width="50">
                    @else
                        -
                    @endif
                </td>
                <td>
                    <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button onclick="return confirm('Hapus produk ini?')" class="btn btn-sm btn-danger">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach 
        </tbody>
    </table>
</div>
@endsection
