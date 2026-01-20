<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>@yield('title', 'Admin') — Bakso Siocay Admin</title>

  <!-- Google Fonts: Outfit (More modern/premium than Poppins) -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap"
    rel="stylesheet">

  <!-- Bootstrap 5.3 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- FontAwesome (Keep for existing icons) -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <!-- Bootstrap Icons (Added for dashboard compatibility) -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

  <style>
    /* ---------- THEME VARIABLES ---------- */
    :root {
      /* Palette: Fresh Mint & Deep Forest */
      --primary-50: #f0fdf4;
      --primary-100: #dcfce7;
      --primary-200: #bbf7d0;
      --primary-400: #4ade80;
      --primary-500: #22c55e;
      --primary-600: #16a34a;
      --primary-700: #15803d;
      --primary-800: #166534;

      --bg-body: #f8fcf9;
      --bg-glass: rgba(255, 255, 255, 0.95);
      --bg-sidebar: #ffffff;

      --text-main: #1e293b;
      --text-muted: #64748b;

      --border-subtle: #e2e8f0;

      --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
      --shadow-md: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px -1px rgba(0, 0, 0, 0.1);
      --shadow-lg: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -2px rgba(0, 0, 0, 0.1);
      --shadow-glow: none;

      --radius-md: 0.5rem;
      --radius-lg: 0.75rem;
      --radius-xl: 1rem;

      --trans-fast: 0.15s ease;
      --trans-spring: 0.25s ease-out;
    }

    html,
    body {
      height: 100%;
      overflow-x: hidden;
      max-width: 100%;
    }

    body {
      font-family: 'Outfit', sans-serif;
      background-color: var(--bg-body);
      color: var(--text-main);
      font-size: 0.85rem;
      /* Reduced font size */
      -webkit-font-smoothing: antialiased;
    }

    h1 {
      font-size: 1.5rem;
    }

    h2 {
      font-size: 1.25rem;
    }

    h3 {
      font-size: 1.15rem;
    }

    h4 {
      font-size: 1rem;
    }

    h5 {
      font-size: 0.95rem;
    }

    h6 {
      font-size: 0.85rem;
    }

    /* ---------- LAYOUT STRUCTURE ---------- */
    .app-container {
      display: flex;
      min-height: 100vh;
      position: relative;
    }

    /* ---------- SIDEBAR ---------- */
    .sidebar {
      width: 260px;
      /* Slightly narrower */
      height: 100vh;
      position: fixed;
      left: 0;
      top: 0;
      background: var(--bg-sidebar);
      border-right: 1px solid var(--border-subtle);
      z-index: 1030;
      display: flex;
      flex-direction: column;
      padding: 1.25rem;
      transition: transform var(--trans-fast), width var(--trans-fast);
    }

    .sidebar-brand {
      display: flex;
      align-items: center;
      gap: 0.75rem;
      padding-bottom: 1.5rem;
      margin-bottom: 1rem;
      border-bottom: 1px solid var(--border-subtle);
    }

    .brand-logo {
      width: 36px;
      height: 36px;
      background: var(--primary-600);
      color: white;
      border-radius: 8px;
      /* Square-ish */
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1.1rem;
      font-weight: 700;
    }

    .brand-text h1 {
      font-size: 1rem;
      font-weight: 600;
      margin: 0;
      line-height: 1.1;
      color: var(--text-main);
    }

    .brand-text span {
      font-size: 0.75rem;
      color: var(--text-muted);
      font-weight: 400;
    }

    .nav-menu {
      display: flex;
      flex-direction: column;
      gap: 0.25rem;
      flex: 1;
      overflow-y: auto;
    }

    .nav-item {
      display: flex;
      align-items: center;
      gap: 0.75rem;
      padding: 0.6rem 0.85rem;
      color: var(--text-muted);
      text-decoration: none;
      border-radius: 6px;
      font-size: 0.9rem;
      font-weight: 500;
      transition: all var(--trans-fast);
    }

    .nav-item i {
      font-size: 1rem;
      width: 20px;
      text-align: center;
      color: #94a3b8;
      transition: color var(--trans-fast);
    }

    .nav-item:hover {
      background: #f1f5f9;
      color: var(--text-main);
    }

    .nav-item:hover i {
      color: var(--primary-600);
    }

    .nav-item.active {
      background: var(--primary-50);
      color: var(--primary-700);
      font-weight: 600;
    }

    .nav-item.active i {
      color: var(--primary-600);
    }

    /* ---------- MAIN CONTENT AREA ---------- */
    .main-content {
      flex: 1;
      margin-left: 280px;
      /* Width of sidebar */
      display: flex;
      flex-direction: column;
      min-height: 100vh;
      transition: margin-left var(--trans-fast);
    }

    /* ---------- TOPBAR ---------- */
    .topbar {
      height: 72px;
      background: rgba(255, 255, 255, 0.8);
      backdrop-filter: blur(12px);
      border-bottom: 1px solid var(--border-subtle);
      position: sticky;
      top: 0;
      z-index: 1020;
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 0 2rem;
    }

    .toggle-sidebar-btn {
      background: transparent;
      border: 1px solid var(--border-subtle);
      border-radius: 8px;
      width: 36px;
      height: 36px;
      display: none;
      /* Hidden by default on desktop */
      align-items: center;
      justify-content: center;
      color: var(--text-muted);
      cursor: pointer;
      transition: var(--trans-fast);
    }

    .toggle-sidebar-btn:hover {
      background: var(--primary-50);
      color: var(--primary-600);
      border-color: var(--primary-200);
    }

    .topbar-right {
      display: flex;
      align-items: center;
      gap: 1.25rem;
      margin-left: auto;
    }

    .notify-btn {
      position: relative;
      color: var(--text-muted);
      font-size: 1.1rem;
      background: white;
      width: 40px;
      height: 40px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      box-shadow: var(--shadow-sm);
      transition: var(--trans-spring);
    }

    .notify-btn:hover {
      transform: translateY(-2px);
      color: var(--primary-600);
      box-shadow: var(--shadow-md);
    }

    .user-profile {
      display: flex;
      align-items: center;
      gap: 0.75rem;
      padding: 0.25rem 0.5rem 0.25rem 0.25rem;
      background: white;
      border: 1px solid var(--border-subtle);
      border-radius: 50px;
      cursor: default;
      transition: var(--trans-fast);
    }

    .user-profile:hover {
      border-color: var(--primary-200);
      box-shadow: var(--shadow-sm);
    }

    .user-avatar {
      width: 32px;
      height: 32px;
      border-radius: 50%;
      background: var(--primary-100);
      overflow: hidden;
    }

    .user-avatar img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }

    .user-info {
      padding-right: 0.5rem;
    }

    .user-name {
      font-size: 0.95rem;
      font-weight: 600;
      color: var(--text-main);
      line-height: 1;
      display: block;
    }

    .user-role {
      font-size: 0.8rem;
      color: var(--text-muted);
      display: block;
    }

    /* ---------- PAGE CONTENT ---------- */
    .page-wrapper {
      padding: 2rem;
      flex: 1;
    }

    /* ---------- COMPONENTS: CARDS ---------- */
    .card {
      background: white;
      border: 1px solid var(--border-subtle);
      border-radius: var(--radius-lg);
      box-shadow: var(--shadow-sm);
      transition: transform var(--trans-fast), box-shadow var(--trans-fast);
      overflow: hidden;
    }

    .card:hover {
      box-shadow: var(--shadow-md);
    }

    .card-header {
      background: transparent;
      border-bottom: 1px solid var(--border-subtle);
      padding: 1.25rem 1.5rem;
    }

    /* Hover effect specifically for stat cards */
    .card-stat {
      position: relative;
    }

    .card-stat::after {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      w: 100%;
      h: 100%;
      background: linear-gradient(135deg, rgba(255, 255, 255, 0) 0%, rgba(255, 255, 255, 0.4) 100%);
      pointer-events: none;
    }

    .card-stat:hover {
      transform: translateY(-4px);
    }

    /* ---------- COMPONENTS: TABLES ---------- */
    .table-responsive {
      border-radius: var(--radius-md);
    }

    .table {
      margin-bottom: 0;
      vertical-align: middle;
    }

    .table thead th {
      background: #f8fafc;
      font-weight: 600;
      font-size: 0.85rem;
      text-transform: uppercase;
      letter-spacing: 0.5px;
      color: var(--text-muted);
      border-bottom: 2px solid var(--border-subtle);
      padding: 1rem;
    }

    .table tbody td {
      padding: 1rem;
      border-bottom: 1px solid var(--border-subtle);
      font-size: 1rem;
    }

    .table-hover tbody tr:hover {
      background-color: var(--primary-50);
    }

    /* ---------- COMPONENTS: BADGES & BUTTONS ---------- */
    .badge {
      font-weight: 600;
      padding: 0.5em 0.8em;
      border-radius: 6px;
    }

    .btn {
      padding: 0.5rem 1rem;
      border-radius: 10px;
      font-weight: 500;
      letter-spacing: 0.3px;
    }

    .btn-primary {
      background: var(--primary-600);
      border-color: var(--primary-600);
      box-shadow: 0 4px 6px rgba(22, 163, 74, 0.2);
    }

    .btn-primary:hover,
    .btn-primary:active {
      background: var(--primary-700) !important;
      border-color: var(--primary-700) !important;
    }

    /* ---------- RESPONSIVE ---------- */
    @media (max-width: 991.98px) {
      .sidebar {
        transform: translateX(-100%);
      }

      .sidebar.show {
        transform: translateX(0);
        box-shadow: 20px 0 50px rgba(0, 0, 0, 0.1);
      }

      .main-content {
        margin-left: 0;
      }

      .toggle-sidebar-btn {
        display: flex;
        margin-right: 1rem;
      }

      .topbar {
        padding: 0 1rem;
        justify-content: flex-start;
      }

      .topbar-right {
        margin-left: auto;
      }
    }

    /* Overlay for mobile sidebar */
    .sidebar-overlay {
      position: fixed;
      top: 0;
      left: 0;
      width: 100vw;
      height: 100vh;
      background: rgba(0, 0, 0, 0.3);
      backdrop-filter: blur(2px);
      z-index: 1025;
      opacity: 0;
      visibility: hidden;
      transition: var(--trans-fast);
    }

    .sidebar-overlay.show {
      opacity: 1;
      visibility: visible;
    }
  </style>
</head>

<body>

  <!-- Mobile Overlay -->
  <div id="sidebarOverlay" class="sidebar-overlay"></div>

  <div class="app-container">

    <!-- SIDEBAR -->
    <aside id="sidebar" class="sidebar">
      <div class="sidebar-brand">
        <img src="{{ asset('images/logo-siocay.png') }}" alt="Bakso Siocay" class="rounded-circle shadow-sm"
          style="height: 60px; object-fit: contain; border: 2px solid rgba(0,0,0,0.05);">
        <div class="brand-text ms-2">
          <h1 class="mb-0">Admin</h1>
        </div>
      </div>

      <nav class="nav-menu">
        {{-- Dashboard Dropdown --}}
        @php
          $isDashboardActive = request()->is('admin/dashboard');
          $dashType = request('type');
        @endphp
        <a class="nav-item {{ $isDashboardActive ? 'active' : '' }} collapsed" href="#dashboardSubmenu"
          data-bs-toggle="collapse" role="button" aria-expanded="{{ $isDashboardActive ? 'true' : 'false' }}"
          aria-controls="dashboardSubmenu">
          <i class="bi bi-speedometer2"></i>
          <span>Dashboard</span>
          <i class="bi bi-chevron-down ms-auto" style="font-size: 0.8em; opacity: 0.8;"></i>
        </a>

        <div class="collapse {{ $isDashboardActive ? 'show' : '' }} ps-3" id="dashboardSubmenu">
          <div class="nav-menu mt-1 gap-1 border-start border-2 ms-3 ps-2"
            style="border-color: var(--border-subtle) !important;">
            <a href="{{ route('admin.dashboard', ['type' => 'bakso']) }}"
              class="nav-item small py-2 {{ $isDashboardActive && $dashType == 'bakso' ? 'bg-primary-50 text-success fw-bold' : '' }}"
              style="font-size: 0.95rem;">
              <i class="bi bi-circle-fill text-success"
                style="font-size: 0.4rem; opacity: {{ $isDashboardActive && $dashType == 'bakso' ? '1' : '0.5' }}"></i>
              <span> Bakso</span>
            </a>

            <a href="{{ route('admin.dashboard', ['type' => 'kopi']) }}"
              class="nav-item small py-2 {{ $isDashboardActive && $dashType == 'kopi' ? 'bg-primary-50 text-success fw-bold' : '' }}"
              style="font-size: 0.95rem;">
              <i class="bi bi-circle-fill text-success"
                style="font-size: 0.4rem; opacity: {{ $isDashboardActive && $dashType == 'kopi' ? '1' : '0.5' }}"></i>
              <span> Kopi</span>
            </a>

            <a href="{{ route('admin.dashboard', ['type' => 'all']) }}"
              class="nav-item small py-2 {{ $isDashboardActive && ($dashType == 'all' || !$dashType) ? 'bg-primary-50 text-success fw-bold' : '' }}"
              style="font-size: 0.95rem;">
              <i class="bi bi-circle-fill text-success"
                style="font-size: 0.4rem; opacity: {{ $isDashboardActive && ($dashType == 'all' || !$dashType) ? '1' : '0.5' }}"></i>
              <span>Semua </span>
            </a>
          </div>
        </div>

        <div class="text-muted small fw-bold mt-3 mb-2 px-3 text-uppercase"
          style="font-size: 0.8rem; letter-spacing: 1px;">Master Data</div>

        <a href="{{ route('admin.categories.index') }}"
          class="nav-item {{ request()->is('admin/categories*') ? 'active' : '' }}">
          <i class="bi bi-tag-fill"></i>
          <span>Kategori</span>
        </a>

        <a href="{{ route('admin.products.index') }}"
          class="nav-item {{ request()->is('admin/products*') ? 'active' : '' }}">
          <i class="bi bi-box-seam-fill"></i>
          <span>Produk</span>
        </a>

        <a href="{{ route('admin.customers.index') }}"
          class="nav-item {{ request()->is('admin/customers*') ? 'active' : '' }}">
          <i class="bi bi-people"></i>
          <span>Pelanggan</span>
        </a>

        <div class="text-muted small fw-bold mt-3 mb-2 px-3 text-uppercase"
          style="font-size: 0.8rem; letter-spacing: 1px;">Transaksi</div>

        {{-- Pesanan Dropdown --}}
        @php
          $isOrdersActive = request()->is('admin/orders*');
          $orderType = request('type');
        @endphp
        <a class="nav-item {{ $isOrdersActive ? 'active' : '' }} collapsed" href="#ordersSubmenu"
          data-bs-toggle="collapse" role="button" aria-expanded="{{ $isOrdersActive ? 'true' : 'false' }}"
          aria-controls="ordersSubmenu">
          <i class="bi bi-receipt-cutoff"></i>
          <span>Pesanan</span>
          <i class="bi bi-chevron-down ms-auto" style="font-size: 0.8em; opacity: 0.8;"></i>
        </a>

        <div class="collapse {{ $isOrdersActive ? 'show' : '' }} ps-3" id="ordersSubmenu">
          <div class="nav-menu mt-1 gap-1 border-start border-2 ms-3 ps-2"
            style="border-color: var(--border-subtle) !important;">
            <a href="{{ route('admin.orders.index', ['type' => 'bakso']) }}"
              class="nav-item small py-2 {{ $isOrdersActive && $orderType == 'bakso' ? 'bg-primary-50 text-success fw-bold' : '' }}"
              style="font-size: 0.95rem;">
              <i class="bi bi-circle-fill text-success"
                style="font-size: 0.4rem; opacity: {{ $isOrdersActive && $orderType == 'bakso' ? '1' : '0.5' }}"></i>
              <span>Pesanan Bakso</span>
            </a>

            <a href="{{ route('admin.orders.index', ['type' => 'kopi']) }}"
              class="nav-item small py-2 {{ $isOrdersActive && $orderType == 'kopi' ? 'bg-primary-50 text-success fw-bold' : '' }}"
              style="font-size: 0.95rem;">
              <i class="bi bi-circle-fill text-success"
                style="font-size: 0.4rem; opacity: {{ $isOrdersActive && $orderType == 'kopi' ? '1' : '0.5' }}"></i>
              <span>Pesanan Kopi</span>
            </a>

            {{-- Link untuk Semua Pesanan (Optional, jika owner mau lihat gabungan) --}}
            <a href="{{ route('admin.orders.index', ['type' => 'all']) }}"
              class="nav-item small py-2 {{ $isOrdersActive && ($orderType == 'all' || !$orderType) ? 'bg-primary-50 text-success fw-bold' : '' }}"
              style="font-size: 0.95rem;">
              <i class="bi bi-circle-fill text-success"
                style="font-size: 0.4rem; opacity: {{ $isOrdersActive && ($orderType == 'all' || !$orderType) ? '1' : '0.5' }}"></i>
              <span>Semua Pesanan</span>
            </a>
          </div>
        </div>

        <a href="{{ route('admin.shipments.index') }}"
          class="nav-item {{ request()->is('admin/shipments*') ? 'active' : '' }}">
          <i class="bi bi-truck"></i>
          <span>Pengiriman</span>
        </a>

        <a href="{{ route('admin.stock-incidents.index') }}"
          class="nav-item {{ request()->is('admin/stock-incidents*') ? 'active' : '' }}">
          <i class="bi bi-exclamation-triangle-fill"></i>
          <span>Insiden Stok</span>
        </a>

      </nav>
    </aside>

    <!-- CONTENT WRAPPER -->
    <div class="main-content">

      <!-- TOPBAR -->
      <header class="topbar">
        <button id="sidebarToggle" class="toggle-sidebar-btn" aria-label="Toggle Sidebar">
          <i class="fa-solid fa-bars"></i>
        </button>

        <!-- Optional: Global Search could go here -->
        <h5 class="m-0 d-none d-md-block fw-bold text-muted"></h5>

        <div class="topbar-right">
          <!-- Notification Bell -->
          <a href="{{ route('admin.orders.index', ['status_order' => 'attention']) }}" class="notify-btn"
            title="Perlu Tindakan">
            <i class="bi bi-bell-fill"></i>
            @if(isset($newOrdersCount) && $newOrdersCount > 0)
              <span
                class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger border border-white"
                style="font-size: 0.75rem;">
                {{ $newOrdersCount > 99 ? '99+' : $newOrdersCount }}
              </span>
            @endif
          </a>

          <!-- User Profile Dropdown -->
          <div class="dropdown">
            <div class="user-profile" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              <div class="user-avatar">
                <img
                  src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name ?? 'Admin') }}&background=10b981&color=fff"
                  alt="Avatar">
              </div>
              <div class="user-info d-none d-sm-block">
                <span class="user-name">{{ Auth::user()->name ?? 'Administrator' }}</span>
                <span class="user-role">Super Admin</span>
              </div>
              <i class="bi bi-chevron-down ms-2 small text-muted"></i>
            </div>
            <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg p-2 rounded-3 mt-2">
              <li>
                <form action="{{ route('logout') }}" method="POST">
                  @csrf
                  <button class="dropdown-item rounded-2 text-danger fw-bold d-flex align-items-center gap-2 py-2"
                    type="submit">
                    <i class="fa-solid fa-right-from-bracket"></i>
                    Logout
                  </button>
                </form>
              </li>
            </ul>
          </div>
        </div>
      </header>

      <!-- PAGE CONTENT -->
      <main class="page-wrapper">
        <!-- Breadcrumb / Title area could be injected here if needed -->
        @yield('content')
      </main>

    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

  <script>
    // Sidebar Logic
    const sidebar = document.getElementById('sidebar');
    const toggleBtn = document.getElementById('sidebarToggle');
    const overlay = document.getElementById('sidebarOverlay');

    function toggleSidebar() {
      sidebar.classList.toggle('show');
      overlay.classList.toggle('show');
    }

    if (toggleBtn) {
      toggleBtn.addEventListener('click', (e) => {
        e.stopPropagation();
        toggleSidebar();
      });
    }

    if (overlay) {
      overlay.addEventListener('click', toggleSidebar);
    }

    // Auto-active based on URL is handled by Blade classes, but if we need JS for mobile interaction:
    // ...
    // For SSR, the standard link click refreshes page, so state resets.
  </script>
  @stack('scripts')
</body>

</html>