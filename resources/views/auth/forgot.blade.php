@extends('layouts.auth')
@section('title', 'Lupa Password')

@section('content')
@if(session('success'))
    <div class="alert alert-success small text-center">{{ session('success') }}</div>
@endif

<form method="POST" action="{{ route('forgot') }}">
    @csrf

    <div class="mb-3 text-start">
        <label class="form-label"><i class="bi bi-envelope-fill me-1"></i> Email</label>
        <input type="email" name="email" class="form-control" placeholder="Masukkan email..." required>
    </div>

    <div class="mb-3 text-start">
        <label class="form-label"><i class="bi bi-lock-fill me-1"></i> Password Baru</label>
        <div class="input-group">
            <input type="password" name="password" id="newPassword" class="form-control" placeholder="Buat password baru..." required>
        </div>
    </div>

    <div class="mb-3 text-start">
        <label class="form-label"><i class="bi bi-shield-lock-fill me-1"></i> Konfirmasi Password</label>
        <div class="input-group">
            <input type="password" name="password_confirmation" id="confirmPassword" class="form-control" placeholder="Ulangi password baru..." required>
        </div>
    </div>

    <button type="submit" class="btn-green w-100 mt-3">
        <i class="bi bi-arrow-repeat me-1"></i> Reset Password
    </button>

    <div class="mt-3 text-center">
        <span class="text-muted small">Ingat password kamu?</span>
        <a href="{{ route('login') }}" class="link-green small">Kembali ke Login</a>
    </div>
</form>

@endsection
