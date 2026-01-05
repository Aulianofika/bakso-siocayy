@extends('layouts.frontend')
@section('title', 'Menu Produk')

@section('content')

<section class="text-center mb-4">
  <h2 class="fw-bold text-success">🍜 Menu Bakso Siocay</h2>
  <p class="text-muted small d-none d-md-block">
    Pilih menu favoritmu dan pesan sekarang
  </p>
</section>

<div class="row g-3 g-md-4">
  @forelse($products as $product)
    <div class="col-lg-4 col-md-6 col-6">
      <div class="card border-0 shadow-sm h-100 card-custom">

        <img src="{{ asset('images/products/'.$product->image) }}"
             class="card-img-top"
             alt="{{ $product->name }}">

        <div class="card-body text-center">

          <h6 class="fw-semibold mb-1 product-name">
            {{ $product->name }}
          </h6>

          <p class="text-success fw-bold mb-2 product-price">
            Rp {{ number_format($product->price_sale, 0, ',', '.') }}
          </p>

          {{-- Deskripsi hanya desktop --}}
          <p class="text-muted small d-none d-md-block">
            {{ Str::limit($product->description, 70) }}
          </p>

          <a href="{{ route('produk.show', $product->id) }}"
             class="btn btn-green btn-sm w-100">
            Pesan Sekarang
          </a>

        </div>
      </div>
    </div>
  @empty
    <div class="col-12 text-center text-muted">
      Menu belum tersedia.
    </div>
  @endforelse
</div>

@endsection
