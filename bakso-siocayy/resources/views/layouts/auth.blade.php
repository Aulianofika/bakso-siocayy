<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>@yield('title') | Bakso Siocay</title>

  <!-- Bootstrap CSS & Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;700&display=swap" rel="stylesheet">

  <style>
    :root {
      --green-dark: #2f7a52;
      --green-main: #3ca65a;
      --green-light: #6fcf8f;
      --bg: #f2fbf4;
      --white: #ffffff;
    }

    body {
      font-family: 'Outfit', sans-serif;
      background: linear-gradient(140deg, var(--bg) 0%, #e7f9ea 100%);
      display: flex;
      align-items: center;
      justify-content: center;
      min-height: 100vh;
      margin: 0;
      padding: 20px;
    }

    .auth-card {
      width: 100%;
      max-width: 400px;
      background: var(--white);
      border-radius: 20px;
      box-shadow: 0 8px 30px rgba(40, 80, 60, 0.08);
      padding: 2.5rem;
      text-align: center;
      position: relative;
      overflow: hidden;
      animation: fadeIn 0.6s ease;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(15px); }
      to { opacity: 1; transform: translateY(0); }
    }

    /* Floating subtle background icons */
    .floating-icon {
      position: absolute;
      font-size: 80px;
      opacity: 0.05;
      animation: float 6s ease-in-out infinite;
      z-index: 0;
    }
    .floating-icon:nth-child(1) { top: 15px; left: 25px; animation-delay: 0s; }
    .floating-icon:nth-child(2) { bottom: 20px; right: 30px; animation-delay: 2s; }
    .floating-icon:nth-child(3) { top: 45%; right: -15px; animation-delay: 4s; }

    @keyframes float {
      0%,100% { transform: translateY(0) rotate(0deg); }
      50% { transform: translateY(-8px) rotate(8deg); }
    }

    /* Logo */
    .logo-wrap {
      width: 70px;
      height: 70px;
      margin: 0 auto 15px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      background: linear-gradient(135deg, var(--green-main), var(--green-dark));
      color: #fff;
      font-size: 34px;
      box-shadow: 0 6px 20px rgba(46, 100, 66, 0.25);
    }

    h1.brand {
      font-weight: 5;
      color: var(--green-dark);
      margin-bottom: 3px;
    }

    p.subtitle {
      color: #6b7c6f;
      font-size: 0.92rem;
      margin-bottom: 22px;
    }

    label.form-label {
      font-weight: 600;
      color: var(--green-dark);
      text-align: left;
      display: block;
    }

    .form-control {
      border-radius: 10px;
      border: 1px solid #d9f1df;
      padding: 10px 12px;
    }

    .form-control:focus {
      border-color: var(--green-main);
      box-shadow: 0 0 0 4px rgba(60,166,90,0.12);
      outline: none;
    }

    .input-group .btn-toggle {
      border: 1px solid #d9f1df;
      border-left: none;
      color: var(--green-dark);
      background: #f8fff9;
    }

    .btn-green {
      background: linear-gradient(135deg, var(--green-main), var(--green-dark));
      border: none;
      border-radius: 10px;
      color: #fff;
      font-weight: 600;
      padding: 11px 0;
      margin-top: 10px;
      transition: all 0.3s ease;
    }

    .btn-green:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 20px rgba(40,80,50,0.15);
    }

    .link-green {
      color: var(--green-dark);
      text-decoration: none;
      font-weight: 500;
    }

    .link-green:hover {
      text-decoration: underline;
      color: var(--green-main);
    }

    .footer {
      margin-top: 25px;
      font-size: 0.85rem;
      color: #8a998e;
    }
  </style>
</head>

<body>
  <div class="auth-card">
    <!-- Floating icons background -->
    <i class="bi bi-cup-hot-fill floating-icon"></i>
    <i class="bi bi-basket-fill floating-icon"></i>
    <i class="bi bi-shop floating-icon"></i>

    <!-- Logo -->
    <div class="logo-wrap">
      <i class="bi bi-cup-hot"></i>
    </div>

    <h1 class="brand">Bakso Siocay</h1>
    <p class="subtitle">Hangat, lezat, dan dekat denganmu</p>

    <main>
      @yield('content')
    </main>

    <div class="footer">&copy; {{ date('Y') }} Bakso Siocay</div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  @stack('scripts')
</body>
</html>
