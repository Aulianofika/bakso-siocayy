<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bakso Siocay - @yield('title', 'Dashboard')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    {{-- Navbar --}}
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#">Bakso Siocay 🍜</a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" 
                    data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" 
                    aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">

                    @auth
                        {{-- Jika admin --}}
                        @if (Auth::user()->role === 'admin')
                            <li class="nav-item">
                                <a class="nav-link" href="/admin/dashboard">Dashboard Admin</a>
                            </li>
                        @endif

                        {{-- Jika user --}}
                        @if (Auth::user()->role === 'user')
                            <li class="nav-item">
                                <a class="nav-link" href="/home">Dashboard User</a>
                            </li>
                        @endif

                        {{-- Tombol Logout --}}
                        <li class="nav-item">
                            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-danger ms-2">Logout</button>
                            </form>
                        </li>
                    @else
                        {{-- Kalau belum login --}}
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Login</a>
                        </li>
                    @endauth

                </ul>
            </div>
        </div>
    </nav>

    {{-- Konten Halaman --}}
    <main class="container py-4">
        @yield('content')
    </main>

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
