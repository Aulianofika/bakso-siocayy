@extends('layouts.auth')
@section('title', 'Login')

@section('content')
<form method="POST" action="{{ route('login') }}">
  @csrf
  @if(session('success'))
    <div class="alert alert-success small mt-2 fade show text-start" id="alertMessage">
      <i class="bi bi-check-circle-fill me-1"></i> {{ session('success') }}
    </div>
  @endif

  {{-- ❌ Alert error (email/password salah) --}}
  @if($errors->any())
    <div class="alert alert-danger small mt-2 fade show text-start" id="alertMessage">
      <i class="bi bi-exclamation-triangle-fill me-1"></i> {{ $errors->first() }}
    </div>
  @endif

  <div class="mb-3 text-start">
    <label class="form-label"><i class="bi bi-envelope-fill me-1"></i> Email</label>
    <input type="email" name="email" class="form-control" placeholder="Masukkan email kamu..." required autofocus>
  </div>

  <div class="mb-3 text-start">
    <label class="form-label"><i class="bi bi-lock-fill me-1"></i> Password</label>
    <div class="input-group">
      <input type="password" name="password" id="password" class="form-control" placeholder="Masukkan password" required>
      <button type="button" class="btn-toggle" id="togglePassword">
        <i class="bi bi-eye" id="toggleIcon"></i>
      </button>
    </div>
  </div>

  <div class="d-flex justify-content-between align-items-center mb-3">
    <a href="{{ route('forgot') }}" class="link-green small">Lupa password?</a>
  </div>

  <button type="submit" class="btn-green w-100">
    <i class="bi bi-box-arrow-in-right me-1"></i> Masuk
  </button>

  <div class="mt-3 text-center">
    <span class="small text-muted">Belum punya akun?</span>
    <a href="{{ route('register') }}" class="link-green small">Daftar sekarang</a>
  </div>
</form>

@push('scripts')
<script>
  const togglePassword = document.querySelector("#togglePassword");
  const password = document.querySelector("#password");
  const toggleIcon = document.querySelector("#toggleIcon");

  togglePassword.addEventListener("click", () => {
    const type = password.getAttribute("type") === "password" ? "text" : "password";
    password.setAttribute("type", type);
    toggleIcon.classList.toggle("bi-eye");
    toggleIcon.classList.toggle("bi-eye-slash");
  });
</script>
@endpush
@endsection
