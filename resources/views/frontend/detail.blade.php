@extends('layouts.frontend')

@section('title', $product->name)

@section('content')
  <section class="py-3 py-lg-5 bg-light position-relative overflow-hidden" style="min-height: 90vh;">
    {{-- Decorative Background Elements --}}
    <div class="position-absolute top-0 start-0 w-100 h-100 pe-none opacity-50"
      style="background: radial-gradient(circle at 10% 20%, rgba(60, 166, 90, 0.05) 0%, transparent 40%), radial-gradient(circle at 90% 80%, rgba(60, 166, 90, 0.05) 0%, transparent 40%);">
    </div>

    <div class="container position-relative z-1">
      {{-- Breadcrumb --}}
      <nav aria-label="breadcrumb" class="mb-3 mb-lg-4 animate-fade-down">
        <ol class="breadcrumb mb-0">
          <li class="breadcrumb-item"><a href="{{ route('home') }}"
              class="text-decoration-none text-muted small hover-success">Beranda</a></li>
          <li class="breadcrumb-item"><a href="{{ route('menu') }}"
              class="text-decoration-none text-muted small hover-success">Menu</a></li>
          <li class="breadcrumb-item active text-success fw-bold small" aria-current="page">{{ $product->name }}</li>
        </ol>
      </nav>

      <div class="row g-4 g-lg-5 align-items-start">
        {{-- Product Image Section --}}
        <div class="col-lg-6 mb-4 mb-lg-0 animate-fade-up">
          <div class="position-relative p-3 p-lg-4 bg-white rounded-5 shadow-sm overflow-hidden group sticky-lg-top"
            style="top: 2rem; z-index: 10;">
            <div class="ratio ratio-1x1 rounded-4 overflow-hidden bg-light position-relative">
              <img src="{{ asset('images/products/' . $product->image) }}" alt="{{ $product->name }}"
                class="w-100 h-100 object-fit-cover transition-transform duration-500 group-hover-scale {{ $product->stock <= 0 ? 'grayscale-filter' : '' }}">
            </div>

            <div class="position-absolute top-0 start-0 m-4 m-lg-5 d-flex flex-column gap-2">
              @if($product->stock <= 0)
                <span class="badge bg-danger bg-gradient rounded-pill px-3 py-2 shadow-sm small fw-bold">
                  Stok Habis
                </span>
              @elseif($product->stock < 5)
                <span class="badge bg-warning text-dark bg-gradient rounded-pill px-3 py-2 shadow-sm small fw-bold">
                  Sisa Stok: {{ $product->stock }}
                </span>
              @else
                <span class="badge bg-success bg-gradient rounded-pill px-3 py-2 shadow-sm small fw-bold">
                  Stok: {{ $product->stock }}
                </span>
              @endif
            </div>
          </div>
        </div>

        {{-- Product Details Section --}}
        <div class="col-lg-6 animate-fade-up delay-100">
          <div class="ps-lg-4">
            <h5 class="text-success fw-bold text-uppercase small letter-spacing-2 mb-2">
              {{ $product->category->name ?? 'Menu Favorit' }}
            </h5>
            <h1 class="display-5 display-lg-4 fw-bolder text-dark mb-2 mb-lg-3 fs-1"
              style="font-family: 'Outfit', sans-serif;">
              {{ $product->name }}
            </h1>

            <div class="d-flex align-items-center mb-4">
              <h2 class="text-success fw-bold mb-0 me-3 fs-2 fs-lg-1">
                Rp {{ number_format($product->price_sale, 0, ',', '.') }}
              </h2>
              @if($product->price > $product->price_sale)
                <span class="text-muted text-decoration-line-through fs-6 fs-lg-5">
                  Rp {{ number_format($product->price, 0, ',', '.') }}
                </span>
              @endif
            </div>

            <p class="text-muted lead fs-6 mb-4 mb-lg-5" style="line-height: 1.8;">
              {{ $product->description }}
            </p>

            <hr class="border-light mb-4 mb-lg-5">

            @if($product->stock > 0)
              <form action="{{ route('cart.add') }}" method="POST" class="animate-fade-up delay-200">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">

                <div class="row g-3 align-items-end">
                  <div class="col-sm-5 col-6">
                    <label class="form-label text-dark fw-bold small mb-2">Jumlah Pesanan</label>
                    <div class="input-group border rounded-pill overflow-hidden bg-white shadow-sm p-1">
                      <button type="button"
                        class="btn btn-white rounded-circle border-0 text-success fw-bold px-2 px-lg-3 hover-bg-light"
                        onclick="decrementValue()">
                        <i class="bi bi-dash-lg"></i>
                      </button>
                      <input type="number" name="quantity" id="quantity"
                        class="form-control border-0 text-center fw-bold bg-transparent mx-0 mx-lg-1" value="1" min="1"
                        max="{{ $product->stock }}" style="width: 40px;">
                      <button type="button"
                        class="btn btn-white rounded-circle border-0 text-success fw-bold px-2 px-lg-3 hover-bg-light"
                        onclick="incrementValue()">
                        <i class="bi bi-plus-lg"></i>
                      </button>
                    </div>
                    <div class="text-muted xsmall mt-2 ps-2">Maks: {{ $product->stock }}</div>
                  </div>

                  <div class="col-sm-7 col-12">
                    <div class="d-flex gap-2">
                      <button @auth type="submit" @else type="button"
                      onclick="window.location.href='{{ route('login') }}?alert=login_required'" @endauth name="type"
                        value="cart"
                        class="btn btn-outline-success rounded-pill flex-grow-1 py-3 fw-bold shadow-sm hover-translate transition-all">
                        <i class="bi bi-cart-plus me-1"></i> <span class="small">Keranjang</span>
                      </button>
                      <button @auth type="submit" @else type="button"
                      onclick="window.location.href='{{ route('login') }}?alert=login_required'" @endauth name="type"
                        value="checkout"
                        class="btn btn-success rounded-pill flex-grow-1 py-3 fw-bold shadow-lg hover-translate hover-shadow-success transition-all">
                        <i class="bi bi-bag-check-fill me-1"></i> <span class="small">Beli Langsung</span>
                      </button>
                    </div>
                  </div>
                </div>
              </form>
            @else
              <div
                class="alert alert-danger border-0 shadow-sm rounded-4 animate-fade-up delay-200 d-flex align-items-center gap-3 p-3">
                <div class="bg-white text-danger rounded-circle p-2 shadow-sm">
                  <i class="bi bi-x-circle-fill fs-4"></i>
                </div>
                <div>
                  <h6 class="fw-bold mb-0">Maaf, Stok Habis!</h6>
                  <p class="mb-0 small opacity-75">Silakan cek kembali nanti atau pilih menu lainnya.</p>
                </div>
              </div>
            @endif
          </div>
        </div>
      </div>
    </div>
  </section>

  <style>
    /* Custom Animations & Interactions */
    .hover-success:hover {
      color: #198754 !important;
    }

    .letter-spacing-2 {
      letter-spacing: 2px;
    }

    .group:hover .group-hover-scale {
      transform: scale(1.05);
    }

    .duration-500 {
      transition-duration: 500ms;
    }

    .hover-translate:hover {
      transform: translateY(-3px);
    }

    .hover-shadow-success:hover {
      box-shadow: 0 10px 25px rgba(25, 135, 84, 0.3) !important;
    }

    /* Quantity Input cleanup */
    input[type=number]::-webkit-inner-spin-button,
    input[type=number]::-webkit-outer-spin-button {
      -webkit-appearance: none;
      margin: 0;
    }

    /* Animations */
    @keyframes fadeUp {
      from {
        opacity: 0;
        transform: translateY(20px);
      }

      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .animate-fade-up {
      animation: fadeUp 0.8s cubic-bezier(0.2, 0.8, 0.2, 1) forwards;
      opacity: 0;
    }

    @keyframes fadeDown {
      from {
        opacity: 0;
        transform: translateY(-20px);
      }

      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .animate-fade-down {
      animation: fadeDown 0.8s cubic-bezier(0.2, 0.8, 0.2, 1) forwards;
      opacity: 0;
    }

    .delay-100 {
      animation-delay: 0.1s;
    }

    .delay-200 {
      animation-delay: 0.2s;
    }

    .grayscale-filter {
      filter: grayscale(100%);
      opacity: 0.6;
    }
  </style>

  <script>
    function incrementValue() {
      var quantityInput = document.getElementById('quantity');
      var value = parseInt(quantityInput.value, 10);
      var max = parseInt(quantityInput.getAttribute('max'), 10) || 100; // Default 100 if no max

      value = isNaN(value) ? 0 : value;
      if (value < max) {
        value++;
        quantityInput.value = value;
      }
    }

    function decrementValue() {
      var value = parseInt(document.getElementById('quantity').value, 10);
      value = isNaN(value) ? 0 : value;
      if (value > 1) {
        value--;
        document.getElementById('quantity').value = value;
      }
    }
  </script>
@endsection