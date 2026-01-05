@extends('admin.layouts.app')
@section('title', 'Tambah Pesanan Manual')

@section('content')
<div class="container py-4">

    <h3 class="fw-bold mb-4">📝 Tambah Pesanan Manual (Offline)</h3>

    <form action="{{ route('admin.orders.store') }}" method="POST">
        @csrf

        <div class="card shadow-sm mb-4">
            <div class="card-header fw-bold">Data Pelanggan</div>
            <div class="card-body">
                <label class="form-label">Pilih Customer</label>
                <select name="customer_id" class="form-select">
                    @foreach($customers as $c)
                        <option value="{{ $c->id }}">
                            {{ $c->nama_lengkap }} ({{ $c->telepon }})
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="card shadow-sm mb-4">
            <div class="card-header fw-bold">Produk</div>
            <div class="card-body" id="product-list">

                <div class="row mb-3 product-item">
                    <div class="col-md-6">
                        <label>Produk</label>
                        <select name="products[0][id]" class="form-select">
                            @foreach($products as $p)
                                <option value="{{ $p->id }}">{{ $p->name }} - Rp {{ number_format($p->price_sale) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label>Qty</label>
                        <input type="number" name="products[0][quantity]" class="form-control" value="1" min="1">
                    </div>
                </div>

                <button type="button" class="btn btn-outline-primary btn-sm" id="addRow">+ Tambah Produk</button>
            </div>
        </div>

        <div class="card shadow-sm mb-4">
            <div class="card-header fw-bold">Status Pesanan</div>
            <div class="card-body">
                <div class="row g-3">

                    <div class="col-md-4">
                        <label>Status Order</label>
                        <select name="status_order" class="form-select">
                            <option>Pending</option>
                            <option>Diproses</option>
                            <option>Selesai</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label>Status Pembayaran</label>
                        <select name="status_payment" class="form-select">
                            <option>Belum Bayar</option>
                            <option>DP</option>
                            <option>Lunas</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label>Jumlah Dibayar</label>
                        <input type="number" name="amount_paid" class="form-control" value="0">
                    </div>

                </div>
            </div>
        </div>

        <button class="btn btn-primary w-100">Simpan Pesanan</button>

    </form>
</div>

<script>
let rowIndex = 1;
document.getElementById('addRow').onclick = function() {
    let container = document.getElementById('product-list');
    let html = `
    <div class="row mb-3 product-item">
        <div class="col-md-6">
            <select name="products[${rowIndex}][id]" class="form-select">
                @foreach($products as $p)
                    <option value="{{ $p->id }}">{{ $p->name }} - Rp {{ number_format($p->price_sale) }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <input type="number" name="products[${rowIndex}][quantity]" class="form-control" value="1" min="1">
        </div>
    </div>
    `;
    container.insertAdjacentHTML('beforeend', html);
    rowIndex++;
};
</script>

@endsection
