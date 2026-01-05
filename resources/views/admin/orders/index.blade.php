@extends('layouts.admin')

@section('title', 'Manajemen Pesanan')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h3 class="fw-bold text-dark mb-0">Manajemen Pesanan</h3>
        <button class="btn btn-light border shadow-sm text-primary fw-bold" type="button" data-bs-toggle="collapse"
            data-bs-target="#filterPanel">
            <i class="bi bi-funnel-fill me-1"></i> Filter
        </button>
    </div>

    {{-- FILTER PANEL --}}
    <div class="collapse show" id="filterPanel">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body bg-light rounded-3">
                <form method="GET" class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label small fw-bold text-uppercase text-muted">Status Pesanan</label>
                        <select name="status_order" class="form-select border-0 shadow-sm text-dark fw-bold">
                            <option value="">Semua Status</option>
                            @foreach(['Pending', 'Diproses', 'Siap Dikirim', 'Selesai', 'Ditolak'] as $st)
                                <option value="{{ $st }}" {{ request('status_order') == $st ? 'selected' : '' }}>{{ $st }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label small fw-bold text-uppercase text-muted">Metode Pembayaran</label>
                        <select name="payment_method" class="form-select border-0 shadow-sm text-dark fw-bold">
                            <option value="">Semua Metode</option>
                            <option value="cash" {{ request('payment_method') == 'cash' ? 'selected' : '' }}>Cash</option>
                            <option value="transfer" {{ request('payment_method') == 'transfer' ? 'selected' : '' }}>Transfer
                            </option>
                        </select>
                    </div>
                    <div class="col-md-4 d-flex align-items-end">
                        <button class="btn btn-primary w-100 shadow-sm fw-bold">
                            <i class="bi bi-search me-1"></i> Terapkan Filter
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- ORDER TABLE --}}
    <div class="card border-0 shadow-sm">
        <div class="card-header border-0 bg-white py-3">
            <h6 class="m-0 fw-bold text-dark">Daftar Pesanan</h6>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light text-muted">
                        <tr>
                            <th class="ps-4" width="5%">No</th>
                            <th width="20%">Invoice / Pelanggan</th>
                            <th width="15%">Total</th>
                            <th width="10%" class="text-center">Metode</th>
                            <th width="20%" class="text-center">Status Pesanan</th>
                            <th width="15%" class="text-center">Status Bayar</th>
                            <th width="15%" class="text-end pe-4">Aksi</th>
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
                                    'DP' => 'bg-info text-white',
                                    default => 'bg-secondary text-white'
                                };
                            @endphp
                            <tr>
                                <td class="ps-4 text-center fw-bold text-muted">{{ $loop->iteration }}</td>
                                <td>
                                    <div class="d-flex flex-column">
                                        <span
                                            class="fw-bold text-dark font-monospace">#{{ $order->invoice_number ?? $order->id }}</span>
                                        <small class="text-primary fw-bold">{{ $order->user->name ?? 'Guest' }}</small>
                                        <small class="text-muted"
                                            style="font-size: 0.85rem;">{{ $order->created_at->format('d M Y, H:i') }}</small>
                                    </div>
                                </td>
                                <td>
                                    <span class="fw-bold text-dark">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                                </td>
                                <td class="text-center">
                                    <span class="badge border bg-light text-dark fw-normal rounded-pill px-3">
                                        {{ ucfirst($order->payment_method) }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <select name="status_order"
                                            class="form-select form-select-sm border-0 shadow-sm fw-bold {{ $statusClass }} text-center"
                                            onchange="this.form.submit()" style="cursor: pointer; font-size: 0.9rem;">
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
                                    <span class="badge {{ $paymentStatusClass }} rounded-pill px-3 fw-normal">
                                        {{ $order->status_payment }}
                                    </span>
                                </td>
                                <td class="text-end pe-4">
                                    <div class="d-flex gap-1 justify-content-end">
                                        <button class="btn btn-sm btn-primary shadow-sm rounded-circle"
                                            style="width:32px;height:32px;" data-bs-toggle="modal"
                                            data-bs-target="#detailModal{{ $order->id }}" title="Detail Pesanan">
                                            <i class="bi bi-info-lg"></i>
                                        </button>
                                        <form action="{{ route('admin.orders.destroy', $order->id) }}" method="POST"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus pesanan ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-danger shadow-sm rounded-circle"
                                                style="width:32px;height:32px;" title="Hapus Pesanan">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>

                            {{-- DETAIL MODAL --}}
                            <div class="modal fade" id="detailModal{{ $order->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-xl modal-dialog-centered">
                                    <div class="modal-content border-0 shadow rounded-4 overflow-hidden">
                                        <div class="modal-header bg-light border-bottom-0 py-3">
                                            <h5 class="modal-title fw-bold">
                                                <i class="bi bi-receipt me-2"></i>Detail Pesanan
                                                #{{ $order->invoice_number ?? $order->id }}
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body bg-white p-0">
                                            <div class="row g-0">
                                                {{-- Order Items (Left) --}}
                                                <div class="col-lg-7 border-end p-4">
                                                    <h6 class="fw-bold text-uppercase text-muted mb-3 small">Item Dipesan</h6>
                                                    <div class="d-flex flex-column gap-3">
                                                        @foreach ($order->orderItems as $item)
                                                            <div class="d-flex align-items-center gap-3 p-3 rounded-3 bg-light border-0">
                                                                <div class="bg-white rounded p-1 border shadow-sm text-center flex-shrink-0" style="width:60px;height:60px; overflow:hidden;">
                                                                    @if($item->product->image)
                                                                        <img src="{{ asset('images/products/'.$item->product->image) }}" class="w-100 h-100 object-fit-cover rounded" alt="{{ $item->product->name }}">
                                                                    @else
                                                                        <div class="d-flex align-items-center justify-content-center h-100 text-secondary bg-light">
                                                                            <i class="bi bi-image fs-4"></i>
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                                <div class="flex-grow-1">
                                                                    <h6 class="fw-bold mb-0 text-dark">{{ $item->product->name }}</h6>
                                                                    <small class="text-muted">x{{ $item->quantity }} @ Rp {{ number_format($item->price, 0, ',', '.') }}</small>
                                                                </div>
                                                                <div class="text-end fw-bold text-dark">
                                                                    Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>

                                                    <div class="mt-4 pt-4 border-top">
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <span class="text-muted fw-bold">Total Pembayaran</span>
                                                            <span class="display-6 fw-bold text-success">
                                                                Rp {{ number_format($order->total_price, 0, ',', '.') }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>

                                                {{-- Payment & Status (Right) --}}
                                                <div class="col-lg-5 p-4 rounded-3" style="background-color: #f9f9f9;">
                                                    {{-- Customer Info --}}
                                                    <div class="mb-4">
                                                        <h6 class="fw-bold text-dark mb-3 small opacity-75 text-uppercase ls-1">Informasi Pengiriman</h6>
                                                        
                                                        <div class="d-flex align-items-start gap-3 mb-3">
                                                            <div class="rounded-circle bg-white border d-flex align-items-center justify-content-center flex-shrink-0" style="width: 38px; height: 38px;">
                                                                <i class="bi bi-person text-secondary"></i>
                                                            </div>
                                                            <div>
                                                                <h6 class="fw-bold text-dark mb-1">{{ $order->nama_penerima ?? $order->user->name }}</h6>
                                                                <div class="text-muted small mb-1">{{ $order->telepon ?? '-' }}</div>
                                                                <div class="text-muted small" style="line-height: 1.4;">
                                                                    {{ $order->alamat_lengkap ?? 'Alamat tidak tersedia' }}
                                                                </div>
                                                                @if($order->catatan)
                                                                    <div class="mt-2 text-warning-emphasis bg-warning-subtle px-2 py-1 rounded small d-inline-block">
                                                                        <i class="bi bi-sticky me-1"></i> Catatan: {{ $order->catatan }}
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <hr class="border-secondary opacity-10 my-4">

                                                    {{-- Payment Info --}}
                                                    <div class="mb-4">
                                                        <h6 class="fw-bold text-dark mb-3 small opacity-75 text-uppercase ls-1">Pembayaran</h6>
                                                        
                                                        @if($order->payment_method == 'cash')
                                                            <div class="d-flex align-items-center gap-2 text-secondary">
                                                                <i class="bi bi-cash-stack fs-5"></i>
                                                                <span>Tunai (Cash)</span>
                                                            </div>
                                                        @elseif($order->bukti_transfer)
                                                            <div class="mb-2">
                                                                <img src="{{ asset('storage/' . $order->bukti_transfer) }}"
                                                                    class="img-fluid rounded border bg-white"
                                                                    style="max-height: 140px; width: auto; object-fit: contain;">
                                                            </div>
                                                            <a href="{{ asset('storage/' . $order->bukti_transfer) }}"
                                                                target="_blank" class="small text-primary text-decoration-none fw-bold hover-underline">
                                                                Lihat Bukti Full <i class="bi bi-arrow-up-right ms-1"></i>
                                                            </a>
                                                        @else
                                                            <span class="text-muted small fst-italic">Belum ada bukti transfer.</span>
                                                        @endif
                                                    </div>

                                                    <hr class="border-secondary opacity-10 my-4">

                                                    {{-- Payment Status Update --}}
                                                    <div>
                                                        <h6 class="fw-bold text-dark mb-3 small opacity-75 text-uppercase ls-1">Update Status</h6>
                                                        <form action="{{ route('admin.orders.updatePayment', $order->id) }}" method="POST">
                                                            @csrf
                                                            @method('PATCH')
                                                            <div class="d-flex gap-2">
                                                                <select name="status_payment" class="form-select form-select-sm bg-white border-secondary-subtle">
                                                                    @foreach(['Belum Bayar', 'DP', 'Lunas'] as $status)
                                                                        <option value="{{ $status }}" {{ $order->status_payment == $status ? 'selected' : '' }}>
                                                                            {{ $status }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                                <button class="btn btn-sm btn-dark px-3">
                                                                    Simpan
                                                                </button>
                                                            </div>
                                                        </form>
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
                                    <i class="bi bi-inbox fs-1 text-muted opacity-50 mb-3 d-block"></i>
                                    <p class="text-muted">Belum ada pesanan yang masuk.</p>
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
@endsection