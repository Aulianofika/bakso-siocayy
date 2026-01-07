@extends('layouts.admin')

@section('content')
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="fw-bold" style="color:#4a3aff;">
                <i class="bi bi-pencil-square me-2"></i> Edit Insiden Stok
            </h3>
            <a href="{{ route('admin.stock-incidents.index') }}" class="btn btn-outline-secondary rounded-pill px-4">
                <i class="bi bi-arrow-left me-2"></i> Kembali
            </a>
        </div>

        <div class="card shadow-sm border-0 rounded-4">
            <div class="card-body p-4">
                <form action="{{ route('admin.stock-incidents.update', $stockIncident->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row g-4">
                        {{-- Info Header --}}
                        <div class="col-12">
                            <div class="alert alert-light border d-flex justify-content-between align-items-center">
                                <div>
                                    <small class="text-muted fw-bold text-uppercase ls-1">ID INSIDEN</small>
                                    <div class="fw-bold text-dark">#{{ $stockIncident->id }}</div>
                                </div>
                                <div>
                                    <small class="text-muted fw-bold text-uppercase ls-1">TANGGAL</small>
                                    <div class="fw-bold text-dark">{{ $stockIncident->created_at->format('d M Y') }}</div>
                                </div>
                            </div>
                        </div>

                        {{-- Product selection --}}
                        <div class="col-md-6">
                            <label for="product_id" class="form-label fw-semibold">Produk</label>
                            <select name="product_id" id="product_id" class="form-select" required>
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}" {{ $stockIncident->product_id == $product->id ? 'selected' : '' }}>
                                        {{ $product->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="type" class="form-label fw-semibold">Jenis Insiden</label>
                            <select name="type" id="type" class="form-select" required>
                                <option value="Retur" {{ $stockIncident->type == 'Retur' ? 'selected' : '' }}>Retur</option>
                                <option value="Reject" {{ $stockIncident->type == 'Reject' ? 'selected' : '' }}>Reject
                                </option>
                                <option value="Hilang" {{ $stockIncident->type == 'Hilang' ? 'selected' : '' }}>Hilang
                                </option>
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label for="quantity" class="form-label fw-semibold">Jumlah</label>
                            <input type="number" name="quantity" id="quantity" class="form-control"
                                value="{{ $stockIncident->quantity }}" required>
                        </div>

                        <div class="col-md-4">
                            <label for="loss" class="form-label fw-semibold">Kerugian (Rp)</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">Rp</span>
                                <input type="number" name="loss" id="loss" class="form-control"
                                    value="{{ $stockIncident->loss }}" required>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <label for="restock" class="form-label fw-semibold">Restock?</label>
                            <select name="restock" id="restock" class="form-select" required>
                                <option value="1" {{ $stockIncident->restock ? 'selected' : '' }}>Ya, Kembalikan ke Stok
                                </option>
                                <option value="0" {{ !$stockIncident->restock ? 'selected' : '' }}>Tidak, Hapus dari Stok
                                </option>
                            </select>
                        </div>

                        <div class="col-12">
                            <label for="note" class="form-label fw-semibold">Catatan</label>
                            <textarea name="note" id="note" class="form-control" rows="3"
                                placeholder="Tambahkan catatan jika diperlukan...">{{ $stockIncident->note }}</textarea>
                        </div>

                        <div class="col-12 text-end mt-4">
                            <button type="submit" class="btn btn-primary rounded-pill px-5 fw-bold shadow-sm">
                                <i class="bi bi-save me-2"></i> Simpan Perubahan
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