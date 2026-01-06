<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title') | Bakso Siocay</title>

  <!-- Bootstrap & Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600&display=swap" rel="stylesheet">

  <style>
    body {
      background-color: #f4fcf6;
      font-family: 'Outfit', sans-serif;
    }

    /* Navbar */
    .navbar {
      background: linear-gradient(135deg, #3ca65a, #2f7a52);
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
      border-radius: 0 0 15px 15px;
      transition: all 0.3s ease;
      position: sticky;
      top: 0;
      z-index: 999;
    }

    .navbar.scrolled {
      backdrop-filter: blur(10px);
      background: rgba(60,166,90,0.85);
      box-shadow: 0 4px 15px rgba(0,0,0,0.15);
    }

    .navbar-brand {
      font-weight: 700;
      color: #fff !important;
      font-size: 1.8rem;
      transition: transform 0.3s;
    }
    .navbar-brand:hover { transform: scale(1.05); }

    .nav-link {
      color: #e9f6ec !important;
      margin-right: 20px;
      position: relative;
      font-weight: 600;
      font-size: 1.15rem;
      transition: all 0.3s ease;
    }
    .nav-link::after {
      content: '';
      position: absolute;
      width: 0%;
      height: 2px;
      left: 0;
      bottom: -3px;
      background-color: #fff;
      transition: 0.3s;
      border-radius: 2px;
    }
    .nav-link:hover::after { width: 100%; }
    .nav-link:hover {
      transform: scale(1.05);
      color: #fff !important;
    }

    .btn-logout, .btn-login {
      background-color: #fff;
      color: #3ca65a;
      font-weight: 500;
      border-radius: 8px;
      transition: 0.3s;
      border: none;
      padding: 6px 12px;
    }
    .btn-logout:hover, .btn-login:hover {
      background-color: #e9f6ec;
      color: #2f7a52;
    }
    .person-icon-btn {
      background: transparent;
      border: none;
      color: #e9f6ec !important;
      font-size: 1.3rem;
      padding: 8px 12px;
      border-radius: 8px;
      transition: all 0.3s ease;
      cursor: pointer;
    }
    .person-icon-btn:hover {
      color: #fff !important;
      background-color: rgba(255, 255, 255, 0.1);
      transform: scale(1.1);
    }
    
    /* Sidebar Kanan */
    .sidebar-overlay {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.5);
      z-index: 1040;
      opacity: 0;
      visibility: hidden;
      transition: opacity 0.3s ease, visibility 0.3s ease;
    }
    .sidebar-overlay.active {
      opacity: 1;
      visibility: visible;
    }
    .user-sidebar {
      position: fixed;
      top: 0;
      right: -320px;
      width: 320px;
      height: 100%;
      background: linear-gradient(180deg, #ffffff, #f4fcf6);
      box-shadow: -4px 0 20px rgba(0,0,0,0.1);
      z-index: 1041;
      transition: right 0.3s ease;
      display: flex;
      flex-direction: column;
    }
    .user-sidebar.active {
      right: 0;
    }
    .user-sidebar-header {
      background: linear-gradient(135deg, #3ca65a, #2f7a52);
      color: white;
      padding: 20px;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    .user-sidebar-header h5 {
      margin: 0;
      font-weight: 600;
      display: flex;
      align-items: center;
      gap: 10px;
    }
    .sidebar-close-btn {
      background: rgba(255,255,255,0.2);
      border: none;
      color: white;
      width: 32px;
      height: 32px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      transition: all 0.3s ease;
    }
    .sidebar-close-btn:hover {
      background: rgba(255,255,255,0.3);
      transform: rotate(90deg);
    }
    .user-sidebar-body {
      flex: 1;
      padding: 20px;
      overflow-y: auto;
    }
    .sidebar-menu-item {
      display: flex;
      align-items: center;
      gap: 12px;
      padding: 14px 16px;
      color: #333;
      text-decoration: none;
      border-radius: 10px;
      margin-bottom: 8px;
      transition: all 0.3s ease;
      font-weight: 500;
    }
    .sidebar-menu-item:hover {
      background: linear-gradient(135deg, rgba(60,166,90,0.1), rgba(47,122,82,0.05));
      color: #2f7a52;
      transform: translateX(5px);
    }
    .sidebar-menu-item i {
      font-size: 1.2rem;
      width: 24px;
      text-align: center;
    }
    .sidebar-menu-item.logout-item {
      color: #dc3545;
    }
    .sidebar-menu-item.logout-item:hover {
      background: linear-gradient(135deg, rgba(220,53,69,0.1), rgba(220,53,69,0.05));
      color: #dc3545;
    }
    .sidebar-menu-item button {
      background: none;
      border: none;
      width: 100%;
      text-align: left;
      padding: 0;
      font-weight: inherit;
      color: inherit;
      cursor: pointer;
    }
    
    /* Responsive Sidebar */
    @media (max-width: 576px) {
      .user-sidebar {
        width: 280px;
      }
    }
    .cart-icon-wrapper {
      position: relative;
      display: inline-block;
    }
    .cart-badge {
      position: absolute;
      top: -8px;
      right: -8px;
      background-color: #ff4444;
      color: white;
      border-radius: 50%;
      width: 20px;
      height: 20px;
      font-size: 11px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-weight: bold;
    }

    /* Hero Section */
    .hero {
      background: linear-gradient(135deg, #c9f7d9, #e7f9ea);
      border-radius: 25px;
      padding: 40px 20px;
      text-align: center;
      box-shadow: 0 8px 20px rgba(0,0,0,0.05);
      margin-bottom: 30px;
    }

    /* Buttons */
    .btn-green {
      background: linear-gradient(135deg, #3ca65a, #2f7a52);
      color: #fff;
      border: none;
      border-radius: 12px;
      padding: 12px 20px;
      font-weight: 500;
      transition: all 0.3s;
    }
    .btn-green:hover {
      background: linear-gradient(135deg, #2f7a52, #3ca65a);
      transform: translateY(-2px);
      box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }

    /* Footer */
    footer {
      background-color: #2f7a52;
      color: #e9f6ec;
      text-align: center;
      padding: 20px;
      margin-top: 50px;
      border-radius: 15px 15px 0 0;
      box-shadow: 0 -4px 10px rgba(0,0,0,0.05);
      font-size: 0.95rem;
    }

    /* General cards */
    .card-custom {
      border-radius: 20px;
      box-shadow: 0 6px 18px rgba(0,0,0,0.05);
      transition: transform 0.3s, box-shadow 0.3s;
    }
    .card-custom:hover {
      transform: translateY(-3px);
      box-shadow: 0 10px 25px rgba(0,0,0,0.08);
    }

    /* Form styling */
    input.form-control {
      border-radius: 12px;
      border: 1px solid #d2f0d5;
      padding: 12px 15px;
      transition: 0.3s;
    }
    input.form-control:focus {
      outline: none;
      border-color: #3ca65a;
      box-shadow: 0 0 8px rgba(60,166,90,0.2);
    }

    /* Responsive adjustments */
    @media (max-width: 992px) {
      .navbar-nav {
        text-align: center;
      }
      .nav-link {
        margin: 10px 0;
      }
      .hero {
        padding: 30px 15px;
      }
    }
    .card-custom {
    border-radius: 14px;
    transition: 0.25s ease;
  }

  .card-img-top {
    height: 220px;
    object-fit: cover;
    border-radius: 14px 14px 0 0;
  }

  .btn-green {
    background: linear-gradient(135deg, #3ca65a, #2f7a52);
    color: #fff;
    border: none;
    border-radius: 10px;
    font-weight: 500;
  }

  /* ===============================
     MOBILE MINIMAL
  ================================ */
  @media (max-width: 576px) {

    h2 {
      font-size: 1.3rem;
    }

    .card-img-top {
      height: 120px;
    }

    .card-body {
      padding: 10px;
    }

    .product-name {
      font-size: 0.85rem;
      line-height: 1.2;
    }

    .product-price {
      font-size: 0.8rem;
    }

    .btn-green {
      font-size: 0.75rem;
      padding: 6px;
      border-radius: 6px;
    }

    /* Matikan hover di mobile */
    .card-custom:hover {
      transform: none;
      box-shadow: 0 4px 10px rgba(0,0,0,0.05);
    }
  }

    @media (max-width: 576px) {
      .navbar-brand {
        font-size: 1.2rem;
      }
      .btn-green {
        width: 100%;
      }
      .hero {
        padding: 25px 10px;
      }
    }
  </style>

  <script>
    // Efek scroll navbar
    window.addEventListener('scroll', function() {
      const navbar = document.querySelector('.navbar');
      if (window.scrollY > 50) {
        navbar.classList.add('scrolled');
      } else {
        navbar.classList.remove('scrolled');
      }
    });
  </script>

  @stack('styles')
</head>
<body>

  {{-- Navbar --}}
  <nav class="navbar navbar-expand-lg navbar-dark shadow-sm">
    <div class="container">
      <a class="navbar-brand" href="{{ url('/home') }}">
        <i class="bi bi-cup-hot-fill me-1"></i> Siocay
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto align-items-center">
          <li class="nav-item"><a href="{{ url('/home') }}" class="nav-link">Beranda</a></li>
          <li class="nav-item"><a href="{{ url('/menu') }}" class="nav-link">Produk</a></li>
          
          @auth
            {{-- Icon Keranjang dengan Badge --}}
            <li class="nav-item">
              <a href="{{ route('cart.index') }}" class="nav-link position-relative">
                <i class="bi bi-cart3" style="font-size: 1.2rem;"></i>
                @if(isset($cartCount) && $cartCount > 0)
                  <span class="cart-badge">{{ $cartCount }}</span>
                @endif
              </a>
            </li>
            
            {{-- Icon Person untuk membuka Sidebar --}}
            <li class="nav-item">
              <button class="person-icon-btn nav-link" type="button" id="openSidebarBtn" title="Menu Pengguna">
                <i class="bi bi-person-fill"></i>
              </button>
            </li>
          @else
            {{-- Login dengan Icon Person --}}
            <li class="nav-item">
              <a href="{{ route('login') }}" class="person-icon-btn nav-link" title="Login">
                <i class="bi bi-person-fill"></i>
              </a>
            </li>
          @endauth
        </ul>
      </div>
    </div>
  </nav>

  {{-- Konten --}}
  <main class="container my-5">
    @yield('content')
  </main>

  {{-- Footer --}}
  <footer class="text-white mt-5" style="background: linear-gradient(135deg, #3ca65a, #2f7a52); border-radius: 20px 20px 0 0;">
      <div class="container pt-5 pb-4">
          <div class="row g-4 justify-content-between">
              {{-- Brand Column --}}
              <div class="col-lg-4 mb-4 mb-lg-0">
                  <h4 class="fw-bold text-white mb-4 d-flex align-items-center gap-2">
                      <i class="bi bi-cup-hot-fill"></i> Bakso Siocay
                  </h4>
                  <p class="text-white small mb-4 opacity-75" style="line-height: 1.8; max-width: 350px;">
                      Menyajikan bakso lezat dan kopi pilihan dengan suasana yang hangat. Temukan rasa favoritmu di sini.
                  </p>
                  <a href="#" class="text-white text-decoration-none small fw-bold hover-scale d-inline-block border-bottom border-white pb-1">
                      Baca Selengkapnya <i class="bi bi-arrow-right ms-1"></i>
                  </a>
              </div>

              {{-- Categories Column --}}
              <div class="col-lg-2 col-6">
                  <h6 class="fw-bold mb-4 text-white spacing-1 border-bottom border-white border-opacity-25 d-inline-block pb-1">KATEGORI</h6>
                  <ul class="list-unstyled d-flex flex-column gap-2 small text-white opacity-75">
                      <li><a href="{{ route('menu', ['category' => 'Bakso']) }}" class="text-reset text-decoration-none hover-text-white transition-opacity">Bakso Kuah</a></li>
                      <li><a href="{{ route('menu', ['category' => 'Kopi']) }}" class="text-reset text-decoration-none hover-text-white transition-opacity">Kopi Series</a></li>
                      <li><a href="{{ route('menu', ['category' => 'Minuman']) }}" class="text-reset text-decoration-none hover-text-white transition-opacity">Minuman Segar</a></li>
                      <li><a href="{{ route('menu') }}" class="text-reset text-decoration-none hover-text-white transition-opacity">Menu Spesial</a></li>
                  </ul>
              </div>

              {{-- Tag Cloud Column --}}
              <div class="col-lg-3 col-6">
                  <h6 class="fw-bold mb-4 text-white spacing-1 border-bottom border-white border-opacity-25 d-inline-block pb-1">TAG POPULER</h6>
                  <div class="d-flex flex-wrap gap-2">
                      <a href="#" class="btn btn-outline-light btn-sm small rounded-1 px-3 py-1 hover-tag border-opacity-25 opacity-75">Pedas</a>
                      <a href="#" class="btn btn-outline-light btn-sm small rounded-1 px-3 py-1 hover-tag border-opacity-25 opacity-75">Manis</a>
                      <a href="#" class="btn btn-outline-light btn-sm small rounded-1 px-3 py-1 hover-tag border-opacity-25 opacity-75">Gurih</a>
                      <a href="#" class="btn btn-outline-light btn-sm small rounded-1 px-3 py-1 hover-tag border-opacity-25 opacity-75">Kopi</a>
                      <a href="#" class="btn btn-outline-light btn-sm small rounded-1 px-3 py-1 hover-tag border-opacity-25 opacity-75">Segar</a>
                      <a href="#" class="btn btn-outline-light btn-sm small rounded-1 px-3 py-1 hover-tag border-opacity-25 opacity-75">Bakso</a>
                      <a href="#" class="btn btn-outline-light btn-sm small rounded-1 px-3 py-1 hover-tag border-opacity-25 opacity-75">Es Krim</a>
                  </div>
              </div>

              {{-- Subscribe & Social Column --}}
              <div class="col-lg-3">
                  <h6 class="fw-bold mb-4 text-white spacing-1 border-bottom border-white border-opacity-25 d-inline-block pb-1">BERLANGGANAN</h6>
                  <form action="#" class="mb-4 position-relative">
                      <input type="email" class="form-control bg-white bg-opacity-10 border-white border-opacity-25 text-white rounded-1 py-2 pe-5 placeholder-white-50" placeholder="Email kamu..." style="border-radius: 8px;">
                      <button type="submit" class="btn btn-light text-success position-absolute top-0 end-0 h-100 px-3 d-flex align-items-center justify-content-center" style="border-top-right-radius: 8px; border-bottom-right-radius: 8px;">
                          <i class="bi bi-send-fill small"></i>
                      </button>
                  </form>

                  <h6 class="fw-bold mb-3 text-white spacing-1 small">IKUTI KAMI</h6>
                  <div class="d-flex gap-2">
                      <a href="#" class="btn btn-outline-light border-opacity-25 rounded-circle p-0 d-flex align-items-center justify-content-center hover-icon-white transition-all text-white" style="width: 38px; height: 38px;">
                          <i class="bi bi-twitter"></i>
                      </a>
                      <a href="#" class="btn btn-outline-light border-opacity-25 rounded-circle p-0 d-flex align-items-center justify-content-center hover-icon-white transition-all text-white" style="width: 38px; height: 38px;">
                          <i class="bi bi-facebook"></i>
                      </a>
                      <a href="#" class="btn btn-outline-light border-opacity-25 rounded-circle p-0 d-flex align-items-center justify-content-center hover-icon-white transition-all text-white" style="width: 38px; height: 38px;">
                          <i class="bi bi-instagram"></i>
                      </a>
                  </div>
              </div>
          </div>
      </div>

      {{-- Copyright Bar --}}
      <div class="border-top border-white border-opacity-10" style="background-color: rgba(0,0,0,0.1);">
          <div class="container py-4">
              <div class="row align-items-center">
                  <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                      <p class="small text-white opacity-75 mb-0">
                          Copyright &copy; {{ date('Y') }} All rights reserved | Made with <i class="bi bi-heart-fill text-white" aria-hidden="true"></i> by <span class="fw-bold">Siocay</span>
                      </p>
                  </div>
                  <div class="col-md-6 text-center text-md-end">
                      <ul class="list-inline mb-0 small opacity-75">
                          <li class="list-inline-item me-4"><a href="#" class="text-white text-decoration-none hover-text-white transition-opacity">Terms</a></li>
                          <li class="list-inline-item me-4"><a href="#" class="text-white text-decoration-none hover-text-white transition-opacity">Privacy</a></li>
                          <li class="list-inline-item"><a href="#" class="text-white text-decoration-none hover-text-white transition-opacity">Compliances</a></li>
                      </ul>
                  </div>
              </div>
          </div>
      </div>
  </footer>

  @auth
  {{-- Sidebar Overlay --}}
  <div class="sidebar-overlay" id="sidebarOverlay"></div>
  
  {{-- User Sidebar Kanan --}}
  {{-- User Sidebar Kanan --}}
  {{-- User Sidebar Kanan --}}
  <div class="user-sidebar bg-white" id="userSidebar">
    
    {{-- Header --}}
    <div class="user-sidebar-header d-flex justify-content-between align-items-center p-4 border-bottom">
        <h5 class="fw-bold mb-0 text-dark" style="font-family: 'Outfit', sans-serif;">Menu Pengguna</h5>
        <button class="btn btn-close" id="closeSidebarBtn" type="button" aria-label="Close"></button>
    </div>

    <div class="user-sidebar-body p-0">
        {{-- Profile Section --}}
        <div class="p-4 bg-light border-bottom">
            <div class="d-flex align-items-center gap-3">
                <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center fw-bold shadow-sm" style="width: 48px; height: 48px; font-size: 1.25rem;">
                    {{ substr(Auth::user()->name ?? 'U', 0, 1) }}
                </div>
                <div>
                    <h6 class="fw-bold text-dark mb-0">{{ Auth::user()->name ?? 'Pengguna' }}</h6>
                    <small class="text-secondary">{{ Auth::user()->email ?? '' }}</small>
                </div>
            </div>
        </div>

        {{-- Menu Links --}}
        <div class="list-group list-group-flush pt-2">
            <a href="{{ route('frontend.riwayat') }}" class="list-group-item list-group-item-action border-0 px-4 py-3 d-flex align-items-center gap-3 text-secondary">
                <i class="bi bi-clock-history fs-5"></i>
                <span class="fw-medium">Riwayat Pesanan</span>
            </a>
            
            <form method="POST" action="{{ route('logout') }}" class="w-100">
                @csrf
                <button type="submit" class="list-group-item list-group-item-action border-0 px-4 py-3 d-flex align-items-center gap-3 text-danger mt-2">
                    <i class="bi bi-box-arrow-right fs-5"></i>
                    <span class="fw-medium">Logout</span>
                </button>
            </form>
        </div>
    </div>
  </div>

  <style>
      .user-sidebar { box-shadow: -5px 0 25px rgba(0,0,0,0.1); }
      .list-group-item-action:hover { background-color: #f8f9fa; color: #198754 !important; }
      .list-group-item-action:hover i { color: #198754; }
      /* Logout hover overrides */
      button.list-group-item-action:hover { background-color: #fff5f5; color: #dc3545 !important; }
      button.list-group-item-action:hover i { color: #dc3545; }
  </style>
  @endauth

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  
  @auth
  <script>
    // Sidebar Toggle Script
    const openSidebarBtn = document.getElementById('openSidebarBtn');
    const closeSidebarBtn = document.getElementById('closeSidebarBtn');
    const sidebarOverlay = document.getElementById('sidebarOverlay');
    const userSidebar = document.getElementById('userSidebar');
    
    function openSidebar() {
      sidebarOverlay.classList.add('active');
      userSidebar.classList.add('active');
      document.body.style.overflow = 'hidden'; // Prevent body scroll
    }
    
    function closeSidebar() {
      sidebarOverlay.classList.remove('active');
      userSidebar.classList.remove('active');
      document.body.style.overflow = ''; // Restore body scroll
    }
    
    openSidebarBtn.addEventListener('click', openSidebar);
    closeSidebarBtn.addEventListener('click', closeSidebar);
    sidebarOverlay.addEventListener('click', closeSidebar);
    
    // Close sidebar on ESC key
    document.addEventListener('keydown', function(e) {
      if (e.key === 'Escape' && userSidebar.classList.contains('active')) {
        closeSidebar();
      }
    });
  </script>
  @endauth
  {{-- Floating WhatsApp Button --}}
  <a href="https://wa.me/6281234567890" target="_blank" class="whatsapp-float shadow-lg" title="Chat via WhatsApp">
    <i class="bi bi-whatsapp"></i>
  </a>

  <style>
    .whatsapp-float {
        position: fixed;
        bottom: 30px;
        right: 30px;
        width: 60px;
        height: 60px;
        background-color: #25D366;
        color: #FFF;
        border-radius: 50px;
        text-align: center;
        font-size: 30px;
        box-shadow: 2px 2px 3px #999;
        z-index: 1050;
        display: flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .whatsapp-float:hover {
        background-color: #128C7E;
        color: #FFF;
        transform: scale(1.1);
    }

    @media (max-width: 576px) {
        .whatsapp-float {
            width: 50px;
            height: 50px;
            bottom: 20px;
            right: 20px;
            font-size: 24px;
        }
    }
  </style>

</body>
</html>
