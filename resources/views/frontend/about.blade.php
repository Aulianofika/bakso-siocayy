@extends('layouts.frontend')

@section('title', 'Tentang Kami')

@section('content')
    <!-- Hero Section -->
    <div class="container py-5">
        <div class="row align-items-center mb-5">
            <div class="col-lg-6 mb-4 mb-lg-0">
                <h1 class="display-4 fw-bold text-success mb-3">Cerita Siocay</h1>
                <p class="lead text-muted mb-4">
                    Lebih dari sekadar bakso dan kopi. Kami menyajikan kehangatan dan rasa yang tak terlupakan di setiap
                    sajian.
                </p>
                <div class="d-flex gap-3">
                    <a href="{{ route('menu') }}" class="btn btn-success rounded-pill px-4 py-2 fw-medium shadow-sm">
                        Lihat Menu
                    </a>
                    <a href="#our-story" class="btn btn-outline-success rounded-pill px-4 py-2 fw-medium">
                        Kenalan Yuk
                    </a>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="position-relative">
                    <div class="position-absolute top-0 start-0 w-100 h-100 bg-success rounded-4 opacity-10"
                        style="transform: rotate(-3deg);"></div>
                    <img src="{{ asset('images/logo-siocay.png') }}" alt="Siocay Team"
                        class="img-fluid rounded-4 shadow-lg position-relative bg-white p-3"
                        style="transform: rotate(2deg);">
                </div>
            </div>
        </div>

        <!-- Our Story -->
        <div id="our-story" class="row justify-content-center py-5">
            <div class="col-lg-8 text-center">
                <h6 class="text-uppercase text-success fw-bold letter-spacing-2 mb-3">Tentang Kami</h6>
                <h2 class="fw-bold mb-4">Perjalanan Siocay</h2>
                <p class="text-muted lh-lg fs-5">
                    Awal mula Siocay berdiri setelah <i>resign</i> tahun 2018 dengan usaha bakmi dan bakso yang beralamat di
                    <strong>Jl. Lapai 1 E/4 Kampung Lapai, Nanggalo</strong>.
                </p>
                <p class="text-muted lh-lg fs-5">
                    Nama "Siocay" sendiri diambil dari nama panggilan akrab. Seiring berjalannya waktu, usaha ini terus
                    berkembang dan menunya semakin bervariasi,
                    mulai dari tahu bakso, kopi bubuk, hingga kopmil (kopi milo botolan) yang kini menjadi favorit banyak
                    pelanggan.
                </p>
            </div>
        </div>

        <!-- Vision Mission -->
        <div class="row g-4 py-5">
            <div class="col-md-6">
                <div class="card h-100 border-0 shadow-sm rounded-4 p-4 hover-lift">
                    <div class="card-body text-center">
                        <div class="d-inline-flex align-items-center justify-content-center bg-success bg-opacity-10 text-success rounded-circle mb-4"
                            style="width: 80px; height: 80px;">
                            <i class="bi bi-eye-fill fs-2"></i>
                        </div>
                        <h3 class="fw-bold mb-3">Visi Kami</h3>
                        <p class="text-muted">
                            Menjadi destinasi kuliner terdepan yang dikenal karena kualitas rasa, kebersihan, dan pelayanan
                            yang hangat,
                            serta membawa kebahagiaan melalui semangkuk bakso dan secangkir kopi.
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card h-100 border-0 shadow-sm rounded-4 p-4 hover-lift">
                    <div class="card-body text-center">
                        <div class="d-inline-flex align-items-center justify-content-center bg-success bg-opacity-10 text-success rounded-circle mb-4"
                            style="width: 80px; height: 80px;">
                            <i class="bi bi-flag-fill fs-2"></i>
                        </div>
                        <h3 class="fw-bold mb-3">Misi Kami</h3>
                        <ul class="list-unstyled text-muted text-start d-inline-block">
                            <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i> Menggunakan
                                bahan-bahan segar berkualitas terbaik.</li>
                            <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i> Menjaga konsistensi
                                rasa warisan nusantara.</li>
                            <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i> Memberikan pelayanan
                                ramah selayaknya keluarga.</li>
                            <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i> Berinovasi dalam menu
                                untuk kepuasan pelanggan.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats -->
        <div class="py-5">
            <div class="row g-4 text-center">
                <div class="col-4">
                    <h2 class="display-4 fw-bold text-success mb-0">5+</h2>
                    <p class="text-muted small text-uppercase fw-bold letter-spacing-1">Tahun Berdiri</p>
                </div>
                <div class="col-4">
                    <h2 class="display-4 fw-bold text-success mb-0">10k+</h2>
                    <p class="text-muted small text-uppercase fw-bold letter-spacing-1">Pelanggan Puas</p>
                </div>
                <div class="col-4">
                    <h2 class="display-4 fw-bold text-success mb-0">50+</h2>
                    <p class="text-muted small text-uppercase fw-bold letter-spacing-1">Menu Spesial</p>
                </div>
            </div>
        </div>

    </div>

    <style>
        .hover-lift {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .hover-lift:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1) !important;
        }

        .letter-spacing-1 {
            letter-spacing: 1px;
        }

        .letter-spacing-2 {
            letter-spacing: 2px;
        }
    </style>
@endsection