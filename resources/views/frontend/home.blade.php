@extends('layouts.frontend')

@section('title', 'Beranda')

@section('content')

{{-- HERO SECTION --}}
<section class="hero my-5 p-5 shadow-sm rounded-4 bg-light position-relative overflow-hidden">
  <div class="row align-items-center">
    <div class="col-md-6 text-start">
      <h1 class="fw-bold text-success mb-3">
        Hangat & Lezat dari Dapur <span class="text-dark">Bakso Siocay</span> 
      </h1>
      <p class="text-muted mb-4">
        Nikmati bakso daging & ayam pilihan serta kopi khas Siocay yang siap menemani harimu.  
        Cita rasa lokal, kualitas istimewa!
      </p>
      <a href="{{ url('/menu') }}" class="btn btn-green btn-lg">
        <i class="bi bi-basket2-fill me-1"></i> Lihat Menu
      </a>
    </div>
    <div class="col-md-6 text-center">
      <img src="{{ asset('images/logo.jpg') }}" alt="Bakso Siocay" class="img-fluid rounded-4 shadow-sm animate-float" style="max-width: 420px;">
    </div>
  </div>
</section>

{{-- MENU REKOMENDASI --}}
<section class="menu-rekomendasi mt-5">
  <div class="text-center mb-5">
    <h2 class="fw-bold text-success">🍲 Menu Unggulan Kami</h2>
    <p class="text-muted">Lezatnya tiada dua — racikan khas dari Bakso Siocay 💚</p>
  </div>

  <div class="row justify-content-center">
    @forelse($products as $product)
      <div class="col-md-4 mb-4">
        <div class="card border-0 shadow-sm h-100 hover-scale">
          <img src="{{ asset('images/products/'.$product->image) }}" 
               class="card-img-top" 
               alt="{{ $product->name }}" 
               style="height:240px; object-fit:cover;">
          <div class="card-body text-center">
            <h5 class="card-title fw-bold">{{ $product->name }}</h5>
            <p class="text-success fw-semibold mb-1">Rp {{ number_format($product->price_sale, 0, ',', '.') }}</p>
            <p class="text-muted small">{{ Str::limit($product->description, 90) }}</p>
            <a href="{{ url('/' . $product->slug) }}" class="btn btn-green btn-sm mt-2">
              <i class="bi bi-bag-check-fill me-1"></i> Pesan Sekarang
            </a>
          </div>
        </div>
      </div>
    @empty
      <div class="col-12 text-center">
        <p class="text-muted">Belum ada produk yang tersedia saat ini.</p>
      </div>
    @endforelse
  </div>
</section>

{{-- TESTIMONI --}}
<section class="testimoni mt-5 py-5 bg-white rounded-4 shadow-sm">
  <div class="text-center mb-4">
    <h2 class="fw-bold text-success">💬 Kata Pelanggan Kami</h2>
    <p class="text-muted">Rasa tak pernah bohong, pelanggan selalu datang kembali!</p>
  </div>
  <div class="row justify-content-center">
    <div class="col-md-4 mb-4">
      <div class="p-4 bg-light rounded-3 shadow-sm h-100 text-center">
        <p class="fst-italic text-muted">
          “Baksonya kenyal banget dan kuahnya gurih! Anak saya suka sekali 😋”
        </p>
        <h6 class="fw-bold mt-3 text-success">- Ibu Rini, Pelanggan Setia</h6>
      </div>
    </div>
    <div class="col-md-4 mb-4">
      <div class="p-4 bg-light rounded-3 shadow-sm h-100 text-center">
        <p class="fst-italic text-muted">
          “Kopi Siocay aroma dan rasanya khas banget, pas buat sore hari ☕”
        </p>
        <h6 class="fw-bold mt-3 text-success">- Bapak Andi, Pecinta Kopi</h6>
      </div>
    </div>
    <div class="col-md-4 mb-4">
      <div class="p-4 bg-light rounded-3 shadow-sm h-100 text-center">
        <p class="fst-italic text-muted">
          “Harga bersahabat, pelayanan cepat, dan tempatnya nyaman 💚”
        </p>
        <h6 class="fw-bold mt-3 text-success">- Dinda, Mahasiswa PNP</h6>
      </div>
    </div>
  </div>
</section>

{{-- LOKASI & KONTAK --}}
<section class="lokasi mt-5">
  <div class="text-center mb-4">
    <h2 class="fw-bold text-success">📍 Temukan Kami</h2>
    <p class="text-muted">Kunjungi warung kami dan rasakan kehangatannya langsung!</p>
  </div>
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="ratio ratio-16x9 rounded-3 shadow-sm">
        <iframe 
          src="https://www.google.com/maps/embed?pb=!1m18!..." 
          width="600" height="450" style="border:0;" 
          allowfullscreen="" loading="lazy">
        </iframe>
      </div>
    </div>
  </div>
  <div class="text-center mt-4">
    <a href="https://wa.me/6281234567890?text=Halo%20Bakso%20Siocay,%20saya%20ingin%20pesan%20bakso%20dong!" 
       target="_blank" class="btn btn-success btn-lg">
      <i class="bi bi-whatsapp"></i> Pesan via WhatsApp
    </a>
  </div>
</section>

@endsection

@push('styles')
<style>
  .btn-green {
    background: linear-gradient(135deg, #3ca65a, #2f7a52);
    color: #fff;
    border: none;
    border-radius: 10px;
    padding: 10px 18px;
    transition: 0.3s;
  }
  .btn-green:hover {
    background: linear-gradient(135deg, #2f7a52, #3ca65a);
    transform: translateY(-2px);
  }
  .hover-scale {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
  }
  .hover-scale:hover {
    transform: scale(1.03);
    box-shadow: 0 6px 16px rgba(0,0,0,0.15);
  }
  .animate-float {
    animation: float 3s ease-in-out infinite;
  }
  @keyframes float {
    0% { transform: translateY(0px); }
    50% { transform: translateY(-8px); }
    100% { transform: translateY(0px); }
  }
</style>
@endpush
