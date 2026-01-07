@extends('layouts.frontend')

@section('title', 'Beranda')

@section('content')

    {{-- 1. HERO SECTION --}}
    <section class="hero-custom position-relative mb-5 overflow-visible pt-4 pt-lg-5">
        <div class="container position-relative z-2">
            <div class="row align-items-center">
                <div class="col-lg-6 text-center text-lg-start mb-5 mb-lg-0 pe-lg-5">
                    {{-- Badge --}}
                    <div
                        class="d-inline-flex align-items-center gap-2 mb-3 bg-white px-3 py-2 rounded-pill shadow-sm border border-success border-opacity-25 animate-fade-down hover-lift">
                        <span class="d-flex align-items-center justify-content-center bg-warning text-dark rounded-circle"
                            style="width: 24px; height: 24px;"><i class="bi bi-trophy-fill"
                                style="font-size: 12px;"></i></span>
                        <span class="text-success fw-bold uppercase-tracking small ls-1" style="font-size: 0.8rem;">#1 Bakso
                            & Kopi Pilihan</span>
                    </div>

                    {{-- Headline --}}
                    <h1 class="display-5 fw-bolder text-dark mb-3 animate-fade-right lh-sm"
                        style="font-family: 'Outfit', sans-serif;">
                        Rasakan <span class="position-relative text-gradient d-inline-block">Kehangatan
                            <svg class="position-absolute start-0 w-100" style="bottom: -5px; height: 10px; z-index: -1;"
                                viewBox="0 0 100 20" preserveAspectRatio="none">
                                <path d="M0 15 Q 50 25 100 15" stroke="rgba(60, 166, 90, 0.3)" stroke-width="8"
                                    fill="none" />
                            </svg>
                        </span> <br>
                        Dalam Setiap Suapan
                    </h1>

                    {{-- Subheadline --}}
                    <p class="lead text-muted mb-4 animate-fade-right delay-100 fs-6 pe-lg-5" style="line-height: 1.7;">
                        Nikmati perpaduan sempurna bakso daging asli dan kopi pilihan.
                        Disajikan segar, higienis, dan penuh cinta untukmu.
                    </p>

                    {{-- Buttons --}}
                    <div
                        class="d-flex flex-column flex-sm-row justify-content-center justify-content-lg-start gap-3 animate-fade-up delay-200">
                        <a href="{{ url('/menu') }}"
                            class="btn btn-success rounded-pill px-4 py-3 fw-bold shadow-lg hover-scale d-flex align-items-center justify-content-center gap-2">
                            <span>Pesan Sekarang</span> <i class="bi bi-arrow-right-circle-fill"></i>
                        </a>
                        <a href="#menu-utama"
                            class="btn btn-white rounded-pill px-4 py-3 fw-bold shadow-sm border hover-scale text-dark d-flex align-items-center justify-content-center gap-2">
                            <i class="bi bi-book-half text-success"></i> <span>Lihat Menu</span>
                        </a>
                    </div>

                    {{-- Mini Stats --}}
                    <div
                        class="d-flex justify-content-center justify-content-lg-start align-items-center gap-4 mt-4 pt-3 animate-fade-up delay-300 border-top border-light">
                        <div class="d-flex align-items-center gap-2">
                            <div class="avatar-group d-flex">
                                <div class="avatar bg-light border border-white rounded-circle"
                                    style="width:30px; height:30px;"></div>
                                <div class="avatar bg-secondary border border-white rounded-circle"
                                    style="width:30px; height:30px; margin-left:-8px;"></div>
                                <div class="avatar bg-success border border-white rounded-circle d-flex align-items-center justify-content-center text-white"
                                    style="width:30px; height:30px; margin-left:-8px; font-size: 0.7rem;">+1k</div>
                            </div>
                            <div class="d-flex flex-column lh-1 text-start">
                                <span class="fw-bold text-dark small">Pelanggan Puas</span>
                                <small class="text-warning" style="font-size: 0.75rem;"><i class="bi bi-star-fill"></i> 4.9
                                    (1.2k Review)</small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 position-relative text-center">
                    {{-- Complex Image Shape --}}
                    <div class="hero-composition position-relative d-inline-block px-3">
                        {{-- Decorative Back Blob --}}
                        <div class="position-absolute top-50 start-50 translate-middle w-100 h-100 bg-success opacity-10 rounded-pill rotate-12 blur-lg"
                            style="z-index: 0; transform: translate(-50%, -50%) rotate(12deg) scale(0.9);"></div>

                        {{-- Main Image Mask --}}
                        @php
                            $heroImage = $products->first() ? asset('images/products/' . $products->first()->image) : 'https://via.placeholder.com/500x500?text=Bakso+Siocay';
                        @endphp
                        <div class="mask-container position-relative z-2 mx-auto"
                            style="border-radius: 40% 60% 70% 30% / 40% 50% 60% 50%; overflow: hidden; box-shadow: 0 20px 40px -10px rgba(0, 0, 0, 0.2); max-width: 380px;">
                            <img src="{{ $heroImage }}" alt="Bakso Siocay Hero"
                                class="img-fluid object-fit-cover hover-zoom"
                                style="width: 100%; height: auto; aspect-ratio: 4/5;">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- 2. CATEGORY STRIP --}}
    <section id="menu-utama" class="category-strip-section mb-5 position-relative z-3" style="margin-top: -30px;">
        <div class="container">
            <div class="category-container bg-success rounded-5 p-4 shadow-lg text-white position-relative overflow-hidden">
                <div class="pattern-overlay"></div>
                <div class="row align-items-center position-relative z-2">
                    <div class="col-lg-3 text-center text-lg-start mb-3 mb-lg-0">
                        <h5 class="fw-bold mb-1">Jelajahi Menu</h5>
                        <p class="mb-0 text-white-50 small">Pilihan favorit #TemanSiocay</p>
                    </div>
                    <div class="col-lg-9">
                        <div class="row g-2 justify-content-center justify-content-lg-end">
                            @foreach(['Bakso' => 'egg-fried', 'Kopi' => 'cup-hot-fill', 'Minum' => 'cup-straw', 'Lainnya' => 'grid-fill'] as $cat => $icon)
                                <div class="col-3 col-sm-2">
                                    <a href="#"
                                        class="cat-pill bg-white text-success d-block text-center rounded-4 py-2 py-md-3 text-decoration-none shadow-sm hover-up">
                                        <i class="bi bi-{{ $icon }} fs-4 mb-1 d-block"></i> <small class="fw-bold"
                                            style="font-size: 0.75rem;">{{ $cat }}</small>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- 3. PRODUCT GRID --}}
    <section class="mb-5">
        <div class="container">
            <div class="d-flex justify-content-between align-items-end mb-4">
                <div>
                    <h3 class="fw-bold text-dark">Rekomendasi Spesial</h3>
                    <div class="h-line bg-success rounded-pill"></div>
                </div>
                <a href="{{ url('/menu') }}" class="btn btn-outline-success rounded-pill px-4 fw-bold hover-scale btn-sm">
                    Lihat Semua
                </a>
            </div>

            <div class="row g-2 g-md-4">
                @forelse($products->take(4) as $product)
                    <div class="col-6 col-md-4 col-lg-3">
                            <div
                                class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden product-card-hover group position-relative bg-white pb-0">
                                <div class="img-container position-relative overflow-hidden bg-light" style="height: 180px;">
                                    <a href="{{ route('produk.show', $product->id) }}" class="d-block w-100 h-100 {{ $product->stock <= 0 ? 'grayscale-filter' : '' }}">
                                        <img src="{{ asset('images/products/' . $product->image) }}"
                                            class="w-100 h-100 object-fit-cover transition-scale" alt="{{ $product->name }}">
                                    </a>

                                    {{-- Stock Badge (Top Left) --}}
                                    <div class="position-absolute top-0 start-0 m-2 z-2">
                                        @if($product->stock <= 0)
                                            <span class="badge bg-danger shadow-sm fw-bold border border-white">
                                                Stok Habis
                                            </span>
                                        @elseif($product->stock < 5)
                                            <span class="badge bg-warning text-dark shadow-sm fw-bold border border-white">
                                                Sisa: {{ $product->stock }}
                                            </span>
                                        @else
                                            <span class="badge bg-success bg-opacity-75 shadow-sm fw-normal border border-white" style="font-size: 0.7rem;">
                                                Stok: {{ $product->stock }}
                                            </span>
                                        @endif
                                    </div>

                                    @if($product->stock > 0)
                                        {{-- Hover Action Overlay --}}
                                        <div
                                            class="overlay position-absolute top-0 start-0 w-100 h-100 bg-dark bg-opacity-20 opacity-0 group-hover:opacity-100 transition-opacity d-flex align-items-center justify-content-center gap-2 backdrop-blur-sm pe-none">
                                            <form action="{{ route('cart.add') }}" method="POST" class="d-inline pe-auto">
                                                @csrf
                                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                                <input type="hidden" name="quantity" value="1">
                                                <button type="submit"
                                                    class="btn btn-success btn-sm rounded-circle shadow-lg hover-scale p-2 border-0"
                                                    data-bs-toggle="tooltip" title="Tambah ke Keranjang">
                                                    <i class="bi bi-cart-plus-fill fs-5"></i>
                                                </button>
                                            </form>
                                        </div>
                                    @else
                                        {{-- Sold Out Overlay --}}
                                        <div class="position-absolute top-0 start-0 w-100 h-100 bg-dark bg-opacity-10 d-flex align-items-center justify-content-center pe-none">
                                            <div class="bg-dark text-white px-3 py-1 rounded-pill shadow fw-bold small opacity-75">
                                                Habis
                                            </div>
                                        </div>
                                    @endif

                                    {{-- Rating Badge --}}
                                    <div class="position-absolute bottom-0 start-0 m-2">
                                        <span
                                            class="badge bg-white text-dark shadow-sm fw-bold border border-success border-opacity-25"
                                            style="font-size: 0.7rem;">
                                            <i class="bi bi-star-fill text-warning"></i> 5.0
                                        </span>
                                    </div>
                                </div>

                                <div class="card-body px-3 pt-3 pb-3 text-start d-flex flex-column">
                                    <div class="mb-1">
                                        <h6 class="fw-bold text-dark mb-0 text-truncate {{ $product->stock <= 0 ? 'text-muted' : '' }}" style="font-family: 'Outfit', sans-serif;">
                                            {{ $product->name }}</h6>
                                    </div>

                                    <p class="text-muted xsmall mb-2 text-truncate d-none d-md-block" style="font-size: 0.75rem;">
                                        {{ Str::limit($product->description ?? 'Nikmati kelezatan asli...', 40) }}
                                    </p>

                                    <div class="d-flex justify-content-between align-items-center mt-auto">
                                        <span class="text-success fw-bold {{ $product->stock <= 0 ? 'text-decoration-line-through opacity-50' : '' }}" style="font-size: 0.95rem;">Rp
                                            {{ number_format($product->price_sale, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                            </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-5 bg-light rounded-4">
                        <h5 class="text-muted">Belum ada menu yang tersedia.</h5>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    {{-- 4. CARA PESAN (Improved) --}}
    <section class="mb-5 py-5 section-how-to-order position-relative overflow-hidden rounded-5 mx-3 mx-lg-0"
        style="background-color: #f0fdf4;">
        {{-- Background Elements --}}
        <div class="position-absolute top-0 start-0 w-100 h-100"
            style="background-image: radial-gradient(#3ca65a 0.5px, transparent 0.5px); background-size: 15px 15px; opacity: 0.15;">
        </div>

        <div class="container position-relative z-2">
            <div class="text-center mb-5">
                <h2 class="fw-bold fs-2 mb-2 text-dark">Cara Pesan Tanpa Ribet</h2>
                <p class="text-muted mx-auto small" style="max-width: 500px;">
                    Tinggal klik, bakso hangat dan kopi nikmat langsung meluncur ke tempatmu!
                </p>
            </div>

            <div class="row g-4 justify-content-center position-relative">
                {{-- Connector Line (Desktop) --}}
                <div class="d-none d-lg-block position-absolute start-0 end-0 top-50 translate-middle-y border-top border-2 border-success border-opacity-25 border-dashed"
                    style="z-index: 1; transform: translateY(-20px);"></div>

                @php
                    $steps = [
                        ['icon' => 'phone-vibrate', 'color' => 'success', 'title' => '1. Pilih Menu', 'desc' => 'Cari menu yang bikin ngiler di halaman ini.'],
                        ['icon' => 'whatsapp', 'color' => 'warning', 'title' => '2. Klik Pesan', 'desc' => 'Terhubung otomatis ke WhatsApp Admin kami.'],
                        ['icon' => 'truck', 'color' => 'info', 'title' => '3. Kami Antar', 'desc' => 'Tunggu sebentar, kurir segera sampai!']
                    ];
                @endphp

                @foreach($steps as $step)
                    <div class="col-md-4 col-lg-3">
                        <div
                            class="step-card bg-white p-4 rounded-5 shadow-sm h-100 position-relative text-center hover-up z-2 border border-2 border-light transition-all">
                            <div class="icon-circle bg-{{ $step['color'] }}-subtle text-{{ $step['color'] }} rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center shadow-inner"
                                style="width: 65px; height: 65px; font-size: 1.6rem;">
                                <i class="bi bi-{{ $step['icon'] }}"></i>
                            </div>
                            <h5 class="fw-bold mt-2 mb-2">{{ $step['title'] }}</h5>
                            <p class="text-muted small mb-0 lh-sm">{{ $step['desc'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- 5. INFO LOKASI (Full Width Map with Floating Card) --}}
    <section class="mb-5 pb-5">
        <div class="container">
            <div class="position-relative rounded-5 overflow-hidden shadow-lg border border-3 border-white"
                style="height: 450px;">
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.521260322298!2d106.8191598143154!3d-6.194449195508445!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f5396b5e8f1f%3A0x3a5d2f5e5a5a5a5a!2sJakarta!5e0!3m2!1sid!2sid!4v1234567890123!5m2!1sid!2sid"
                    width="100%" height="100%" style="border:0; filter: grayscale(20%);" allowfullscreen="" loading="lazy">
                </iframe>

                {{-- Floating Info Card --}}
                <div class="position-absolute top-50 start-0 translate-middle-y ms-md-5 p-3"
                    style="z-index: 2; max-width: 90%; width: 350px;">
                    <div class="bg-white p-4 rounded-4 shadow-lg border-start border-5 border-success animate-fade-right">
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center"
                                style="width: 40px; height: 40px;">
                                <i class="bi bi-shop"></i>
                            </div>
                            <h4 class="fw-bold mb-0 text-dark">Mampir Yuk!</h4>
                        </div>

                        <div class="d-flex flex-column gap-3">
                            <div class="d-flex gap-3">
                                <i class="bi bi-geo-alt text-danger mt-1"></i>
                                <div>
                                    <h6 class="fw-bold mb-0 small">Alamat</h6>
                                    <p class="text-muted small mb-0">Jl. Alai No. 23, Padang </p>
                                </div>
                            </div>
                            <div class="d-flex gap-3">
                                <i class="bi bi-clock text-primary mt-1"></i>
                                <div>
                                    <h6 class="fw-bold mb-0 small">Jam Buka</h6>
                                    <p class="text-muted small mb-0">Setiap Hari: 10.00 - 22.00</p>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4 pt-3 border-top">
                            <a href="https://maps.google.com" target="_blank"
                                class="btn btn-dark w-100 rounded-pill btn-sm fw-bold">
                                <i class="bi bi-map-fill me-2"></i> Petunjuk Arah
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@push('styles')
    <style>
        /* VARIABLES */
        :root {
            --color-primary: #3ca65a;
            --color-secondary: #2f7a52;
            --bg-soft: #f4fcf6;
        }

        .text-gradient {
            background: linear-gradient(135deg, var(--color-primary), var(--color-secondary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .blob-bg-hero {
            width: 450px;
            height: 450px;
            background-color: rgba(60, 166, 90, 0.1);
            border-radius: 40% 60% 70% 30% / 40% 50% 60% 50%;
            filter: blur(60px);
            animation: blob-ani 8s infinite alternate;
        }

        @keyframes blob-ani {
            0% {
                transform: translate(-50%, -50%) rotate(0deg);
            }

            100% {
                transform: translate(-50%, -50%) rotate(360deg);
                border-radius: 60% 40% 30% 70% / 60% 30% 70% 40%;
            }
        }

        .hero-img-main {
            width: 380px;
            height: 380px;
        }

        .floating-badge {
            z-index: 5;
            min-width: 160px;
        }

        .badge-1 {
            top: 20%;
            left: 0;
            animation: float 3s ease-in-out infinite;
        }

        .badge-2 {
            bottom: 20%;
            right: 0;
            animation: float 4s ease-in-out infinite;
        }

        .icon-circle {
            width: 40px;
            height: 40px;
            font-size: 1.2rem;
        }

        /* Category Strip */
        .cat-pill:hover {
            background-color: #e9f6ec !important;
            transform: translateY(-5px);
        }

        /* Product Card */
        .product-card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1) !important;
        }

        .transition-scale {
            transition: transform 0.5s;
        }

        .product-card-hover:hover .transition-scale {
            transform: scale(1.1);
        }

        /* Section Divider */
        .h-line {
            width: 80px;
            height: 5px;
            margin-top: 5px;
        }

        /* Animations */
        @keyframes float {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-10px);
            }
        }

        .animate-float {
            animation: float 5s ease-in-out infinite;
        }

        .hover-scale {
            transition: 0.3s;
        }

        .hover-scale:hover {
            transform: scale(1.05);
        }

        .hover-up {
            transition: 0.3s;
        }

        .hover-up:hover {
            transform: translateY(-5px);
        }

        /* Responsive */
        @media (max-width: 991px) {
            .hero-img-main {
                width: 280px;
                height: 280px;
            }

            .blob-bg-hero {
                width: 300px;
                height: 300px;
            }

            .display-3 {
                font-size: 2.5rem;
            }
        }

        @media (max-width: 576px) {
            .hero-img-main {
                width: 240px;
                height: 240px;
            }

            .category-strip-section {
                margin-top: 0;
            }

            .fs-1 {
                font-size: 1.5rem !important;
            }
        }

        /* Card Hover Overlay Helper */
        .group:hover .group-hover\:opacity-100 {
            opacity: 1 !important;
        }

        .transition-opacity {
            transition: opacity 0.3s ease;
        }

        .backdrop-blur-sm {
            backdrop-filter: blur(2px);
        }

        .cursor-pointer {
            cursor: pointer;
        }

        .grayscale-filter {
            filter: grayscale(100%);
            opacity: 0.6;
        }
    </style>
@endpush