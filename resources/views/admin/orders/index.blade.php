@extends('layouts.admin')

@section('title', 'Manajemen Pesanan')

@section('content')
<div class="container-fluid">
    {{-- Alerts --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm rounded-4 mb-4 mt-3" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show shadow-sm rounded-4 mb-4 mt-3" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-5 mt-3">
        <div>
            <h4 class="fw-bold text-dark mb-1">Manajemen Pesanan</h4>
            <span class="text-muted small">Kelola dan pantau semua pesanan masuk.</span>
        </div>
        <button class="btn btn-outline-dark rounded-pill px-4 shadow-sm" type="button" data-bs-toggle="collapse"
            data-bs-target="#filterPanel">
            <i class="bi bi-sliders me-2"></i> Filter Data
        </button>
    </div>

    {{-- FILTER PANEL --}}
    <div class="collapse show" id="filterPanel">
        <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-body p-4">
                <form method="GET">
                    <div class="row g-3 align-items-end">
                        <div class="col-md-4">
                            <label class="form-label small fw-bold text-uppercase text-muted ls-1">Status Pesanan</label>
                            <select name="status_order" class="form-select border-0 bg-light rounded-3 py-2 px-3 fw-semibold">
                                <option value="">Semua Status</option>
                                @foreach(['Pending', 'Diproses', 'Siap Dikirim', 'Selesai', 'Ditolak'] as $st)
                                    <option value="{{ $st }}" {{ request('status_order') == $st ? 'selected' : '' }}>{{ $st }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-bold text-uppercase text-muted ls-1">Metode Bayar</label>
                            <select name="payment_method" class="form-select border-0 bg-light rounded-3 py-2 px-3 fw-semibold">
                                <option value="">Semua Metode</option>
                                <option value="cash" {{ request('payment_method') == 'cash' ? 'selected' : '' }}>Cash (Tunai)</option>
                                <option value="transfer" {{ request('payment_method') == 'transfer' ? 'selected' : '' }}>Transfer Bank</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <button class="btn btn-primary w-100 rounded-pill fw-bold shadow-sm py-2">
                                <i class="bi bi-search me-2"></i> Terapkan Filter
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- ORDER TABLE --}}
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4 py-3 text-uppercase xsmall fw-bold text-muted ls-1" width="5%">No</th>
                            <th class="py-3 text-uppercase xsmall fw-bold text-muted ls-1" width="20%">Invoice / Pelanggan</th>
                            <th class="py-3 text-uppercase xsmall fw-bold text-muted ls-1" width="15%">Total</th>
                            <th class="py-3 text-center text-uppercase xsmall fw-bold text-muted ls-1" width="10%">Metode</th>
                            <th class="py-3 text-center text-uppercase xsmall fw-bold text-muted ls-1" width="20%">Status</th>
                            <th class="py-3 text-center text-uppercase xsmall fw-bold text-muted ls-1" width="15%">Pembayaran</th>
                            <th class="py-3 text-end pe-4 text-uppercase xsmall fw-bold text-muted ls-1" width="15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                            @php
                                $statusClass = match ($order->status_order) {
                                    'Pending' => 'bg-warning-subtle text-warning border border-warning-subtle',
                                    'Diproses' => 'bg-primary-subtle text-primary border border-primary-subtle',
                                    'Siap Dikirim' => 'bg-info-subtle text-info border border-info-subtle',
                                    'Selesai' => 'bg-success-subtle text-success border border-success-subtle',
                                    'Ditolak' => 'bg-danger-subtle text-danger border border-danger-subtle',
                                    default => 'bg-secondary-subtle text-secondary'
                                };


                                $paymentStatusClass = match ($order->status_payment) {
                                    'Lunas' => 'bg-success text-white',
                                    'Ditolak' => 'bg-danger text-white',
                                    'Menunggu Verifikasi' => 'bg-warning text-dark',
                                    'Belum Bayar' => 'bg-warning text-dark',
                                    default => 'bg-secondary text-white'
                                };
                            @endphp
                            <tr>
                                <td class="ps-4 fw-bold text-muted small">{{ $loop->iteration }}</td>
                                <td>
                                    <div class="d-flex flex-column">
                                        <span class="fw-bold text-dark font-monospace text-primary hover-underline" style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#detailModal{{ $order->id }}">
                                            #{{ $order->invoice_number ?? $order->id }}
                                        </span>
                                        <div class="d-flex align-items-center gap-1 mt-1">
                                            <i class="bi bi-person-circle text-muted small"></i>
                                            <small class="text-secondary fw-semibold">{{ $order->user->name ?? 'Guest' }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="fw-bolder text-dark">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-light text-dark border fw-normal px-3 py-2 rounded-pill shadow-sm">
                                        {{ ucfirst($order->payment_method) }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <select name="status_order"
                                            class="form-select form-select-sm border-0 shadow-sm fw-bold {{ $statusClass }} text-center rounded-pill py-1 ps-3 pe-4"
                                            onchange="this.form.submit()" style="cursor: pointer; font-size: 0.85rem;">
                                            @foreach(['Pending', 'Diproses', 'Siap Dikirim', 'Selesai', 'Ditolak'] as $status)
                                                <option value="{{ $status }}" {{ $order->status_order === $status ? 'selected' : '' }}
                                                    class="bg-white text-dark">
                                                    {{ $status }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </form>
                                </td>
                                <td class="text-center">
                                    <span class="badge {{ $paymentStatusClass }} rounded-pill px-3 py-1 fw-normal shadow-sm">
                                        {{ $order->status_payment }}
                                    </span>
                                </td>
                                <td class="text-end pe-4">
                                    <div class="d-flex gap-2 justify-content-end">
                                        <button class="btn btn-sm btn-light border shadow-sm rounded-circle w-32 h-32 d-flex align-items-center justify-content-center text-primary hover-scale" 
                                            data-bs-toggle="modal"
                                            data-bs-target="#detailModal{{ $order->id }}" title="Lihat Detail">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                        <form action="{{ route('admin.orders.destroy', $order->id) }}" method="POST"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus pesanan ini?');" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-light border shadow-sm rounded-circle w-32 h-32 d-flex align-items-center justify-content-center text-danger hover-scale"
                                                title="Hapus Pesanan">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>

                            {{-- DETAIL MODAL --}}
                            <div class="modal fade" id="detailModal{{ $order->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-xl modal-dialog-centered">
                                    <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
                                        <div class="modal-header bg-light border-bottom-0 py-3 px-4">
                                            <h5 class="modal-title fw-bold">
                                                <i class="bi bi-receipt me-2 text-primary"></i>Detail Pesanan
                                                <span class="font-monospace text-muted ms-2">#{{ $order->invoice_number ?? $order->id }}</span>
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body bg-white p-0">
                                            <div class="row g-0">
                                                {{-- Order Items (Left) --}}
                                                <div class="col-lg-7 border-end p-4">
                                                    <h6 class="fw-bold text-uppercase text-muted mb-3 xsmall ls-1">Item Dipesan</h6>
                                                    <div class="d-flex flex-column gap-3">
                                                        @foreach ($order->orderItems as $item)
                                                            <div class="d-flex align-items-center gap-3 p-3 rounded-4 bg-light bg-opacity-50 border border-light">
                                                                <div class="bg-white rounded-3 p-1 border shadow-sm text-center flex-shrink-0" style="width:60px;height:60px;">
                                                                    @if($item->product->image)
                                                                        <img src="{{ asset('images/products/'.$item->product->image) }}" class="w-100 h-100 object-fit-cover rounded-2" alt="{{ $item->product->name }}">
                                                                    @else
                                                                        <div class="d-flex align-items-center justify-content-center h-100 text-secondary opacity-50">
                                                                            <i class="bi bi-image fs-4"></i>
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                                <div class="flex-grow-1">
                                                                    <h6 class="fw-bold mb-1 text-dark">{{ $item->product->name }}</h6>
                                                                    <div class="small text-muted">
                                                                        <span class="badge bg-white border text-dark fw-normal me-1">{{ $item->quantity }}x</span>
                                                                        @ Rp {{ number_format($item->price, 0, ',', '.') }}
                                                                    </div>
                                                                </div>
                                                                <div class="text-end fw-bold text-dark">
                                                                    Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>

                                                    <div class="mt-4 pt-4 border-top border-dashed">
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <div>
                                                                <span class="text-muted small fw-bold text-uppercase ls-1">Total Pembayaran</span>
                                                                <div class="text-muted xsmall">{{ count($order->orderItems) }} Item</div>
                                                            </div>
                                                            <span class="display-6 fw-bold text-primary">
                                                                Rp {{ number_format($order->total_price, 0, ',', '.') }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>

                                                {{-- Payment & Status (Right) --}}
                                                <div class="col-lg-5 p-4 bg-light bg-opacity-25">
                                                    {{-- Customer Info --}}
                                                    <div class="mb-4">
                                                        <h6 class="fw-bold text-dark mb-3 xsmall opacity-75 text-uppercase ls-1">Informasi Pengiriman</h6>
                                                        <div class="card border-0 shadow-sm rounded-4">
                                                            <div class="card-body p-3">
                                                                <div class="d-flex align-items-start gap-3">
                                                                    <div class="rounded-circle bg-primary-subtle text-primary d-flex align-items-center justify-content-center flex-shrink-0" style="width: 40px; height: 40px;">
                                                                        <i class="bi bi-person-fill fs-5"></i>
                                                                    </div>
                                                                    <div>
                                                                        <h5 class="fw-bold text-dark mb-1">{{ $order->nama_penerima ?? $order->user->name }}</h5>
                                                                        <div class="text-muted fs-6 mb-1"><i class="bi bi-telephone me-1"></i> {{ $order->telepon ?? '-' }}</div>
                                                                        <div class="text-muted fs-6 mb-2 text-break"><i class="bi bi-geo-alt me-1"></i> {{ $order->alamat_lengkap ?? 'Alamat tidak tersedia' }}</div>
                                                                        @if($order->catatan)
                                                                            <div class="alert alert-warning border-0 py-2 px-3 rounded-3 mb-0 d-inline-block">
                                                                                <i class="bi bi-sticky-fill me-1"></i> <strong>Catatan:</strong> {{ $order->catatan }}
                                                                            </div>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    {{-- Payment Info --}}
                                                    <div class="mb-4">
                                                        <h6 class="fw-bold text-dark mb-3 xsmall opacity-75 text-uppercase ls-1">Metode Pembayaran</h6>
                                                        <div class="card border-0 shadow-sm rounded-4">
                                                            <div class="card-body p-3">
                                                                @if($order->payment_method == 'cash')
                                                                    <div class="d-flex align-items-center gap-3">
                                                                        <div class="bg-success-subtle text-success rounded-circle p-2">
                                                                            <i class="bi bi-cash-stack fs-4"></i>
                                                                        </div>
                                                                        <div>
                                                                            <h6 class="fw-bold mb-0 text-dark">Tunai (Cash)</h6>
                                                                            <small class="text-muted">Bayar ditempat</small>
                                                                        </div>
                                                                    </div>
                                                                @elseif($order->bukti_transfer)
                                                                    <div class="mb-2">
                                                                        <img src="{{ asset('storage/' . $order->bukti_transfer) }}"
                                                                            class="img-fluid rounded-3 border bg-light w-100"
                                                                            style="max-height: 200px; object-fit: contain;">
                                                                    </div>
                                                                    <a href="{{ asset('storage/' . $order->bukti_transfer) }}"
                                                                        target="_blank" class="btn btn-outline-primary btn-sm w-100 rounded-pill fw-bold">
                                                                        <i class="bi bi-zoom-in me-2"></i>Lihat Bukti Full
                                                                    </a>
                                                                @else
                                                                    <div class="text-center text-muted py-3">
                                                                        <i class="bi bi-image-alt fs-1 opacity-25"></i>
                                                                        <p class="small mb-0 mt-2">Belum ada bukti transfer.</p>
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>

                                                    {{-- Payment Status Actions --}}
                                                    <div>
                                                        <h6 class="fw-bold text-dark mb-3 xsmall opacity-75 text-uppercase ls-1">Verifikasi Pembayaran</h6>
                                                        <div class="card border-0 shadow-sm rounded-4 bg-white">
                                                            <div class="card-body p-3 text-center">
                                                                @if($order->status_payment === 'Lunas')
                                                                    <div class="text-success fw-bold">
                                                                        <i class="bi bi-check-circle-fill fs-3 d-block mb-2"></i>
                                                                        Pembayaran Lunas / Terverifikasi
                                                                    </div>
                                                                @elseif($order->status_payment === 'Ditolak')
                                                                     <div class="text-danger fw-bold">
                                                                        <i class="bi bi-x-circle-fill fs-3 d-block mb-2"></i>
                                                                        Pembayaran Ditolak
                                                                    </div>
                                                                    @if($order->rejection_note)
                                                                        <div class="alert alert-danger py-2 mt-2 mb-0 small text-start">
                                                                            <strong>Alasan:</strong> {{ $order->rejection_note }}
                                                                        </div>
                                                                    @endif
                                                                @else
                                                                    {{-- Tombol Aksi --}}
                                                                    <div class="d-grid gap-2">
                                                                        {{-- VERIFIKASI (Terima) --}}
                                                                        <form action="{{ route('admin.orders.updatePayment', $order->id) }}" method="POST">
                                                                            @csrf
                                                                            @method('PATCH')
                                                                            <input type="hidden" name="action" value="verify">
                                                                            <button class="btn btn-success w-100 rounded-pill fw-bold shadow-sm py-2">
                                                                                <i class="bi bi-check-lg me-2"></i>
                                                                                {{ $order->payment_method == 'cash' ? 'Konfirmasi Cash' : 'Verifikasi Pembayaran' }}
                                                                            </button>
                                                                        </form>

                                                                        {{-- TOLAK (Cash & Transfer) --}}
                                                                        <button class="btn btn-outline-danger w-100 rounded-pill fw-bold shadow-sm py-2" type="button" data-bs-toggle="collapse" data-bs-target="#rejectReason{{$order->id}}">
                                                                            <i class="bi bi-x-lg me-2"></i> {{ $order->payment_method == 'cash' ? 'Tolak Pesanan (Cash)' : 'Tolak Pembayaran' }}
                                                                        </button>

                                                                        <div class="collapse mt-2" id="rejectReason{{$order->id}}">
                                                                            <form action="{{ route('admin.orders.updatePayment', $order->id) }}" method="POST">
                                                                                @csrf
                                                                                @method('PATCH')
                                                                                <input type="hidden" name="action" value="reject">
                                                                                <div class="mb-2">
                                                                                    <textarea name="note" class="form-control text-start" placeholder="Alasan penolakan..." required rows="2"></textarea>
                                                                                </div>
                                                                                <button class="btn btn-danger btn-sm w-100 rounded-pill fw-bold" onclick="return confirm('Yakin tolak pesanan ini?')">
                                                                                    Kirim Penolakan
                                                                                </button>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- END MODAL --}}

                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5">
                                    <div class="d-flex flex-column align-items-center justify-content-center opacity-50">
                                        <i class="bi bi-inbox fs-1 text-muted mb-3"></i>
                                        <h6 class="text-muted fw-bold">Belum ada pesanan yang masuk.</h6>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="p-4 border-top bg-light">
                {{ $orders->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>

<style>
    .xsmall { font-size: 0.75rem; }
    .ls-1 { letter-spacing: 1px; }
    .hover-scale { transition: transform 0.2s; }
    .hover-scale:hover { transform: scale(1.1); }
    .hover-underline:hover { text-decoration: underline !important; }
    .w-32 { width: 32px; }
    .h-32 { height: 32px; }
    .form-select:focus { box-shadow: none; border-color: #dee2e6; }
</style>
@endsection