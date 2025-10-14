@extends('layouts.admin')

@section('title', 'Edit Retur Produk')

@section('content')
<div class="container mt-4">
  <h2 class="mb-4 text-success fw-bold">
    <i class="bi bi-pencil-square me-2"></i> Edit Data Retur
  </h2>

  {{-- Tombol kembali --}}
  <a href="{{ route('admin.returns.index') }}" class="btn btn-outline-success mb-3">
    <i class="bi bi-arrow-left-circle me-1"></i> Kembali
  </a>

  {{-- Alert jika ada error --}}
  @if($errors->any())
    <div class="alert alert-danger">
      <strong>Terjadi kesalahan!</strong>
      <ul class="mb-0 mt-1">
        @foreach($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  {{-- Form edit retur --}}
  <div class="card shadow-sm border-0">
    <div class="card-body">
      <form action="{{ route('admin.returns.update', $return->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row">
          {{-- Produk --}}
          <div class="col-md-6 mb-3">
            <label for="product_id" class="form-label fw-semibold">
              <i class="bi bi-box-seam me-1 text-success"></i> Produk
            </label>
            <select name="product_id" id="product_id" class="form-select" required>
              <option value="">-- Pilih Produk --</option>
              @foreach($products as $product)
                <option value="{{ $product->id }}" 
                        {{ $product->id == $return->product_id ? 'selected' : '' }}>
                  {{ $product->name }}
                </option>
              @endforeach
            </select>
          </div>

          {{-- Pengiriman --}}
          <div class="col-md-6 mb-3">
            <label for="shipment_id" class="form-label fw-semibold">
              <i class="bi bi-truck me-1 text-success"></i> Pengiriman
            </label>
            <select name="shipment_id" id="shipment_id" class="form-select">
              <option value="">-- Pilih Pengiriman (Opsional) --</option>
              @foreach($shipments as $shipment)
                <option value="{{ $shipment->id }}" 
                        {{ $shipment->id == $return->shipment_id ? 'selected' : '' }}>
                  #{{ $shipment->id }} - {{ $shipment->destination }}
                </option>
              @endforeach
            </select>
          </div>
        </div>

        <div class="row">
          {{-- Jumlah --}}
          <div class="col-md-4 mb-3">
            <label for="quantity" class="form-label fw-semibold">
              <i class="bi bi-123 me-1 text-success"></i> Jumlah Barang
            </label>
            <input type="number" name="quantity" id="quantity" 
                   class="form-control" min="1"
                   value="{{ old('quantity', $return->quantity) }}" required>
          </div>

          {{-- Kerugian --}}
          <div class="col-md-4 mb-3">
            <label for="loss" class="form-label fw-semibold">
              <i class="bi bi-cash-stack me-1 text-success"></i> Total Kerugian (Rp)
            </label>
            <input type="number" step="0.01" name="loss" id="loss"
                   class="form-control"
                   value="{{ old('loss', $return->loss) }}" required>
          </div>

          {{-- Restock --}}
          <div class="col-md-4 mb-3">
            <label for="restock" class="form-label fw-semibold">
              <i class="bi bi-arrow-repeat me-1 text-success"></i> Restock?
            </label>
            <select name="restock" id="restock" class="form-select" required>
              <option value="0" {{ !$return->restock ? 'selected' : '' }}>Tidak</option>
              <option value="1" {{ $return->restock ? 'selected' : '' }}>Ya</option>
            </select>
          </div>
        </div>

        {{-- Alasan Retur --}}
        <div class="mb-3">
          <label for="reason" class="form-label fw-semibold">
            <i class="bi bi-chat-left-text me-1 text-success"></i> Alasan Retur
          </label>
          <textarea name="reason" id="reason" class="form-control" rows="3"
                    placeholder="Tuliskan alasan retur..."
                    required>{{ old('reason', $return->reason) }}</textarea>
        </div>

        {{-- Tombol simpan --}}
        <div class="text-end mt-4">
          <button type="submit" class="btn btn-success px-4">
            <i class="bi bi-save2 me-1"></i> Simpan Perubahan
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

{{-- Sedikit CSS tambahan --}}
<style>
  .form-label i { opacity: 0.85; }
  .card {
    border-radius: 15px;
    background: #ffffff;
  }
  .btn-success {
    background: linear-gradient(135deg, #4cb070, #2f7a52);
    border: none;
  }
  .btn-success:hover {
    background: linear-gradient(135deg, #3ca65a, #256b46);
  }
</style>
@endsection
