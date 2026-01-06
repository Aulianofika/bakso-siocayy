@extends('layouts.frontend')
@section('title', 'Menu Produk')

@section('content')

  <section class="mb-4 position-relative overflow-hidden" style="border-radius: 0 0 40px 40px; background: linear-gradient(180deg, #f0fdf4 0%, #ffffff 100%);">
      
      <div class="container position-relative z-1 py-4">
          {{-- Header & Search --}}
          <div class="row justify-content-center mb-4 pt-1">
              <div class="col-lg-8 text-center">
                  <h1 class="display-6 fw-bolder text-dark mb-2 animate-fade-down delay-100" style="font-family: 'Outfit', sans-serif; letter-spacing: -0.5px;">
                      Temukan Rasa <span class="text-success-gradient">Favoritmu</span>
                  </h1>
                  <p class="text-muted small mb-4 animate-fade-down delay-200" style="max-width: 500px; margin: 0 auto; line-height: 1.4;">
                      Jelajahi kelezatan Bakso Siocay & Kopi pilihan terbaik.
                  </p>
                  
                  <form action="{{ route('menu') }}" method="GET" class="position-relative mx-auto animate-fade-up delay-300" style="max-width: 500px;">
                      <div class="input-group shadow-sm rounded-pill p-1 bg-white border border-light hover-shadow-sm transition-all">
                          <span class="input-group-text bg-transparent border-0 ps-3">
                              <i class="bi bi-search text-success"></i>
                          </span>
                          <input type="text" name="search" class="form-control border-0 bg-transparent text-dark form-control-sm" placeholder="Cari menu..." value="{{ request('search') }}">
                          <button type="submit" class="btn btn-success rounded-pill px-3 fw-bold m-1 btn-sm transition-transform">
                              Cari
                          </button>
                      </div>
                  </form>

                  {{-- Quick Categories --}}
                  <div class="d-flex flex-wrap justify-content-center gap-2 mt-4 animate-fade-up delay-400">
                      <a href="{{ route('menu') }}" class="btn btn-light rounded-pill px-3 py-1 border shadow-sm small {{ !request('category') ? 'active-cat ring-1 ring-success bg-success-subtle text-success' : 'text-muted bg-white' }} transition-all btn-cat" style="font-size: 0.85rem;">
                          <i class="bi bi-grid-fill me-1"></i> Semua
                      </a>
                      <a href="{{ route('menu', ['category' => 'Bakso']) }}" class="btn btn-light rounded-pill px-3 py-1 border shadow-sm small {{ request('category') == 'Bakso' ? 'active-cat ring-1 ring-success bg-success-subtle text-success' : 'text-muted bg-white' }} transition-all btn-cat" style="font-size: 0.85rem;">
                          <i class="bi bi-egg-fried me-1"></i> Bakso
                      </a>
                      <a href="{{ route('menu', ['category' => 'Kopi']) }}" class="btn btn-light rounded-pill px-3 py-1 border shadow-sm small {{ request('category') == 'Kopi' ? 'active-cat ring-1 ring-success bg-success-subtle text-success' : 'text-muted bg-white' }} transition-all btn-cat" style="font-size: 0.85rem;">
                          <i class="bi bi-cup-hot-fill me-1"></i> Kopi
                      </a>  
                  </div>
              </div>
          </div>
      </div>
  </section>
  
  <div class="container mb-5">
      {{-- Product Grid --}}
      <div class="row g-2 g-md-4">
        @forelse($products as $index => $product)
          <div class="col-lg-3 col-md-4 col-6 animate-fade-up" style="animation-delay: {{ $index * 100 }}ms;">
            <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden product-card-hover group position-relative bg-white pb-0">
              <div class="img-container position-relative overflow-hidden bg-light" style="height: 160px;">
                  <img src="{{ asset('images/products/'.$product->image) }}"
                       class="w-100 h-100 object-fit-cover transition-scale"
                       alt="{{ $product->name }}">
                  
                  {{-- Hover Action Overlay --}}
                  <div class="overlay position-absolute top-0 start-0 w-100 h-100 bg-dark bg-opacity-20 opacity-0 group-hover:opacity-100 transition-opacity d-flex align-items-center justify-content-center gap-2 backdrop-blur-sm">
                       <a href="{{ route('produk.show', $product->id) }}" class="btn btn-white btn-sm rounded-circle shadow-lg hover-scale p-2" data-bs-toggle="tooltip" title="Lihat Detail">
                           <i class="bi bi-eye-fill text-dark"></i>
                       </a>
                       
                       <form action="{{ route('cart.add') }}" method="POST" class="d-inline">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <input type="hidden" name="quantity" value="1">
                            <button type="submit" class="btn btn-success btn-sm rounded-circle shadow-lg hover-scale p-2 border-0" data-bs-toggle="tooltip" title="Tambah ke Keranjang">
                                <i class="bi bi-cart-plus-fill"></i>
                            </button>
                       </form>
                  </div>
              </div>

              <div class="card-body px-3 pt-3 pb-3 text-start d-flex flex-column">
                <div class="mb-1">
                    <h6 class="fw-bold text-dark mb-0 text-truncate" style="font-family: 'Outfit', sans-serif;">{{ $product->name }}</h6>
                </div>
                
                {{-- Hide description on mobile to save space --}}
                <p class="text-muted xsmall mb-2 text-truncate d-none d-md-block" style="font-size: 0.75rem;">{{ Str::limit($product->description, 40) }}</p>
                
                <div class="d-flex justify-content-between align-items-center mt-auto">
                    <span class="text-success fw-bold" style="font-size: 0.9rem; letter-spacing: -0.5px;">Rp {{ number_format($product->price_sale, 0, ',', '.') }}</span>
                    <form action="{{ route('cart.add') }}" method="POST" class="d-inline">
                         @csrf
                         <input type="hidden" name="product_id" value="{{ $product->id }}">
                         <input type="hidden" name="quantity" value="1">
                         <button type="submit" class="btn btn-sm btn-outline-success rounded-circle border-0 bg-success-subtle p-0 d-flex align-items-center justify-content-center shadow-sm card-btn-add" style="width: 32px; height: 32px;">
                            <i class="bi bi-plus-lg text-success" style="font-size: 1rem;"></i>
                         </button>
                    </form>
                </div>
              </div>
            </div>
          </div>
        @empty
          <div class="col-12 text-center py-5 animate-fade-up">
            <div class="bg-light rounded-4 p-4 d-inline-block shadow-sm text-center" style="max-width: 400px;">
                <div class="mb-3">
                    <i class="bi bi-search display-4 text-success opacity-25"></i>
                </div>
                <h5 class="text-dark fw-bold mb-1">Yah, Menu Tidak Ditemukan</h5>
                <p class="text-muted small mb-3">Coba kata kunci lain?</p>
                <a href="{{ route('menu') }}" class="btn btn-success rounded-pill px-4 py-1 small fw-bold shadow-sm">Lihat Semua</a>
            </div>
          </div>
        @endforelse
      </div>
      
      <div class="d-flex justify-content-center mt-4">
          {{ $products->withQueryString()->links('pagination::bootstrap-5') }}
      </div>
  </div>

  <style>
      .blur-3xl { filter: blur(60px); }
      .text-success-gradient { background: linear-gradient(135deg, #3ca65a, #2f7a52); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
      .active-cat { border-color: #3ca65a !important; box-shadow: 0 4px 12px rgba(60, 166, 90, 0.15) !important; }
      .product-card-hover { transition: transform 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275), box-shadow 0.3s ease; }
      .product-card-hover:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.08) !important; }
      .group:hover .overlay { opacity: 1; }
      .transition-scale { transition: transform 0.5s; }
      .group:hover .transition-scale { transform: scale(1.05); }
      .xsmall { font-size: 0.7rem; }
      .card-btn-add { transition: all 0.2s; }
      .card-btn-add:active { transform: scale(0.9); background-color: #3ca65a !important; color: white !important; }
      .card-btn-add:active i { color: white !important; }

      /* Animation keyframes */
      @keyframes fadeUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
      }
      .animate-fade-up { animation: fadeUp 0.6s ease-out forwards; opacity: 0; }
      
      @keyframes fadeDown {
        from { opacity: 0; transform: translateY(-20px); }
        to { opacity: 1; transform: translateY(0); }
      }
      .animate-fade-down { animation: fadeDown 0.6s ease-out forwards; opacity: 0; }
      
      .delay-100 { animation-delay: 0.1s; }
      .delay-200 { animation-delay: 0.2s; }
      .delay-300 { animation-delay: 0.3s; }
      .delay-400 { animation-delay: 0.4s; }
  </style>

@endsection