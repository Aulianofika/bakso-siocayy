@extends('layouts.admin')

@section('content')

    <style>
        .shipment-row {
            transition: .25s ease;
            cursor: default;
        }

        .shipment-row:hover {
            background: #f8fafc;
        }

        .status-badge {
            padding: 6px 14px;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 600;
        }
    </style>

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h3 class="fw-bold text-dark mb-0">Manajemen Pengiriman</h3>
        <div class="d-flex gap-2">
            <button type="button" class="btn btn-white border shadow-sm rounded-pill fw-bold px-4 hover-scale text-dark"
                data-bs-toggle="modal" data-bs-target="#exportShipmentModal">
                <i class="bi bi-printer me-2 text-danger"></i>Cetak Laporan
            </button>
            <a href="{{ route('admin.shipments.create') }}" class="btn btn-primary rounded-pill shadow-sm fw-bold px-4">
                <i class="bi bi-plus-lg me-2"></i>Buat Pengiriman
            </a>
        </div>
    </div>

    {{-- Search --}}
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body p-3">
            <form action="{{ route('admin.shipments.index') }}" method="GET">
                <div class="input-group">
                    <span class="input-group-text bg-white border-0 ps-3">
                        <i class="bi bi-search text-muted"></i>
                    </span>
                    <input type="text" name="search" class="form-control border-0 ps-2"
                        placeholder="Cari invoice, nama penerima, atau kurir..." value="{{ request('search') }}">
                    <button type="submit" class="btn btn-primary rounded-pill px-4 fw-bold">Cari</button>
                    @if(request('search'))
                        <a href="{{ route('admin.shipments.index') }}" class="btn btn-light rounded-pill ms-2" title="Reset">
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

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-header border-0 bg-white py-3">
            <h6 class="m-0 fw-bold text-dark">Daftar Pengiriman</h6>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table align-middle table-hover mb-0">
                    <thead class="bg-light text-muted">
                        <tr>
                            <th class="ps-4" width="5%">No</th>
                            <th width="20%">Pemesan & Order</th>
                            <th width="25%">Tujuan Pengiriman</th>
                            <th width="15%" class="text-center">Kurir</th>
                            <th width="15%">Waktu</th>
                            <th class="text-end pe-4" width="20%">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($shipments as $shipment)
                            <tr class="shipment-row">
                                <td class="ps-4 text-center fw-bold text-muted">{{ $loop->iteration }}</td>
                                <td>
                                    <div class="d-flex flex-column">
                                        <span class="fw-bold text-dark">{{ $shipment->order->user->name ?? '-' }}</span>
                                        <small class="text-primary fw-bold font-monospace mt-1">Order
                                            #{{ $shipment->order->id }}</small>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex flex-column">
                                        <span
                                            class="fw-bold text-dark mb-1">{{ $shipment->order->nama_penerima ?? $shipment->order->user->name ?? '-' }}</span>
                                        <small class="text-muted text-wrap" style="line-height: 1.2;">
                                            {{ Str::limit($shipment->destination, 50) }}
                                        </small>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <span
                                        class="badge bg-white border border-secondary text-dark fw-bold px-3 py-2 rounded-3 shadow-sm">
                                        <i class="bi bi-truck me-1 text-primary"></i> {{ $shipment->courier }}
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex flex-column small">
                                        <span class="fw-bold text-dark">Kirim:
                                            {{ $shipment->shipment_date ? \Carbon\Carbon::parse($shipment->shipment_date)->translatedFormat('d M Y') : '-' }}</span>
                                        @if($shipment->dikirim_at)
                                            <span class="text-muted mt-1">
                                                Act: {{ \Carbon\Carbon::parse($shipment->dikirim_at)->format('H:i') }}
                                            </span>
                                        @endif
                                    </div>
                                </td>
                                <td class="text-end pe-4">
                                    @if($shipment->status === 'Menunggu')
                                        <div class="d-flex justify-content-end gap-2">
                                            <a href="{{ route('admin.shipments.edit', $shipment->id) }}"
                                                class="btn btn-warning btn-sm rounded-pill fw-bold shadow-sm px-3 text-white">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>
                                            <form action="{{ route('admin.shipments.send', $shipment->id) }}" method="POST">
                                                @csrf
                                                <button class="btn btn-primary btn-sm rounded-pill fw-bold shadow-sm px-3">
                                                    <i class="bi bi-send-fill me-1"></i> Kirim
                                                </button>
                                            </form>
                                        </div>
                                    @elseif($shipment->status === 'Dikirim')
                                        <form action="{{ route('admin.shipments.received', $shipment->id) }}" method="POST">
                                            @csrf
                                            <button class="btn btn-success btn-sm rounded-pill fw-bold shadow-sm px-3">
                                                <i class="bi bi-check-lg me-1"></i> Diterima
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-success small fw-bold"><i class="bi bi-check-all me-1"></i>Selesai</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">
                                    <i class="bi bi-truck display-4 opacity-50 mb-3 d-block"></i>
                                    Belum ada data pengiriman.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="px-3 py-3 border-top bg-light">
                {{ $shipments->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
    @endsection

    <!-- Export Modal -->
    <div class="modal fade" id="exportShipmentModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-4">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold">Cetak Laporan Pengiriman</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.shipments.preview') }}" target="_blank"
                            class="btn btn-outline-primary rounded-pill fw-bold py-2">
                            <i class="bi bi-eye me-2"></i>Tampilkan Preview
                        </a>
                        
                        <div class="row g-2">
                            <div class="col-6">
                                <a href="{{ route('admin.shipments.export') }}" 
                                    class="btn btn-danger rounded-pill fw-bold py-2 w-100">
                                    <i class="bi bi-file-earmark-pdf me-2"></i>Unduh PDF
                                </a>
                            </div>
                            <div class="col-6">
                                <a href="{{ route('admin.shipments.export', ['type' => 'excel']) }}" 
                                    class="btn btn-success rounded-pill fw-bold py-2 w-100">
                                    <i class="bi bi-file-earmark-excel me-2"></i>Unduh Excel
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>