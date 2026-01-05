@extends('layouts.admin')

@section('title', 'Manajemen Produk')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h3 class="mb-0 text-gray-800 fw-bold">Manajemen Produk</h3>
        <a href="{{ route('admin.products.create') }}" class="btn btn-primary d-none d-sm-inline-block shadow-sm">
            <i class="bi bi-plus-lg me-1"></i> Tambah Produk Baru
        </a>
    </div>

    {{-- Pesan sukses --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
            <div class="d-flex align-items-center">
                <i class="bi bi-check-circle-fill me-2 fs-5"></i>
                <div>{{ session('success') }}</div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header border-0 bg-white py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Produk</h6>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light text-muted">
                        <tr>
                            <th class="ps-4" width="5%">No</th>
                            <th width="10%">Gambar</th>
                            <th width="20%">Nama Produk</th>
                            <th width="15%">Kategori</th>
                            <th width="20%">Detail Harga</th>
                            <th width="10%">Stok</th>
                            <th class="text-end pe-4" width="20%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products as $index => $product)
                            <tr>
                                <td class="ps-4">{{ $index + 1 }}</td>
                                <td>
                                    @if($product->image)
                                        <div class="rounded-3 overflow-hidden border" style="width: 60px; height: 60px;">
                                            <img src="{{ asset('images/products/' . $product->image) }}" alt="{{ $product->name }}"
                                                class="w-100 h-100" style="object-fit: cover;">
                                        </div>
                                    @else
                                        <div class="rounded-3 bg-secondary-subtle d-flex align-items-center justify-content-center text-secondary border"
                                            style="width: 60px; height: 60px;">
                                            <i class="bi bi-image fs-4"></i>
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <div class="fw-bold text-dark">{{ $product->name }}</div>
                                    <small class="text-muted d-block text-truncate" style="max-width: 200px;">
                                        {{ Str::limit($product->description, 50) }}
                                    </small>
                                </td>
                                <td>
                                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle fw-normal">
                                        {{ $product->category->name }}
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex flex-column">
                                        <small class="text-muted">Modal: Rp
                                            {{ number_format($product->price_cost, 0, ',', '.') }}</small>
                                        <span class="fw-bold text-success">Jual: Rp
                                            {{ number_format($product->price_sale, 0, ',', '.') }}</span>
                                    </div>
                                </td>
                                <td>
                                    @if($product->stock > 10)
                                        <span
                                            class="badge bg-success-subtle text-success border border-success-subtle rounded-pill">
                                            {{ $product->stock }} Tersedia
                                        </span>
                                    @elseif($product->stock > 0)
                                        <span
                                            class="badge bg-warning-subtle text-warning border border-warning-subtle rounded-pill">
                                            {{ $product->stock }} Menipis
                                        </span>
                                    @else
                                        <span class="badge bg-danger-subtle text-danger border border-danger-subtle rounded-pill">
                                            Habis
                                        </span>
                                    @endif
                                </td>
                                <td class="text-end pe-4">
                                    <div class="btn-group gap-1">
                                        <a href="{{ route('admin.products.edit', $product->id) }}"
                                            class="btn btn-sm btn-outline-primary rounded-2" title="Edit">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST"
                                            class="d-inline"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger rounded-2" title="Hapus">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5">
                                    <div class="text-muted">
                                        <i class="bi bi-box-seam display-4 opacity-50 mb-3 d-block"></i>
                                        <p class="mb-1">Belum ada produk yang ditambahkan.</p>
                                        <a href="{{ route('admin.products.create') }}"
                                            class="btn btn-link text-decoration-none">Tambah Produk Sekarang</a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection