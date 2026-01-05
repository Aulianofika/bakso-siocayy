@extends('layouts.admin')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h3 class="fw-bold text-dark mb-0">Insiden Stok</h3>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.stock-incidents.preview') }}"
                class="btn btn-info text-white rounded-pill shadow-sm fw-bold px-4">
                <i class="bi bi-eye me-2"></i>Lihat Laporan
            </a>
            <a href="{{ route('admin.stock-incidents.create') }}"
                class="btn btn-danger d-none d-sm-inline-block shadow-sm rounded-pill fw-bold px-4">
                <i class="bi bi-plus-lg me-1"></i> Lapor Insiden
            </a>
        </div>
    </div>

    {{-- Search --}}
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body p-3">
            <form action="{{ route('admin.stock-incidents.index') }}" method="GET">
                <div class="input-group">
                    <span class="input-group-text bg-white border-0 ps-3">
                        <i class="bi bi-search text-muted"></i>
                    </span>
                    <input type="text" name="search" class="form-control border-0 ps-2"
                        placeholder="Cari jenis, catatan, atau nama produk..." value="{{ request('search') }}">
                    <button type="submit" class="btn btn-primary rounded-pill px-4 fw-bold">Cari</button>
                    @if(request('search'))
                        <a href="{{ route('admin.stock-incidents.index') }}" class="btn btn-light rounded-pill ms-2"
                            title="Reset">
                            <i class="bi bi-x-lg"></i>
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-header border-0 bg-white py-3">
            <h6 class="m-0 fw-bold text-dark">Riwayat Insiden</h6>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light text-muted">
                        <tr>
                            <th class="ps-4" width="5%">ID</th>
                            <th width="20%">Produk</th>
                            <th width="10%" class="text-center">Jenis</th>
                            <th width="10%" class="text-center">Qty</th>
                            <th width="15%">Est. Kerugian</th>
                            <th width="10%" class="text-center">Restock?</th>
                            <th width="20%">Catatan</th>
                            <th class="text-end pe-4" width="10%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($incidents as $incident)
                            <tr>
                                <td class="ps-4 fw-bold text-muted">#{{ $incident->id }}</td>
                                <td>
                                    <span class="fw-bold text-dark">{{ $incident->product->name ?? 'Produk Dihapus' }}</span>
                                </td>
                                <td class="text-center">
                                    @php
                                        $typeClass = match ($incident->type) {
                                            'Retur' => 'bg-primary-subtle text-primary border border-primary-subtle',
                                            'Reject' => 'bg-danger-subtle text-danger border border-danger-subtle',
                                            default => 'bg-secondary-subtle text-secondary border border-secondary-subtle'
                                        };
                                    @endphp
                                    <span class="badge {{ $typeClass }} rounded-pill px-3">
                                        {{ $incident->type }}
                                    </span>
                                </td>
                                <td class="text-center fw-bold">{{ $incident->quantity }}</td>
                                <td class="text-danger fw-bold">Rp {{ number_format($incident->loss, 0, ',', '.') }}</td>
                                <td class="text-center">
                                    @if($incident->restock)
                                        <i class="bi bi-check-circle-fill text-success fs-5"></i>
                                    @else
                                        <i class="bi bi-x-circle-fill text-muted fs-5"></i>
                                    @endif
                                </td>
                                <td>
                                    <small class="text-muted">{{ Str::limit($incident->note, 30) ?? '-' }}</small>
                                </td>
                                <td class="text-end pe-4">
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-light border shadow-sm rounded-circle" type="button"
                                            data-bs-toggle="dropdown">
                                            <i class="bi bi-three-dots-vertical"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end border-0 shadow">
                                            <li>
                                                <a class="dropdown-item"
                                                    href="{{ route('admin.stock-incidents.show', $incident->id) }}">
                                                    <i class="bi bi-eye me-2 text-info"></i> Detail
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item"
                                                    href="{{ route('admin.stock-incidents.edit', $incident->id) }}">
                                                    <i class="bi bi-pencil me-2 text-warning"></i> Edit
                                                </a>
                                            </li>
                                            <li>
                                                <hr class="dropdown-divider">
                                            </li>
                                            <li>
                                                <form action="{{ route('admin.stock-incidents.destroy', $incident->id) }}"
                                                    method="POST" onsubmit="return confirm('Hapus data ini?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="dropdown-item text-danger">
                                                        <i class="bi bi-trash me-2"></i> Hapus
                                                    </button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-5 text-muted">
                                    <i class="bi bi-exclamation-triangle display-4 opacity-50 mb-3 d-block"></i>
                                    Tidak ada data insiden stok.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="px-3 py-3 border-top bg-light">
                {{ $incidents->links() }}
            </div>
        </div>
    </div>
@endsection