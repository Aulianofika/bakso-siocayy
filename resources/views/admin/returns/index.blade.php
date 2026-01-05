@extends('layouts.admin')

@section('title', 'Data Retur Pelanggan')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h3 class="fw-bold text-dark mb-0">Data Retur Pelanggan</h3>
        <a href="{{ route('admin.returns.create') }}" class="btn btn-danger d-none d-sm-inline-block shadow-sm">
            <i class="bi bi-plus-lg me-1"></i> Tambah Retur
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-header border-0 bg-white py-3">
            <h6 class="m-0 fw-bold text-dark">Daftar Retur</h6>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light text-muted">
                        <tr>
                            <th class="ps-4" width="5%">ID</th>
                            <th width="15%">Referensi</th>
                            <th width="20%">Produk</th>
                            <th width="5%" class="text-center">Qty</th>
                            <th width="20%">Alasan</th>
                            <th width="10%" class="text-center">Restock</th>
                            <th width="10%">Kerugian</th>
                            <th class="text-end pe-4" width="15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($returns as $ret)
                            <tr>
                                <td class="ps-4 fw-bold text-muted">#{{ $ret->id }}</td>
                                <td>
                                    <span class="badge bg-light text-dark border">
                                        Order #{{ $ret->shipment->order->id ?? '?' }}
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="avatar-sm rounded bg-danger-subtle text-danger d-flex align-items-center justify-content-center"
                                            style="width:32px;height:32px;">
                                            <i class="bi bi-box-seam"></i>
                                        </div>
                                        <span class="fw-bold text-dark">{{ $ret->product->name ?? 'Produk Dihapus' }}</span>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <span class="fw-bold">{{ $ret->quantity }}</span>
                                </td>
                                <td>
                                    <small class="text-muted fst-italic">"{{ Str::limit($ret->reason, 40) ?? '-' }}"</small>
                                </td>
                                <td class="text-center">
                                    @if($ret->restock)
                                        <span
                                            class="badge bg-success-subtle text-success border border-success-subtle rounded-pill">Ya</span>
                                    @else
                                        <span
                                            class="badge bg-danger-subtle text-danger border border-danger-subtle rounded-pill">Tidak</span>
                                    @endif
                                </td>
                                <td class="fw-bold text-danger">
                                    Rp {{ number_format($ret->loss, 0, ',', '.') }}
                                </td>
                                <td class="text-end pe-4">
                                    <div class="btn-group gap-1">
                                        <a href="{{ route('admin.returns.show', $ret->id) }}"
                                            class="btn btn-sm btn-outline-info rounded-2" title="Detail">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.returns.edit', $ret->id) }}"
                                            class="btn btn-sm btn-outline-warning rounded-2" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('admin.returns.destroy', $ret->id) }}" method="POST"
                                            class="d-inline" onsubmit="return confirm('Hapus data retur ini?');">
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
                                <td colspan="8" class="text-center py-5 text-muted">
                                    <i class="bi bi-recycle display-4 opacity-50 mb-3 d-block"></i>
                                    Belum ada data retur.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="px-3 py-3 border-top bg-light">
                {{ $returns->links() }}
            </div>
        </div>
    </div>
@endsection