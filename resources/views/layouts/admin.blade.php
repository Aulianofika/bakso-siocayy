<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard')</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Optional custom CSS -->
    <style>
        body {
            min-height: 100vh;
            display: flex;
        }
        .sidebar {
            min-width: 220px;
            max-width: 220px;
            background-color: #6f42c1;
            color: white;
            padding: 20px;
        }
        .sidebar a {
            color: white;
            text-decoration: none;
        }
        .sidebar a:hover {
            color: #ffc107;
        }
        .content {
            flex: 1;
            padding: 20px;
        }
        .sidebar .nav-link.active {
            background-color: #5a32a3;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar d-flex flex-column">
        <h3 class="text-center mb-4">Admin Panel</h3>
        <nav class="nav flex-column">
            <a href="{{ route('admin.categories.index') }}" class="nav-link {{ request()->is('admin/categories*') ? 'active' : '' }}">Kategori</a>
            <a href="{{ route('admin.products.index') }}" class="nav-link {{ request()->is('admin/products*') ? 'active' : '' }}">Produk</a>
            <a href="{{ route('admin.orders.index') }}" class="nav-link {{ request()->is('admin/orders*') ? 'active' : '' }}">Pesanan</a>
            <a href="{{ route('admin.shipments.index') }}" class="nav-link {{ request()->is('admin/shipments*') ? 'active' : '' }}">Pengiriman</a>
            <a href="{{ route('admin.stock-incidents.index') }}" class="nav-link {{ request()->is('admin/stock-incidents*') ? 'active' : '' }}">Stok gudang</a>
            <a href="{{ route('admin.returns.index') }}" class="nav-link {{ request()->is('admin/returns*') ? 'active' : '' }}">Retur / Reject</a>
        </nav>
        <div class="mt-auto">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button class="btn btn-danger w-100 mt-3">Logout</button>
            </form>
        </div>
    </div>

    <!-- Main Content -->
    <div class="content">
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg navbar-light bg-light mb-4">
            <div class="container-fluid">
                <span class="navbar-brand mb-0 h1">@yield('title', 'Dashboard')</span>
            </div>
        </nav>

        <!-- Page Content -->
        @yield('content')
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
