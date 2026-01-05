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
                                    <span class="badge bg-secondary-subtle text-secondary rounded-pill px-3">
                                        {{ $category->products_count }} item
                                    </span>
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