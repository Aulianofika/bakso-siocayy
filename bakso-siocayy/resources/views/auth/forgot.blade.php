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
            <button type="button" class="btn-toggle" id="toggleNewPassword">
                <i class="bi bi-eye" id="iconNewPassword"></i>
            </button>
        </div>
    </div>

    <div class="mb-3 text-start">
        <label class="form-label"><i class="bi bi-shield-lock-fill me-1"></i> Konfirmasi Password</label>
        <div class="input-group">
            <input type="password" name="password_confirmation" id="confirmPassword" class="form-control" placeholder="Ulangi password baru..." required>
            <button type="button" class="btn-toggle" id="toggleConfirmPassword">
                <i class="bi bi-eye" id="iconConfirmPassword"></i>
            </button>
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

@push('scripts')
<script>
    // Lihat / sembunyikan password
    const toggleNew = document.getElementById('toggleNewPassword');
    const newPass = document.getElementById('newPassword');
    const iconNew = document.getElementById('iconNewPassword');

    const toggleConfirm = document.getElementById('toggleConfirmPassword');
    const confirmPass = document.getElementById('confirmPassword');
    const iconConfirm = document.getElementById('iconConfirmPassword');

    toggleNew.addEventListener('click', () => {
        const type = newPass.type === 'password' ? 'text' : 'password';
        newPass.type = type;
        iconNew.classList.toggle('bi-eye');
        iconNew.classList.toggle('bi-eye-slash');
    });

    toggleConfirm.addEventListener('click', () => {
        const type = confirmPass.type === 'password' ? 'text' : 'password';
        confirmPass.type = type;
        iconConfirm.classList.toggle('bi-eye');
        iconConfirm.classList.toggle('bi-eye-slash');
    });
</script>
@endpush
@endsection
