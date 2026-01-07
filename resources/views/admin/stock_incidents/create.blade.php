@extends('layouts.admin')

@section('content')
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="fw-bold" style="color:#4a3aff;">
                <i class="bi bi-plus-square me-2"></i> Tambah Insiden Stok
            </h3>
            <a href="{{ route('admin.stock-incidents.index') }}" class="btn btn-outline-secondary rounded-pill px-4">
                <i class="bi bi-arrow-left me-2"></i> Kembali
            </a>
        </div>

        <div class="card shadow-sm border-0 rounded-4">
            <div class="card-body p-4">
                <form action="{{ route('admin.stock-incidents.store') }}" method="POST">
                    @csrf

                    <div class="row g-4">
                        {{-- Product selection --}}
                        <div class="col-md-6">
                            <label for="product_id" class="form-label fw-semibold">Produk</label>
                            <select name="product_id" id="product_id" class="form-select" required>
                                <option value="">-- Pilih Produk --</option>
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}">{{ $product->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="type" class="form-label fw-semibold">Jenis Insiden</label>
                            <select name="type" id="type" class="form-select" required>
                                <option value="Retur">Retur</option>
                                <option value="Reject">Reject</option>
                                <option value="Hilang">Hilang</option>
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label for="quantity" class="form-label fw-semibold">Jumlah</label>
                            <input type="number" name="quantity" id="quantity" class="form-control" required>
                        </div>

                        <div class="col-md-4">
                            <label for="loss" class="form-label fw-semibold">Kerugian (Rp)</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">Rp</span>
                                <input type="number" name="loss" id="loss" class="form-control" placeholder="0">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <label for="restock" class="form-label fw-semibold">Restock?</label>
                            <select name="restock" id="restock" class="form-select" required>
                                <option value="1">Ya, Kembalikan ke Stok</option>
                                <option value="0">Tidak, Hapus dari Stok</option>
                            </select>
                        </div>

                        <div class="col-12">
                            <label for="note" class="form-label fw-semibold">Catatan</label>
                            <textarea name="note" id="note" class="form-control" rows="3"
                                placeholder="Tambahkan catatan jika diperlukan..."></textarea>
                        </div>

                        <div class="col-12 text-end mt-4">
                            <button type="submit" class="btn btn-primary rounded-pill px-5 fw-bold shadow-sm">
                                <i class="bi bi-save me-2"></i> Simpan
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
        .ls-1 {
            letter-spacing: 1px;
        }
    </style>
@endsection
