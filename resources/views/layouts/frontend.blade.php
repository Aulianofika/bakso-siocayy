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
      font-weight: 600;
      color: #fff !important;
      font-size: 1.4rem;
      transition: transform 0.3s;
    }
    .navbar-brand:hover { transform: scale(1.05); }

    .nav-link {
      color: #e9f6ec !important;
      margin-right: 15px;
      position: relative;
      font-weight: 500;
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
  <footer>
    &copy; {{ date('Y') }} Siocay — Hangat, Lezat, dan Dekat denganmu 💚
  </footer>

  @auth
  {{-- Sidebar Overlay --}}
  <div class="sidebar-overlay" id="sidebarOverlay"></div>
  
  {{-- User Sidebar Kanan --}}
  <div class="user-sidebar" id="userSidebar">
    <div class="user-sidebar-header">
      <h5>
        <i class="bi bi-person-fill"></i>
        Menu Pengguna
      </h5>
      <button class="sidebar-close-btn" id="closeSidebarBtn" type="button">
        <i class="bi bi-x-lg"></i>
      </button>
    </div>
    <div class="user-sidebar-body">
      <a href="{{ route('frontend.riwayat') }}" class="sidebar-menu-item">
        <i class="bi bi-receipt"></i>
        <span>Riwayat Pesanan Saya</span>
      </a>
      
      <form method="POST" action="{{ route('logout') }}" class="d-inline">
        @csrf
        <button type="submit" class="sidebar-menu-item logout-item">
          <i class="bi bi-box-arrow-right"></i>
          <span>Logout</span>
        </button>
      </form>
    </div>
  </div>
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
</body>
</html>
