@extends('layouts.auth')
@section('title', 'Daftar')

@section('content')
<form method="POST" action="{{ route('register') }}">
  @csrf

  @if(session('success'))
    <div class="alert alert-success small mt-2 fade show text-start" id="alertMessage">
      <i class="bi bi-check-circle-fill me-1"></i> {{ session('success') }}
      
    </div>
  @endif

  @if($errors->any())
    <div class="alert alert-danger small mt-2 fade show text-start" id="alertMessage">
      <i class="bi bi-exclamation-triangle-fill me-1"></i> {{ $errors->first() }}
    </div>
  @endif

  <div class="mb-3 text-start">
    <label class="form-label"><i class="bi bi-person-fill me-1"></i> Nama Lengkap</label>
    <input type="text" name="name" class="form-control" placeholder="Masukkan nama lengkap..." required autofocus>
  </div>

  <div class="mb-3 text-start">
    <label class="form-label"><i class="bi bi-envelope-fill me-1"></i> Email</label>
    <input type="email" name="email" class="form-control" placeholder="Masukkan email..." required>
  </div>

  <div class="mb-3 text-start">
    <label class="form-label"><i class="bi bi-lock-fill me-1"></i> Password</label>
    <div class="input-group">
      <input type="password" name="password" id="password" class="form-control" placeholder="Masukkan password" required>
    </div>
  </div>

  <div class="mb-3 text-start">
    <label class="form-label"><i class="bi bi-lock-fill me-1"></i> Konfirmasi Password</label>
    <div class="input-group">
      <input type="password" name="password_confirmation" id="passwordConfirmation" class="form-control" placeholder="ketik lagi password" required>
    </div>
  </div>

  <button type="submit" class="btn-green w-100">
    <i class="bi bi-person-plus-fill me-1"></i> Daftar
  </button>

  <div class="mt-3 text-center">
    <span class="small text-muted">Sudah punya akun?</span>
    <a href="{{ route('login') }}" class="link-green small">Masuk sekarang</a>
  </div>
</form>

@endsection
