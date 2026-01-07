@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        {{-- Header Section --}}
        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center mb-4 gap-3">
            <div>
                <h3 class="fw-bold text-dark mb-1">Insiden Stok</h3>
                <p class="text-muted small mb-0">Kelola laporan barang rusak, hilang, atau retur.</p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.stock-incidents.preview') }}"
                    class="btn btn-white border shadow-sm rounded-pill fw-bold px-4 hover-scale text-dark">
                    <i class="bi bi-file-earmark-pdf me-2 text-danger"></i>Laporan PDF
                </a>
                <a href="{{ route('admin.stock-incidents.create') }}"
                    class="btn btn-primary shadow-sm rounded-pill fw-bold px-4 hover-scale">
                    <i class="bi bi-plus-lg me-2"></i> Lapor Insiden
                </a>
            </div>
        </div>

        {{-- Stats Cards (Optional Summary) --}}
        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <div class="card border-0 shadow-sm rounded-4 bg-primary-subtle h-100">
                    <div class="card-body d-flex align-items-center gap-3">
                        <div class="bg-primary text-white p-3 rounded-circle">
                            <i class="bi bi-box-seam fs-4"></i>
                        </div>
                        <div>
                            <h6 class="text-primary fw-bold mb-1">Total Insiden</h6>
                            <h4 class="mb-0 fw-bold">{{ $incidents->total() }}</h4>
                        </div>
                    </div>
                </div>
            </div>
            {{-- Add more stats here if backend supports it, for now using placeholders or just layout structure --}}
        </div>

        {{-- Content Card --}}
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <div class="card-body p-0">
                {{-- Toolbar --}}
                <div class="p-4 border-bottom bg-light bg-opacity-50">
                    <form action="{{ route('admin.stock-incidents.index') }}" method="GET">
                        <div class="input-group shadow-sm rounded-pill overflow-hidden bg-white border">
                            <span class="input-group-text bg-white border-0 ps-4">
                                <i class="bi bi-search text-muted"></i>
                            </span>
                            <input type="text" name="search" class="form-control border-0 py-2 ps-2"
                                placeholder="Cari berdasarkan produk, jenis, atau catatan..."
                                value="{{ request('search') }}">
                            <button type="submit" class="btn btn-primary px-4 fw-bold">Cari</button>
                        </div>
                    </form>
                </div>

                {{-- Table --}}
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light text-secondary text-uppercase xsmall fw-bold ls-1">
                            <tr>
                                <th class="ps-4 py-3" width="5%">No</th>
                                <th width="20%">Produk</th>
                                <th width="10%" class="text-center">Jenis</th>
                                <th width="10%" class="text-center">Jumlah</th>
                                <th width="15%">Kerugian</th>
                                <th width="10%" class="text-center">Restock</th>
                                <th width="20%">Catatan</th>
                                <th class="text-end pe-4" width="10%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="border-top-0">
                            @forelse($incidents as $incident)
                                <tr>
                                    <td class="ps-4 text-muted fw-bold">{{ $incident->id }}</td>
                                    <td>
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="bg-light rounded p-1 border">
                                                @if($incident->product)
                                                    <img src="{{ asset('images/products/' . $incident->product->image) }}"
                                                        class="rounded" width="40" height="40" style="object-fit: cover;">
                                                @else
                                                    <div class="bg-secondary rounded" style="width: 40px; height: 40px;"></div>
                                                @endif
                                            </div>
                                            <div>
                                                <h6 class="text-dark fw-bold mb-0 text-truncate" style="max-width: 150px;">
                                                    {{ $incident->product->name ?? 'Produk Dihapus' }}
                                                </h6>
                                                <small class="text-muted"
                                                    style="font-size: 0.75rem;">{{ $incident->created_at->format('d M Y') }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        @php
                                            $badges = [
                                                'Retur' => 'bg-warning-subtle text-warning border-warning-subtle',
                                                'Reject' => 'bg-danger-subtle text-danger border-danger-subtle',
                                                'Hilang' => 'bg-dark-subtle text-dark border-dark-subtle',
                                            ];
                                            $badgeClass = $badges[$incident->type] ?? 'bg-secondary-subtle text-secondary';
                                        @endphp
                                        <span class="badge {{ $badgeClass }} border px-3 py-2 rounded-pill fw-bold">
                                            {{ $incident->type }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <span
                                            class="fw-bold bg-light px-3 py-1 rounded-pill border">{{ $incident->quantity }}</span>
                                    </td>
                                    <td>
                                        <span class="text-danger fw-bold">Rp
                                            {{ number_format($incident->loss, 0, ',', '.') }}</span>
                                    </td>
                                    <td class="text-center">
                                        @if($incident->restock)
                                            <div class="badge bg-success-subtle text-success rounded-pill px-2 py-1"><i
                                                    class="bi bi-check-lg"></i> Ya</div>
                                        @else
                                            <div class="badge bg-secondary-subtle text-secondary rounded-pill px-2 py-1"><i
                                                    class="bi bi-x"></i> Tidak</div>
                                        @endif
                                    </td>
                                    <td>
                                        @if($incident->note)
                                            <span class="d-inline-block text-truncate text-muted small" style="max-width: 150px;"
                                                data-bs-toggle="tooltip" title="{{ $incident->note }}">
                                                {{ $incident->note }}
                                            </span>
                                        @else
                                            <span class="text-muted small fst-italic">-</span>
                                        @endif
                                    </td>
                                    <td class="text-end pe-4">
                                        <div class="d-flex justify-content-end gap-2">
                                            <a href="{{ route('admin.stock-incidents.edit', $incident->id) }}"
                                                class="btn btn-sm btn-white border shadow-sm rounded-circle w-32 h-32 d-flex align-items-center justify-content-center text-warning hover-scale"
                                                data-bs-toggle="tooltip" title="Edit Data">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>
                                            <form action="{{ route('admin.stock-incidents.destroy', $incident->id) }}"
                                                method="POST"
                                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');"
                                                class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="btn btn-sm btn-white border shadow-sm rounded-circle w-32 h-32 d-flex align-items-center justify-content-center text-danger hover-scale"
                                                    data-bs-toggle="tooltip" title="Hapus">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center py-5">
                                        <div class="d-flex flex-column align-items-center justify-content-center">
                                            <div class="bg-light rounded-circle p-4 mb-3">
                                                <i class="bi bi-clipboard-x text-muted opacity-50 display-4"></i>
                                            </div>
                                            <h6 class="fw-bold text-dark">Tidak ada data ditemukan</h6>
                                            <p class="text-muted small mb-0">Belum ada insiden stok yang tercatat.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if($incidents->hasPages())
                    <div class="d-flex justify-content-center border-top bg-light p-3">
                        {{ $incidents->withQueryString()->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <style>
        .w-32 {
            width: 32px;
            height: 32px;
        }

        .xsmall {
            font-size: 0.7rem;
        }

        .ls-1 {
            letter-spacing: 1px;
        }

        .hover-scale {
            transition: transform 0.2s;
        }

        .hover-scale:hover {
            transform: translateY(-2px);
        }

        .bg-danger-subtle-hover:hover {
            background-color: #ffeaea !important;
        }
    </style>
@endsection