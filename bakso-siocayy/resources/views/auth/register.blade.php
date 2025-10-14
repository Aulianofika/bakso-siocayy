@extends('layouts.auth')
@section('title', 'Daftar')

@section('content')
<form method="POST" action="{{ route('register') }}">
    @csrf

    <div class="mb-3 text-start">
        <label class="form-label"><i class="bi bi-person-fill me-1"></i> Nama Lengkap</label>
        <input type="text" name="name" class="form-control" placeholder="Masukkan nama lengkap kamu..." required>
    </div>

    <div class="mb-3 text-start">
        <label class="form-label"><i class="bi bi-envelope-fill me-1"></i> Email</label>
        <input type="email" name="email" class="form-control" placeholder="Masukkan email aktif..." required>
    </div>

    <div class="mb-3 text-start">
        <label class="form-label"><i class="bi bi-lock-fill me-1"></i> Password</label>
        <div class="input-group">
            <input type="password" name="password" id="password" class="form-control" placeholder="Buat password" required>
            <button type="button" class="btn-toggle" id="togglePassword">
                <i class="bi bi-eye" id="toggleIcon"></i>
            </button>
        </div>
    </div>

    <div class="mb-3 text-start">
        <label class="form-label"><i class="bi bi-shield-lock-fill me-1"></i> Konfirmasi Password</label>
        <div class="input-group">
            <input type="password" name="password_confirmation" id="passwordConfirm" class="form-control" placeholder="Ulangi password" required>
            <button type="button" class="btn-toggle" id="toggleConfirm">
                <i class="bi bi-eye" id="toggleIconConfirm"></i>
            </button>
        </div>
    </div>

    <button type="submit" class="btn-green w-100 mt-3">
        <i class="bi bi-person-plus-fill me-1"></i> Daftar Sekarang
    </button>

    <div class="mt-3 text-center">
        <span class="text-muted small">Sudah punya akun?</span>
        <a href="{{ route('login') }}" class="link-green small">Masuk Sekarang</a>
    </div>
</form>

@push('scripts')
<script>
  // Toggle password visibility
  const togglePassword = document.querySelector("#togglePassword");
  const password = document.querySelector("#password");
  const toggleIcon = document.querySelector("#toggleIcon");

  const toggleConfirm = document.querySelector("#toggleConfirm");
  const passwordConfirm = document.querySelector("#passwordConfirm");
  const toggleIconConfirm = document.querySelector("#toggleIconConfirm");

  togglePassword.addEventListener("click", () => {
    const type = password.getAttribute("type") === "password" ? "text" : "password";
    password.setAttribute("type", type);
    toggleIcon.classList.toggle("bi-eye");
    toggleIcon.classList.toggle("bi-eye-slash");
  });

  toggleConfirm.addEventListener("click", () => {
    const type = passwordConfirm.getAttribute("type") === "password" ? "text" : "password";
    passwordConfirm.setAttribute("type", type);
    toggleIconConfirm.classList.toggle("bi-eye");
    toggleIconConfirm.classList.toggle("bi-eye-slash");
  });
</script>
@endpush
@endsection
