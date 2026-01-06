@extends('layouts.frontend')
@section('title', 'Checkout')

@section('content')
<div class="container py-4">
    {{-- Header --}}
    <div class="d-flex align-items-center mb-4">
        <a href="{{ route('cart.index') }}" class="btn btn-outline-secondary rounded-circle me-3 shadow-sm" style="width: 40px; height: 40px; display: grid; place-items: center;">
            <i class="bi bi-arrow-left"></i>
        </a>
        <h3 class="fw-bold text-success mb-0">Checkout</h3>
    </div>

    @if($cartItems->isEmpty())
        <div class="text-center py-5">
            <div class="mb-3">
                <i class="bi bi-bag-x text-muted" style="font-size: 4rem;"></i>
            </div>
            <h4 class="fw-bold text-muted">Keranjang Kosong</h4>
            <a href="{{ route('menu') }}" class="btn btn-success rounded-pill mt-3">Belanja Sekarang</a>
        </div>
    @else
        <form action="{{ route('checkout.process') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            {{-- Hidden Selected Items --}}
            @foreach($cartItems as $item)
                <input type="hidden" name="selected_items[]" value="{{ $item->id }}">
            @endforeach

            <div class="row g-4">
                {{-- LEFT COLUMN: Shipping & Payment --}}
                <div class="col-lg-7">
                    
                    {{-- 1. Data Penerima --}}
                    <div class="card border-0 shadow-sm rounded-4 mb-4">
                        <div class="card-body p-4">
                            <h5 class="fw-bold text-success mb-3">
                                <i class="bi bi-geo-alt-fill me-2"></i> Alamat Pengiriman
                            </h5>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold small text-muted">Nama Penerima</label>
                                    <input type="text" name="nama_penerima" class="form-control rounded-3" placeholder="Nama Lengkap" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold small text-muted">Nomor Telepon</label>
                                    <input type="text" name="no_telepon" class="form-control rounded-3" placeholder="08xxx" required>
                                </div>
                                <div class="col-12">
                                    <label class="form-label fw-semibold small text-muted">Alamat Lengkap</label>
                                    <textarea name="alamat" class="form-control rounded-3" rows="3" placeholder="Jalan, RT/RW, Nomor Rumah, Kelurahan..." required></textarea>
                                </div>
                                <div class="col-12">
                                    <label class="form-label fw-semibold small text-muted">Catatan (Opsional)</label>
                                    <textarea name="catatan" class="form-control rounded-3" rows="2" placeholder="Pesan untuk penjual..."></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- 2. Payment Method --}}
                    <div class="card border-0 shadow-sm rounded-4">
                        <div class="card-body p-4">
                            <h5 class="fw-bold text-success mb-3">
                                <i class="bi bi-wallet2 me-2"></i> Pembayaran
                            </h5>

                            {{-- Payment Selection Cards --}}
                            <div class="row g-3 mb-4">
                                <div class="col-6">
                                    <label class="cursor-pointer w-100">
                                        <input type="radio" name="payment_method" value="cash" class="btn-check" id="cod" checked>
                                        <div class="payment-card border rounded-4 p-3 text-center h-100 position-relative">
                                            <i class="bi bi-cash-stack fs-2 d-block mb-2 text-success"></i>
                                            <span class="fw-bold d-block small">COD</span>
                                            <span class="text-muted small">Bayar di Tempat</span>
                                            <div class="check-icon"><i class="bi bi-check-circle-fill text-success"></i></div>
                                        </div>
                                    </label>
                                </div>
                                <div class="col-6">
                                    <label class="cursor-pointer w-100">
                                        <input type="radio" name="payment_method" value="transfer" class="btn-check" id="transfer">
                                        <div class="payment-card border rounded-4 p-3 text-center h-100 position-relative">
                                            <i class="bi bi-qr-code-scan fs-2 d-block mb-2 text-primary"></i>
                                            <span class="fw-bold d-block small">Transfer / QRIS</span>
                                            <span class="text-muted small">Scan & Upload</span>
                                            <div class="check-icon"><i class="bi bi-check-circle-fill text-success"></i></div>
                                        </div>
                                    </label>
                                </div>
                            </div>

                            {{-- Transfer Detail Section --}}
                            <div id="transfer-section" class="d-none animate-fade-in">
                                <div class="bg-light rounded-4 p-4 text-center border">
                                    <h6 class="fw-bold text-dark mb-3">Scan QRIS untuk Membayar</h6>
                                    
                                    {{-- Placeholder QR --}}
                                    <div class="bg-white p-3 rounded-3 d-inline-block shadow-sm mb-3">
                                        <img src="https://upload.wikimedia.org/wikipedia/commons/d/d0/QR_code_for_mobile_English_Wikipedia.svg" 
                                             alt="QRIS Code" class="img-fluid" style="width: 150px; height: 150px;">
                                    </div>
                                    
                                    <div class="mb-3">
                                        <p class="mb-1 fw-bold text-primary">BANK BRI</p>
                                        <p class="mb-0 h5 font-monospace">1234 5678 9012</p>
                                        <small class="text-muted">a.n Bakso Siocay</small>
                                    </div>

                                    <hr class="my-3">

                                    <div class="text-start">
                                        <label class="form-label fw-semibold small">Upload Bukti Transfer</label>
                                        <input type="file" name="bukti_transfer" id="bukti_transfer" class="form-control rounded-3" accept="image/*">
                                        <small class="text-muted d-block mt-1 fst-italic">*Wajib upload bukti jika via transfer</small>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>

                {{-- RIGHT COLUMN: Order Summary (Sticky) --}}
                <div class="col-lg-5">
                    <div class="card border-0 shadow-sm rounded-4 position-sticky" style="top: 20px;">
                        <div class="card-body p-4">
                            <h5 class="fw-bold text-success mb-4">Ringkasan Pesanan</h5>
                            
                            {{-- Item List (Scrollable if too long) --}}
                            <div class="order-list mb-4 pe-2" style="max-height: 400px; overflow-y: auto;">
                                @foreach($cartItems as $item)
                                    <div class="d-flex align-items-center mb-3">
                                        <img src="{{ asset('images/products/' . $item->product->image) }}" 
                                             class="rounded-3 me-3 object-fit-cover bg-light" 
                                             style="width: 60px; height: 60px;">
                                        <div class="flex-grow-1">
                                            <h6 class="fw-semibold mb-0 text-dark">{{ $item->product->name }}</h6>
                                            <small class="text-muted">{{ $item->quantity }} x Rp {{ number_format($item->product->price_sale, 0, ',', '.') }}</small>
                                        </div>
                                        <div class="text-end fw-semibold text-secondary">
                                            Rp {{ number_format($item->product->price_sale * $item->quantity, 0, ',', '.') }}
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <hr class="border-dashed">

                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Subtotal Produk</span>
                                <span class="fw-semibold">Rp {{ number_format($total, 0, ',', '.') }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-4">
                                <span class="text-muted">Ongkos Kirim</span>
                                <span class="text-success fw-semibold">Gratis</span>
                            </div>
                            
                            <div class="d-flex justify-content-between align-items-center mb-4 pt-2 border-top">
                                <span class="fw-bold fs-5 text-dark">Total Bayar</span>
                                <span class="fw-bold fs-4 text-success">Rp {{ number_format($total, 0, ',', '.') }}</span>
                            </div>

                            <button type="submit" class="btn btn-success w-100 rounded-pill py-3 fw-bold shadow-sm hover-scale">
                                Buat Pesanan
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    @endif
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const codRadio = document.getElementById('cod');
        const transferRadio = document.getElementById('transfer');
        const transferSection = document.getElementById('transfer-section');
        const uploadInput = document.getElementById('bukti_transfer');

        function togglePayment() {
            if (transferRadio.checked) {
                transferSection.classList.remove('d-none');
                uploadInput.setAttribute('required', 'required');
            } else {
                transferSection.classList.add('d-none');
                uploadInput.removeAttribute('required');
            }
        }

        codRadio.addEventListener('change', togglePayment);
        transferRadio.addEventListener('change', togglePayment);
        togglePayment(); // Init
    });
</script>

<style>
/* Payment Card Styles */
.btn-check:checked + .payment-card {
    border-color: #198754 !important;
    background-color: #f0fdf4;
}
.btn-check:checked + .payment-card .check-icon {
    opacity: 1;
}
.payment-card {
    transition: all 0.2s;
    border: 2px solid #dee2e6;
}
.check-icon {
    position: absolute;
    top: 10px;
    right: 10px;
    opacity: 0;
    transition: opacity 0.2s;
}
.hover-scale:hover {
    transform: scale(1.02);
}
.border-dashed {
    border-style: dashed !important;
}

/* Animations */
.animate-fade-in {
    animation: fadeIn 0.3s ease-in-out;
}
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
}
</style>
@endsection