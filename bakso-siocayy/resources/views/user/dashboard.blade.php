@extends('layouts.app')

@section('title', 'Dashboard User')

@section('content')
    <div class="card shadow-sm p-4">
        <h2>Dashboard User</h2>
        <p>Halo {{ Auth::user()->name }}, selamat datang di Bakso Siocay!</p>
    </div>
@endsection
