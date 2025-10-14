<!-- resources/views/layouts/user.blade.php -->
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title') | Bakso Siocay</title>
  
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;700&display=swap" rel="stylesheet">
  
  <style>
    body {
      font-family: 'Outfit', sans-serif;
      background-color: #f8fff9;
      color: #2f4f38;
    }
    /* Navbar */
    .navbar {
      background: linear-gradient(90deg, #3ca65a, #2f7a52);
      box-shadow: 0 3px 10px rgba(0,0,0,0.05);
    }
    .navbar-brand {
      font-weight: 700;
      color: #fff !important;
      letter-spacing: 0.5px;
    }
    .nav-link {
      color: #e9f9ec !important;
      font-weight: 500;
    }
    .nav-link:hover {
      color: #ffffff !important;
      text-decoration: underline;
    }

    /* Footer */
    footer {
      background: #f1f8f3;
      color: #4b6b50;
      text-align: center;
      padding: 1rem 0;
      margin-top: 3rem;
      font-size: 0.9rem;
    }

    /* Hero (untuk halaman home) */
    .hero {
      background: linear-gradient(120deg, #e0f8e7 0%, #f7fff9 100%);
      border-radius: 15px;
      padding: 2.5rem;
      text-align: center;
      margin-top: 1rem;
    }
    .hero h1 {
      font-weight: 700;
      color: #2f7a52;
    }
    .hero p {
      color: #4f6f57;
    }
    .btn-green {
      background: linear-gradient(135deg, #3ca65a, #2f7a52);
      color: #fff;
      border: none;
      padding: 0.6rem 1.2rem;
      border-radius: 10px;
      transition: 0.3s ease;
    }
    .btn-green:hover {
      transform: translateY(-2px);
      box-shadow: 0 4px 12px rgba(60,166,90,0.3);
    }
  </style>
</head>
<body>

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
      <a class="navbar-brand" href="{{ url('/home') }}">
        <i class="bi bi-cup-hot me-2"></i> Bakso Siocay
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item"><a href="{{ url('/home') }}" class="nav-link">Beranda</a></li>
          <li class="nav-item"><a href="{{ url('/produk') }}" class="nav-link">Produk</a></li>
          <li class="nav-item"><a href="{{ url('/pesanan-saya') }}" class="nav-link">Pesanan Saya</a></li>
          <li class="nav-item">
            <form method="POST" action="{{ route('logout') }}">
              @csrf
              <button type="submit" class="btn btn-sm btn-light ms-2">
                <i class="bi bi-box-arrow-right me-1"></i> Logout
              </button>
            </form>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Konten -->
  <div class="container py-4">
    @yield('content')
  </div>

  <!-- Footer -->
  <footer>
    &copy; {{ date('Y') }} Bakso Siocay — Rasa Nikmat, Harga Bersahabat 🍜
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
