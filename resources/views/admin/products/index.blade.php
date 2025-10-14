@extends('layouts.admin')

@section('title', 'Manajemen Produk')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="fw-bold text-primary">💜 Manajemen Produk</h2>
        <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-1"></i> Tambah Produk
        </a>
    </div>

    {{-- Pesan sukses --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Tabel Produk --}}
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr class="text-center">
                        <th>No</th>
                        <th>Nama</th>
                        <th>Kategori</th>
                        <th>Deskripsi</th>
                        <th>Harga Pokok</th>
                        <th>Harga Jual</th>
                        <th>Stok</th>
                        <th>Gambar</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $index => $product)
                        <tr class="text-center">
                            <td>{{ $index + 1 }}</td>
                            <td class="fw-semibold">{{ $product->name }}</td>
                            <td>
                                <span class="badge bg-secondary">{{ $product->category->name }}</span>
                            </td>
                            <td class="text-start" style="max-width: 220px;">
                                {{ Str::limit($product->description, 60, '...') }}
                            </td>
                            <td>Rp {{ number_format($product->price_cost, 0, ',', '.') }}</td>
                            <td class="fw-bold text-success">Rp {{ number_format($product->price_sale, 0, ',', '.') }}</td>
                            <td>
                                @if($product->stock > 10)
                                    <span class="badge bg-success">{{ $product->stock }}</span>
                                @elseif($product->stock > 0)
                                    <span class="badge bg-warning text-dark">{{ $product->stock }}</span>
                                @else
                                    <span class="badge bg-danger">Habis</span>
                                @endif
                            </td>
                            <td>
                                @if($product->image)
                                    <img src="{{ asset('images/products/'.$product->image) }}" alt="{{ $product->name }}" class="img-thumbnail" style="width: 60px; height: 60px; object-fit: cover;">
                                @else
                                    <span class="text-muted">Tidak ada</span>
                                @endif
                            </td>
                            <td>
                            <a href="{{ route('admin.products.show', $product->id) }}" class="btn btn-sm btn-outline-primary">Detail</a>
                            <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-sm btn-outline-warning">Edit</a>
                            <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus retur ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger">Hapus</button>
                            </form>
                        
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center text-muted py-4">
                                <i class="bi bi-box-seam fs-4 d-block mb-2"></i>
                                Belum ada produk yang ditambahkan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
    </div>
</div>
@endsection
