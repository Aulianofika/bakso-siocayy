@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h3 class="fw-bold mb-4" style="color:#4a3aff;">
        <i class="bi bi-pencil me-2"></i> Edit Pengiriman
    </h3>

    @if(session('error'))
        <div class="alert alert-danger shadow-sm">
            {{ session('error') }}
        </div>
    @endif

    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body p-4">
            <div class="alert alert-info mb-4">
                <strong>Informasi Pesanan:</strong><br>
                Invoice: #{{ $shipment->order->invoice_number }}<br>
                Pemesan: {{ $shipment->order->user->name ?? '-' }}
            </div>

            <form action="{{ route('admin.shipments.update', $shipment->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="destination" class="form-label fw-semibold">
                        <i class="bi bi-geo-alt me-1"></i> Alamat Tujuan (Kemana)
                    </label>
                    <textarea name="destination" id="destination" class="form-control" rows="3" required>{{ $shipment->destination }}</textarea>
                    <small class="text-muted">Alamat lengkap tujuan pengiriman</small>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label for="shipment_date" class="form-label fw-semibold">
                            <i class="bi bi-calendar me-1"></i> Tanggal Pengiriman (Kapan)
                        </label>
                        <input type="date" name="shipment_date" id="shipment_date" 
                               class="form-control" 
                               value="{{ $shipment->shipment_date }}" 
                               required>
                        <small class="text-muted">Tanggal barang dikirim</small>
                    </div>

                    <div class="col-md-6">
                        <label for="courier" class="form-label fw-semibold">
                            <i class="bi bi-truck me-1"></i> Kurir / Ekspedisi
                        </label>
                        <input type="text" name="courier" id="courier" 
                               class="form-control" 
                               value="{{ $shipment->courier }}" 
                               required>
                        <small class="text-muted">Nama kurir atau ekspedisi pengiriman</small>
                    </div>
                </div>

                <div class="alert alert-warning">
                    <strong><i class="bi bi-exclamation-triangle me-1"></i> Catatan:</strong>
                    <p class="mb-0">Pengiriman hanya bisa diedit jika status masih "Menunggu". Barang yang dikirim dapat dilihat di detail pesanan.</p>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle me-1"></i> Update Pengiriman
                    </button>
                    <a href="{{ route('admin.shipments.index') }}" class="btn btn-secondary">
                        <i class="bi bi-x-circle me-1"></i> Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
