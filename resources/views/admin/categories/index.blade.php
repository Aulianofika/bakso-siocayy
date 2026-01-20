@extends('layouts.admin')

@section('title', 'Kategori Produk')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h3 class="fw-bold text-dark mb-0">Kategori Produk</h3>
        <a href="{{ route('admin.categories.create') }}" class="btn btn-primary d-none d-sm-inline-block shadow-sm">
            <i class="bi bi-plus-lg me-1"></i> Tambah Kategori
        </a>
    </div>

    {{-- Mesage Success --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
            <div class="d-flex align-items-center">
                <i class="bi bi-check-circle-fill me-2 fs-5"></i>
                <div>{{ session('success') }}</div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="card-header border-0 bg-white py-3">
            <h6 class="m-0 font-weight-bold text-dark">Daftar Kategori</h6>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light text-muted">
                        <tr>
                            <th class="ps-4" width="10%">No</th>
                            <th width="40%">Nama Kategori</th>
                            <th width="30%">Jumlah Produk</th>
                            <th class="text-end pe-4" width="20%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($categories as $index => $category)
                            <tr>
                                <td class="ps-4">{{ $index + 1 }}</td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="avatar-sm rounded bg-primary-subtle text-primary d-flex align-items-center justify-content-center"
                                            style="width:36px;height:36px;">
                                            <i class="bi bi-tag-fill"></i>
                                        </div>
                                        <span class="fw-bold text-dark">{{ $category->name }}</span>
                                    </div>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-light border rounded-pill px-3 fw-bold text-secondary"
                                        data-bs-toggle="modal" data-bs-target="#categoryModal{{ $category->id }}">
                                        {{ $category->products_count }} item <i class="bi bi-eye ms-1"></i>
                                    </button>

                                    <!-- Modal -->
                                    <div class="modal fade" id="categoryModal{{ $category->id }}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-lg">
                                            <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
                                                <div class="modal-header border-0 bg-success text-white p-4">
                                                    <div>
                                                        <h5 class="modal-title fw-bold mb-0 text-white">Produk Kategori: {{ $category->name }}</h5>
                                                        <small class="text-white-50">{{ $category->products_count }} Produk Tersedia</small>
                                                    </div>
                                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body p-0">
                                                    @if($category->products->isEmpty())
                                                        <div class="text-center py-5">
                                                            <img src="https://cdn-icons-png.flaticon.com/512/4076/4076432.png" width="80" class="mb-3 opacity-50">
                                                            <p class="text-muted fw-medium">Belum ada produk dalam kategori ini.</p>
                                                        </div>
                                                    @else
                                                        <div class="table-responsive">
                                                            <table class="table table-hover align-middle mb-0">
                                                                <thead class="bg-light">
                                                                    <tr>
                                                                        <th class="ps-4">Foto</th>
                                                                        <th>Nama Produk</th>
                                                                        <th>Stok</th>
                                                                        <th class="text-end pe-4">Status</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @foreach($category->products as $product)
                                                                        <tr>
                                                                            <td class="ps-4" width="80">
                                                                                 @if($product->image)
                                                                                    <img src="{{ asset('images/products/' . $product->image) }}" class="rounded-3 shadow-sm object-fit-cover" width="50" height="50">
                                                                                @else
                                                                                    <div class="bg-light rounded-3 d-flex align-items-center justify-content-center text-muted small" style="width: 50px; height: 50px;">
                                                                                        <i class="bi bi-image"></i>
                                                                                    </div>
                                                                                @endif
                                                                            </td>
                                                                            <td>
                                                                                <div class="fw-bold text-dark">{{ $product->name }}</div>
                                                                                <div class="small text-muted text-truncate" style="max-width: 200px;">{{ $product->description }}</div>
                                                                            </td>
                                                                            <td>{{ $product->stock }}</td>
                                                                            <td class="text-end pe-4">
                                                                                @if($product->stock > 0)
                                                                                    <span class="badge bg-success-subtle text-success rounded-pill">Tersedia</span>
                                                                                @else
                                                                                    <span class="badge bg-danger-subtle text-danger rounded-pill">Habis</span>
                                                                                @endif
                                                                            </td>
                                                                        </tr>
                                                                    @endforeach
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="modal-footer border-0 bg-light p-3">
                                                    <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">Tutup</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-end pe-4">
                                    <div class="btn-group gap-1">
                                        <a href="{{ route('admin.categories.edit', $category->id) }}"
                                            class="btn btn-sm btn-outline-warning rounded-2" title="Edit">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST"
                                            class="d-inline" onsubmit="return confirm('Hapus kategori ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger rounded-2" title="Hapus">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        @if($categories->isEmpty())
                            <tr>
                                <td colspan="4" class="text-center py-5 text-muted">
                                    Belum ada kategori dibuat
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection