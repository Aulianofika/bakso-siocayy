@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h3 class="fw-bold mb-4" style="color:#4a3aff;">
        <i class="bi bi-truck me-2"></i> Buat Pengiriman Baru
    </h3>

    @if(session('error'))
        <div class="alert alert-danger shadow-sm">
            {{ session('error') }}
        </div>
    @endif

    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body p-4">
            <form action="{{ route('admin.shipments.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="order_id" class="form-label fw-semibold">Pilih Pesanan</label>
                    <select name="order_id" id="order_id" class="form-select" required onchange="loadOrderData(this.value)">
                        <option value="">-- Pilih Pesanan --</option>
                        @foreach($orders as $order)
                            <option value="{{ $order->id }}" 
                                    data-alamat="{{ $order->alamat_lengkap ?? '' }}">
                                Invoice #{{ $order->invoice_number }} - {{ $order->user->name ?? 'Tidak diketahui' }}
                            </option>
                        @endforeach
                    </select>
                    <small class="text-muted">Pilih pesanan yang akan dikirim</small>
                </div>

                <div class="mb-3">
                    <label for="destination" class="form-label fw-semibold">
                        <i class="bi bi-geo-alt me-1"></i> Alamat Tujuan (Kemana)
                    </label>
                    <textarea name="destination" id="destination" class="form-control" rows="3" required placeholder="Masukkan alamat lengkap tujuan pengiriman"></textarea>
                    <small class="text-muted">Alamat lengkap tujuan pengiriman</small>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label for="shipment_date" class="form-label fw-semibold">
                            <i class="bi bi-calendar me-1"></i> Tanggal Pengiriman (Kapan)
                        </label>
                        <input type="date" name="shipment_date" id="shipment_date" 
                               class="form-control" 
                               value="{{ date('Y-m-d') }}" 
                               required>
                        <small class="text-muted">Tanggal barang dikirim</small>
                    </div>

                    <div class="col-md-6">
                        <label for="courier" class="form-label fw-semibold">
                            <i class="bi bi-truck me-1"></i> Kurir / Ekspedisi
                        </label>
                        <input type="text" name="courier" id="courier" 
                               class="form-control" 
                               placeholder="Contoh: JNE, J&T, Gojek, dll" 
                               required>
                        <small class="text-muted">Nama kurir atau ekspedisi pengiriman</small>
                    </div>
                </div>

                <div class="alert alert-info">
                    <strong><i class="bi bi-info-circle me-1"></i> Catatan:</strong>
                    <ul class="mb-0 mt-2">
                        <li>Barang yang dikirim dapat dilihat di detail pesanan</li>
                        <li>Pastikan alamat tujuan sudah benar</li>
                        <li>Tanggal pengiriman akan tercatat sebagai pengingat</li>
                    </ul>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle me-1"></i> Simpan Pengiriman
                    </button>
                    <a href="{{ route('admin.shipments.index') }}" class="btn btn-secondary">
                        <i class="bi bi-x-circle me-1"></i> Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function loadOrderData(orderId) {
    const select = document.getElementById('order_id');
    const option = select.options[select.selectedIndex];
    const alamat = option.getAttribute('data-alamat');
    
    if (alamat) {
        document.getElementById('destination').value = alamat;
    }
}
</script>
@endsection
