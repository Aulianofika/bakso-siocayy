@extends('layouts.admin')

@section('title', 'Tambah Pesanan')

@section('content')
<div class="container mt-4">
    <div class="card shadow-lg border-0 rounded-4">
        <div class="card-header bg-primary text-white rounded-top-4">
            <h4 class="mb-0"><i class="bi bi-bag-plus-fill me-2"></i>Tambah Pesanan Baru</h4>
        </div>

        <div class="card-body">
            <form action="{{ route('admin.orders.store') }}" method="POST" id="orderForm">
                @csrf

                {{-- Pilih Customer --}}
                <div class="mb-3">
                    <label for="customer_id" class="form-label fw-semibold">Pelanggan</label>
                    <select name="customer_id" id="customer_id" class="form-select @error('customer_id') is-invalid @enderror" required>
                        <option value="">-- Pilih Pelanggan --</option>
                        @foreach ($customers as $customer)
                            <option value="{{ $customer->id }}">
                                {{ $customer->nama_lengkap }} ({{ $customer->email }})
                            </option>
                        @endforeach
                    </select>
                    @error('customer_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                {{-- Pilih Produk --}}
                <div class="mb-4">
                    <label class="form-label fw-semibold">Produk</label>
                    <div id="product-list">
                        <div class="row g-2 mb-2 product-item">
                            <div class="col-md-6">
                                <select name="products[0][id]" class="form-select product-select" required>
                                    <option value="">-- Pilih Produk --</option>
                                    @foreach ($products as $product)
                                        <option value="{{ $product->id }}" data-price="{{ $product->price_sale }}">
                                            {{ $product->name }} - Rp{{ number_format($product->price_sale, 0, ',', '.') }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <input type="number" name="products[0][quantity]" class="form-control quantity-input" placeholder="Jumlah" min="1" value="1" required>
                            </div>
                            <div class="col-md-2">
                                <input type="text" class="form-control item-total" placeholder="Subtotal" readonly>
                            </div>
                            <div class="col-md-1 d-flex align-items-center">
                                <button type="button" class="btn btn-danger btn-sm remove-item">
                                    <i class="bi bi-x-lg"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <button type="button" class="btn btn-outline-primary btn-sm mt-2" id="add-product">
                        <i class="bi bi-plus-circle me-1"></i>Tambah Produk
                    </button>
                </div>

                {{-- Status Pesanan --}}
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-semibold">Status Order</label>
                        <select name="status_order" class="form-select" required>
                            <option value="Pending">Pending</option>
                            <option value="Diproses">Diproses</option>
                            <option value="Selesai">Selesai</option>
                        </select>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-semibold">Status Pembayaran</label>
                        <select name="status_payment" class="form-select" required>
                            <option value="Belum Bayar">Belum Bayar</option>
                            <option value="DP">DP</option>
                            <option value="Lunas">Lunas</option>
                        </select>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-semibold">Jumlah Dibayar</label>
                        <input type="number" step="0.01" name="amount_paid" class="form-control" value="0">
                    </div>
                </div>

                {{-- Total Harga --}}
                <div class="mt-3 p-3 bg-light rounded-3 border text-end">
                    <h5 class="mb-0 fw-bold">Total Harga: <span id="grandTotal" class="text-primary">Rp0</span></h5>
                    <input type="hidden" name="total_price" id="total_price" value="0">
                </div>

                {{-- Tombol --}}
                <div class="text-end mt-4">
                    <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-check-circle"></i> Simpan Pesanan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Script kalkulasi otomatis --}}
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    let productIndex = 1;

    function formatRupiah(value) {
        return 'Rp' + new Intl.NumberFormat('id-ID').format(value);
    }

    function hitungTotal() {
        let total = 0;
        document.querySelectorAll('.product-item').forEach(item => {
            const select = item.querySelector('.product-select');
            const qty = item.querySelector('.quantity-input');
            const subtotal = item.querySelector('.item-total');

            const price = select.options[select.selectedIndex]?.getAttribute('data-price') || 0;
            const jumlah = qty.value ? parseInt(qty.value) : 0;
            const itemTotal = price * jumlah;

            subtotal.value = formatRupiah(itemTotal);
            total += itemTotal;
        });

        document.getElementById('grandTotal').textContent = formatRupiah(total);
        document.getElementById('total_price').value = total;
    }

    document.getElementById('add-product').addEventListener('click', function () {
        const newRow = document.querySelector('.product-item').cloneNode(true);
        newRow.querySelectorAll('input, select').forEach(el => {
            el.value = '';
        });
        newRow.querySelector('.item-total').value = '';
        newRow.querySelector('.quantity-input').value = 1;
        newRow.querySelectorAll('select, input').forEach(el => {
            el.name = el.name.replace(/\[\d+\]/, `[${productIndex}]`);
        });
        productIndex++;
        document.getElementById('product-list').appendChild(newRow);
    });

    document.getElementById('product-list').addEventListener('input', hitungTotal);
    document.getElementById('product-list').addEventListener('change', hitungTotal);

    document.getElementById('product-list').addEventListener('click', function (e) {
        if (e.target.closest('.remove-item')) {
            const items = document.querySelectorAll('.product-item');
            if (items.length > 1) {
                e.target.closest('.product-item').remove();
                hitungTotal();
            }
        }
    });

    hitungTotal();
});
</script>
@endpush
@endsection
