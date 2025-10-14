@extends('layouts.admin')

@section('title', 'Tambah Pesanan')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4 fw-bold">🛒 Tambah Pesanan Baru</h2>

    {{-- Alert Error --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Periksa kembali input Anda:</strong>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Alert Success --}}
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('admin.orders.store') }}" method="POST" id="orderForm">
        @csrf

        {{-- Pilih Pelanggan --}}
        <div class="mb-3">
            <label for="user_id" class="form-label">👤 Pelanggan</label>
            <select name="user_id" id="user_id" class="form-select" required>
                <option value="">-- Pilih Pelanggan --</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                @endforeach
            </select>
        </div>

        {{-- Pilih Produk --}}
        <div class="card p-3 mb-3">
            <h5 class="mb-3 fw-semibold">🧾 Produk yang Dipesan</h5>

            <div id="product-list">
                <div class="row g-2 mb-2 product-item">
                    <div class="col-md-6">
                        <select name="products[0][id]" class="form-select product-select" required>
                            <option value="">-- Pilih Produk --</option>
                            @foreach($products as $product)
                                <option value="{{ $product->id }}" data-price="{{ $product->price_sale ?? $product->price }}">
                                    {{ $product->nama_produk ?? $product->name }} 
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-2">
                        <input type="number" name="products[0][quantity]" class="form-control quantity" min="1" value="1" required>
                    </div>

                    <div class="col-md-3">
                        <input type="text" class="form-control price" readonly placeholder="Harga">
                    </div>

                    <div class="col-md-1 text-center">
                        <button type="button" class="btn btn-danger btn-sm remove-row">&times;</button>
                    </div>
                </div>
            </div>

            <button type="button" class="btn btn-sm btn-outline-primary" id="add-product">+ Tambah Produk</button>
        </div>

        {{-- Total --}}
        <div class="mb-3">
            <label for="total_price" class="form-label fw-semibold">💰 Total Harga</label>
            <input type="text" id="total_price_display" class="form-control" readonly>
            <input type="hidden" name="total_price" id="total_price">
        </div>

        {{-- Status --}}
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="status_order" class="form-label">📦 Status Pesanan</label>
                <select name="status_order" class="form-select">
                    <option value="Pending">Pending</option>
                    <option value="Diproses">Diproses</option>
                    <option value="Selesai">Selesai</option>
                </select>
            </div>

            <div class="col-md-6 mb-3">
                <label for="status_payment" class="form-label">💳 Status Pembayaran</label>
                <select name="status_payment" class="form-select">
                    <option value="Belum Bayar">Belum Bayar</option>
                    <option value="DP">DP</option>
                    <option value="Lunas">Lunas</option>
                </select>
            </div>
        </div>

        {{-- Jumlah Dibayar --}}
        <div class="mb-4">
            <label for="amount_paid" class="form-label">💵 Jumlah Dibayar</label>
            <input type="number" name="amount_paid" id="amount_paid" class="form-control" value="0">
        </div>

        {{-- Tombol --}}
        <div class="d-flex justify-content-between">
            <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">← Kembali</a>
            <button type="submit" class="btn btn-success px-4">💾 Simpan Pesanan</button>
        </div>
    </form>
</div>

{{-- JS untuk update otomatis harga & total --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    let productList = document.getElementById('product-list');
    let addBtn = document.getElementById('add-product');

    // Hitung total
    function calculateTotal() {
        let total = 0;
        document.querySelectorAll('.product-item').forEach(row => {
            let price = parseFloat(row.querySelector('.price').value.replace(/\D/g, '')) || 0;
            total += price;
        });
        document.getElementById('total_price_display').value = 'Rp ' + total.toLocaleString('id-ID');
        document.getElementById('total_price').value = total;
    }

    // Update harga saat produk dipilih
    productList.addEventListener('change', function (e) {
        if (e.target.classList.contains('product-select')) {
            let selected = e.target.options[e.target.selectedIndex];
            let price = selected.getAttribute('data-price');
            let row = e.target.closest('.product-item');
            let qty = parseInt(row.querySelector('.quantity').value) || 1;
            let totalPrice = price * qty;
            row.querySelector('.price').value = 'Rp ' + totalPrice.toLocaleString('id-ID');
            calculateTotal();
        }
    });

    // Update total saat quantity berubah
    productList.addEventListener('input', function (e) {
        if (e.target.classList.contains('quantity')) {
            let row = e.target.closest('.product-item');
            let select = row.querySelector('.product-select');
            let price = select.options[select.selectedIndex].getAttribute('data-price');
            let qty = parseInt(e.target.value) || 1;
            row.querySelector('.price').value = 'Rp ' + (price * qty).toLocaleString('id-ID');
            calculateTotal();
        }
    });

    // Tambah produk baru
    addBtn.addEventListener('click', function () {
        let count = document.querySelectorAll('.product-item').length;
        let newRow = productList.firstElementChild.cloneNode(true);

        newRow.querySelectorAll('select, input').forEach(el => {
            el.name = el.name.replace(/\d+/, count);
            if (el.classList.contains('price')) el.value = '';
            if (el.classList.contains('quantity')) el.value = 1;
        });

        productList.appendChild(newRow);
    });

    // Hapus baris produk
    productList.addEventListener('click', function (e) {
        if (e.target.classList.contains('remove-row')) {
            e.target.closest('.product-item').remove();
            calculateTotal();
        }
    });
});
</script>
@endsection
