@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')
    <div class="card shadow-sm p-4">
        <h2>Dashboard Admin</h2>
        <p>Halo {{ Auth::user()->name }}, kamu login sebagai <strong>{{ Auth::user()->role }}</strong>.</p>
        <div class="container-fluid">
  <div class="row g-3">
    <div class="col-md-3">
      <div class="card-dashboard bg-purple">
        <h5><i class="bi bi-box-seam me-2"></i>Produk</h5>
        <h2>{{ $totalProducts ?? 0 }}</h2>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card-dashboard bg-blue">
        <h5><i class="bi bi-cart-check me-2"></i>Pesanan</h5>
        <h2>{{ $totalOrders ?? 0 }}</h2>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card-dashboard bg-green">
        <h5><i class="bi bi-truck me-2"></i>Pengiriman</h5>
        <h2>{{ $totalShipments ?? 0 }}</h2>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card-dashboard bg-red">
        <h5><i class="bi bi-arrow-repeat me-2"></i>Retur</h5>
        <h2>{{ $totalReturns ?? 0 }}</h2>
      </div>
    </div>
  </div>
</div>
    </div>

    

@endsection
