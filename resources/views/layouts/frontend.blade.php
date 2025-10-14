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

    .btn-logout {
      background-color: #fff;
      color: #3ca65a;
      font-weight: 500;
      border-radius: 8px;
      transition: 0.3s;
    }
    .btn-logout:hover {
      background-color: #e9f6ec;
      color: #2f7a52;
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
        <i class="bi bi-cup-hot-fill me-1"></i> Bakso Siocay
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto align-items-center">
          <li class="nav-item"><a href="{{ url('/home') }}" class="nav-link">Beranda</a></li>
          <li class="nav-item"><a href="{{ url('/menu') }}" class="nav-link">Produk</a></li>
          <li class="nav-item"><a href="{{ url('/pesanan-saya') }}" class="nav-link">Pesanan Saya</a></li>
          <li class="nav-item">
            <form method="POST" action="{{ route('logout') }}" class="d-inline">
              @csrf
              <button class="btn btn-sm btn-logout ms-2">Logout</button>
            </form>
          </li>
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
    &copy; {{ date('Y') }} Bakso Siocay — Hangat, Lezat, dan Dekat denganmu 💚
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
