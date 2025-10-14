@extends('layouts.admin')

@section('title', 'Detail Retur Produk')

@section('content')
<div class="container mt-4">
  {{-- Judul Halaman --}}
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold text-success mb-0">
      <i class="bi bi-arrow-repeat me-2"></i> Detail Retur Produk
    </h2>
    <a href="{{ route('admin.returns.index') }}" class="btn btn-outline-secondary">
      <i class="bi bi-arrow-left-circle me-1"></i> Kembali
    </a>
  </div>

  {{-- Kartu utama --}}
  <div class="card shadow-sm border-0 mb-4">
    <div class="card-header bg-success text-white fw-semibold">
      Informasi Retur
    </div>
    <div class="card-body fs-6">
      <div class="row mb-3">
        <div class="col-md-6">
          <div class="mb-3">
            <label class="fw-bold text-secondary">Nama Produk:</label><br>
            <span>{{ $return->product->name ?? '-' }}</span>
          </div>

          <div class="mb-3">
            <label class="fw-bold text-secondary">Kategori:</label><br>
            <span>{{ $return->product->category->name ?? '-' }}</span>
          </div>

          <div class="mb-3">
            <label class="fw-bold text-secondary">Jumlah Retur:</label><br>
            <span class="fw-bold text-dark">{{ $return->quantity }} pcs</span>
          </div>

          <div class="mb-3">
            <label class="fw-bold text-secondary">Kerugian:</label><br>
            <span class="text-danger fw-bold">Rp {{ number_format($return->loss, 0, ',', '.') }}</span>
          </div>

          <div class="mb-3">
            <label class="fw-bold text-secondary">Restock:</label><br>
            @if($return->restock)
              <span class="badge bg-success px-3 py-2">Ya</span>
            @else
              <span class="badge bg-danger px-3 py-2">Tidak</span>
            @endif
          </div>
        </div>

        <div class="col-md-6 border-start">
          <div class="mb-3">
            <label class="fw-bold text-secondary">ID Pengiriman:</label><br>
            <span>#{{ $return->shipment->id ?? '-' }}</span>
          </div>

          <div class="mb-3">
            <label class="fw-bold text-secondary">Tujuan:</label><br>
            <span>{{ $return->shipment->destination ?? '-' }}</span>
          </div>

          <div class="mb-3">
            <label class="fw-bold text-secondary">Kurir:</label><br>
            <span>{{ $return->shipment->courier ?? '-' }}</span>
          </div>

          <div class="mb-3">
            <label class="fw-bold text-secondary">Tanggal Pengiriman:</label><br>
            <span>{{ $return->shipment->shipment_date ?? '-' }}</span>
          </div>
        </div>
      </div>

      <hr>

      <div class="mb-3">
        <label class="fw-bold text-secondary">Alasan Retur:</label>
        <div class="p-3 bg-light border rounded">
          <p class="mb-0">{{ $return->reason ?? 'Tidak ada catatan.' }}</p>
        </div>
      </div>

      <div class="text-end mt-4">
        <a href="{{ route('admin.returns.edit', $return->id) }}" class="btn btn-success px-4">
          <i class="bi bi-pencil-square me-1"></i> Edit Data
        </a>
      </div>
    </div>
  </div>
</div>

{{-- Tambahan Style agar tampilan mudah dibaca --}}
<style>
  body {
    font-size: 16px;
  }
  .card-header {
    font-size: 1.05rem;
  }
  .fw-bold.text-secondary {
    color: #495057 !important;
  }
  .p-3.bg-light {
    font-size: 0.95rem;
  }
  .badge {
    font-size: 0.95rem;
  }
  .btn-success {
    background: #3ca65a;
    border: none;
  }
  .btn-success:hover {
    background: #318a4c;
  }
  .btn-outline-secondary {
    font-weight: 600;
  }
</style>
@endsection
