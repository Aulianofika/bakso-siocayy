@extends('layouts.frontend')
@section('title', $product->name)

@section('content')
<div class="row justify-content-center g-4">
  <div class="col-12 col-md-5">
    <img src="{{ asset('images/products/'.$product->image) }}" 
         alt="{{ $product->name }}" 
         class="img-fluid rounded-4 shadow-sm w-100"
         style="max-height: 500px; object-fit: cover;">
  </div>

  <div class="col-12 col-md-6">
    <h3 class="fw-bold text-success">{{ $product->name }}</h3>
    <p class="text-muted">{{ $product->category->name ?? 'Tanpa kategori' }}</p>
    <h4 class="text-success fw-bold mb-3">
      Rp {{ number_format($product->price_sale, 0, ',', '.') }}
    </h4>

    <p class="text-muted">{{ $product->description }}</p>

    <hr>

    @auth
      <form action="{{ route('cart.add') }}" method="POST">
        @csrf
        <input type="hidden" name="product_id" value="{{ $product->id }}">
        <div class="d-flex align-items-center mb-3" style="max-width: 180px;">
          <label class="form-label me-2 mb-0">Jumlah:</label>
          <input type="number" name="quantity" class="form-control text-center" min="1" value="1" required>
        </div>
        <button type="submit" class="btn btn-green btn-lg w-100 w-md-auto">
          <i class="bi bi-cart-plus me-1"></i> Tambah ke Keranjang
        </button>
      </form>
    @else
      <div class="alert alert-info mb-3">
        <i class="bi bi-info-circle me-2"></i> Silakan login terlebih dahulu untuk menambahkan produk ke keranjang.
      </div>
      <a href="{{ route('login') }}?redirect={{ urlencode(request()->fullUrl()) }}" class="btn btn-green btn-lg w-100 w-md-auto">
        <i class="bi bi-box-arrow-in-right me-1"></i> Login untuk Memesan
      </a>
    @endauth
  </div>
</div>
@endsection
