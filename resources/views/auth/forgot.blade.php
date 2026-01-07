@extends('layouts.auth')
@section('title', 'Lupa Password')

@section('content')
    @if(session('success'))
        <div class="alert alert-success small text-center">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger small text-center">
            <ul class="mb-0 text-start ps-3">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
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
                <input type="password" name="password" id="newPassword" class="form-control"
                    placeholder="Buat password baru..." required minlength="6">
            </div>
        </div>

        <div class="mb-3 text-start">
            <label class="form-label"><i class="bi bi-shield-lock-fill me-1"></i> Konfirmasi Password</label>
            <div class="input-group mb-2">
                <input type="password" name="password_confirmation" id="confirmPassword" class="form-control"
                    placeholder="Ulangi password baru..." required minlength="6">
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="showPassForgot" onclick="toggleForgotPass()">
                <label class="form-check-label small" for="showPassForgot">Lihat Password</label>
            </div>
        </div>

        <script>
            function toggleForgotPass() {
                var p = document.getElementById("newPassword");
                var c = document.getElementById("confirmPassword");
                if (p.type === "password") {
                    p.type = "text";
                    c.type = "text";
                } else {
                    p.type = "password";
                    c.type = "password";
                }
            }
        </script>

        <button type="submit" class="btn-green w-100 mt-3">
            <i class="bi bi-arrow-repeat me-1"></i> Reset Password
        </button>

        <div class="mt-3 text-center">
            <span class="text-muted small">Ingat password kamu?</span>
            <a href="{{ route('login') }}" class="link-green small">Kembali ke Login</a>
        </div>
    </form>

@endsection