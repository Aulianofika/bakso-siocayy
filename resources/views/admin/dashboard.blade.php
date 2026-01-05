@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')


    <div class="row g-3 mb-4">
        <!-- Welcome Section (Optional, adds a personal touch) -->
        <div class="col-12">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <h3 class="fw-bold text-dark mb-1">Dashboard Overview</h3>
                    <p class="text-muted mb-0">Selamat datang kembali, {{ Auth::user()->name ?? 'Admin' }}! 👋</p>
                </div>
                <div>
                    <span class="badge bg-white text-muted border shadow-sm px-3 py-2 fw-normal">
                        <i class="bi bi-calendar-event me-1"></i> {{ now()->translatedFormat('l, d F Y') }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Statistik Cards -->
        <div class="col-xl-3 col-md-6">
            <div class="card card-stat border-0 h-100" style="background: linear-gradient(145deg, #ffffff, #f0fdf4);">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-uppercase text-muted fw-bold small mb-2" style="letter-spacing: 0.5px;">Total
                                Pesanan</p>
                            <h3 class="fw-bolder mb-1 text-dark">{{ number_format($totalPesanan ?? 0) }}</h3>
                            <div class="mt-2 text-warning small fw-bold">
                                <i class="bi bi-hourglass-split me-1"></i>{{ $pesananPending ?? 0 }} Pending
                            </div>
                        </div>
                        <div class="p-3 bg-white rounded-4 shadow-sm text-success">
                            <i class="bi bi-receipt fs-3"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card card-stat border-0 h-100" style="background: linear-gradient(145deg, #ffffff, #eff6ff);">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-uppercase text-muted fw-bold small mb-2" style="letter-spacing: 0.5px;">Pesanan
                                Hari Ini</p>
                            <h3 class="fw-bolder mb-1 text-dark">{{ number_format($pesananHariIni ?? 0) }}</h3>
                            <div class="mt-2 text-primary small fw-bold">
                                <i class="bi bi-plus-circle me-1"></i>{{ $pesananBaru ?? 0 }} Baru (7 hari)
                            </div>
                        </div>
                        <div class="p-3 bg-white rounded-4 shadow-sm text-primary">
                            <i class="bi bi-calendar-check fs-3"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card card-stat border-0 h-100" style="background: linear-gradient(145deg, #ffffff, #ecfccb);">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-uppercase text-muted fw-bold small mb-2" style="letter-spacing: 0.5px;">Revenue
                            </p>
                            <h3 class="fw-bolder mb-1 text-dark">Rp {{ number_format($totalPendapatan ?? 0, 0, ',', '.') }}
                            </h3>
                            <div class="mt-2 text-success small fw-bold">
                                + Rp {{ number_format($pendapatanHariIni ?? 0, 0, ',', '.') }} (Hari Ini)
                            </div>
                        </div>
                        <div class="p-3 bg-white rounded-4 shadow-sm text-success">
                            <i class="bi bi-cash-coin fs-3"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card card-stat border-0 h-100" style="background: linear-gradient(145deg, #ffffff, #faf5ff);">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-uppercase text-muted fw-bold small mb-2" style="letter-spacing: 0.5px;">Produk &
                                User</p>
                            <h3 class="fw-bolder mb-1 text-dark">{{ number_format($totalProduk ?? 0) }} <span
                                    class="fs-6 text-muted fw-normal">Item</span></h3>
                            <div class="mt-2 text-purple small fw-bold">
                                <i class="bi bi-people me-1"></i>{{ number_format($totalPelanggan ?? 0) }} Pelanggan
                            </div>
                        </div>
                        <div class="p-3 bg-white rounded-4 shadow-sm text-purple" style="color: #9333ea;">
                            <i class="bi bi-box-seam fs-3"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Status Pesanan & Pendapatan Bulan Ini -->
    <div class="row g-4 mb-4">
        <div class="col-lg-8">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-header border-0 bg-transparent py-3 d-flex align-items-center gap-2">
                    <div class="bg-primary-100 text-primary-700 rounded p-1">
                        <i class="bi bi-pie-chart-fill"></i>
                    </div>
                    <h6 class="fw-bold mb-0">Status Pesanan</h6>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-sm-6 col-md-3">
                            <div class="p-3 border rounded-3 bg-light text-center h-100">
                                <div class="avatar-sm mb-2 mx-auto bg-warning-subtle text-warning rounded-circle d-flex align-items-center justify-content-center"
                                    style="width:40px;height:40px;">
                                    <i class="bi bi-hourglass-split"></i>
                                </div>
                                <h4 class="fw-bold mb-0 text-dark">{{ $pesananByStatus['Pending'] ?? 0 }}</h4>
                                <span class="text-muted small">Pending</span>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <div class="p-3 border rounded-3 bg-light text-center h-100">
                                <div class="avatar-sm mb-2 mx-auto bg-primary-subtle text-primary rounded-circle d-flex align-items-center justify-content-center"
                                    style="width:40px;height:40px;">
                                    <i class="bi bi-gear-wide-connected"></i>
                                </div>
                                <h4 class="fw-bold mb-0 text-dark">{{ $pesananByStatus['Diproses'] ?? 0 }}</h4>
                                <span class="text-muted small">Diproses</span>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <div class="p-3 border rounded-3 bg-light text-center h-100">
                                <div class="avatar-sm mb-2 mx-auto bg-info-subtle text-info rounded-circle d-flex align-items-center justify-content-center"
                                    style="width:40px;height:40px;">
                                    <i class="bi bi-box-seam"></i>
                                </div>
                                <h4 class="fw-bold mb-0 text-dark">{{ $pesananByStatus['Siap Dikirim'] ?? 0 }}</h4>
                                <span class="text-muted small">Siap Kirim</span>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <div class="p-3 border rounded-3 bg-light text-center h-100">
                                <div class="avatar-sm mb-2 mx-auto bg-success-subtle text-success rounded-circle d-flex align-items-center justify-content-center"
                                    style="width:40px;height:40px;">
                                    <i class="bi bi-check-lg"></i>
                                </div>
                                <h4 class="fw-bold mb-0 text-dark">{{ $pesananByStatus['Selesai'] ?? 0 }}</h4>
                                <span class="text-muted small">Selesai</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card h-100 border-0 shadow-sm bg-gradient-success text-white"
                style="background: linear-gradient(135deg, #10b981 0%, #047857 100%);">
                <div class="card-body d-flex flex-column justify-content-center text-center p-4">
                    <div class="mb-3">
                        <div class="d-inline-flex bg-white bg-opacity-25 rounded-circle p-3 mb-2">
                            <i class="bi bi-wallet2 fs-2 text-white"></i>
                        </div>
                    </div>
                    <h5 class="text-white text-opacity-75 font-monospace mb-1">Pendapatan
                        {{ now()->translatedFormat('F Y') }}</h5>
                    <h2 class="fw-bold text-white mb-2 display-6">Rp
                        {{ number_format($pendapatanBulanIni ?? 0, 0, ',', '.') }}</h2>
                    <div class="mt-2">
                        <span class="badge bg-white bg-opacity-25 fw-normal px-3 py-2 rounded-pill">
                            <i class="bi bi-graph-up-arrow me-1"></i> Data Realtime
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Grafik Penjualan (Simple Table for now, maybe replaced by Chart.js later) -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header border-0 bg-transparent py-3 d-flex align-items-center gap-2">
            <div class="bg-success-subtle text-success rounded p-1">
                <i class="bi bi-bar-chart-fill"></i>
            </div>
            <h6 class="fw-bold mb-0">Statistik Penjualan (7 Hari Terakhir)</h6>
        </div>
        <div class="card-body">
            @if(isset($penjualanMingguan) && $penjualanMingguan->isEmpty())
                <div class="text-center text-muted py-5">
                    <i class="bi bi-clipboard-data display-4 text-secondary opacity-25"></i>
                    <p class="mt-3">Belum ada data penjualan minggu ini.</p>
                </div>
            @elseif(isset($penjualanMingguan) && $penjualanMingguan->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-3">Tanggal</th>
                                <th class="text-end">Jml Pesanan</th>
                                <th class="text-end pe-3">Total Nominal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($penjualanMingguan as $data)
                                <tr>
                                    <td class="ps-3 fw-medium">
                                        {{ \Carbon\Carbon::parse($data->tanggal)->translatedFormat('d M Y') }}</td>
                                    <td class="text-end">
                                        <span class="badge bg-secondary-subtle text-secondary rounded-pill px-3">{{ $data->jumlah }}
                                            Order</span>
                                    </td>
                                    <td class="text-end pe-3 fw-bold text-success">
                                        Rp {{ number_format($data->total, 0, ',', '.') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center text-muted py-5">
                    <p>Data tidak tersedia.</p>
                </div>
            @endif
        </div>
    </div>

    <div class="row g-4">
        <!-- Pesanan Terbaru -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header border-0 bg-transparent py-3 d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center gap-2">
                        <div class="bg-primary-subtle text-primary rounded p-1">
                            <i class="bi bi-clock-history"></i>
                        </div>
                        <h6 class="fw-bold mb-0">Pesanan Terbaru</h6>
                    </div>
                    <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-light text-primary fw-bold">Lihat
                        Semua</a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead>
                                <tr>
                                    <th class="ps-4">Invoice</th>
                                    <th>Pelanggan</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th class="text-end pe-4">Waktu</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pesananTerbaru as $order)
                                    @php
                                        $statusBadge = match ($order->status_order) {
                                            'Pending' => 'bg-warning-subtle text-warning border border-warning-subtle',
                                            'Diproses' => 'bg-primary-subtle text-primary border border-primary-subtle',
                                            'Siap Dikirim' => 'bg-info-subtle text-info border border-info-subtle',
                                            'Selesai' => 'bg-success-subtle text-success border border-success-subtle',
                                            'Ditolak' => 'bg-danger-subtle text-danger border border-danger-subtle',
                                            default => 'bg-secondary-subtle text-secondary'
                                        };
                                    @endphp
                                    <tr>
                                        <td class="ps-4">
                                            <span class="font-monospace text-dark fw-bold">#{{ $order->invoice_number }}</span>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                <div class="avatar-xs rounded-circle bg-secondary-subtle d-flex align-items-center justify-content-center"
                                                    style="width:24px;height:24px;font-size:10px;">
                                                    {{ substr($order->user->name ?? 'U', 0, 1) }}
                                                </div>
                                                <span class="small fw-semibold">{{ $order->user->name ?? 'Guest' }}</span>
                                            </div>
                                        </td>
                                        <td class="fw-bold text-dark">
                                            Rp {{ number_format($order->total_price, 0, ',', '.') }}
                                        </td>
                                        <td>
                                            <span class="badge rounded-pill {{ $statusBadge }} fw-normal px-2">
                                                {{ $order->status_order }}
                                            </span>
                                        </td>
                                        <td class="text-end pe-4 text-muted small">
                                            {{ $order->created_at->diffForHumans() }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted py-5">
                                            Belum ada pesanan terbaru.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Top Products -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header border-0 bg-transparent py-3 d-flex align-items-center gap-2">
                    <div class="bg-warning-subtle text-warning rounded p-1">
                        <i class="bi bi-trophy-fill"></i>
                    </div>
                    <h6 class="fw-bold mb-0">Menu Favorit</h6>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        @forelse($topProducts as $index => $item)
                            <div class="list-group-item border-light py-3 px-4 d-flex align-items-center gap-3">
                                <h5 class="mb-0 text-muted fw-bold opacity-50">#{{ $index + 1 }}</h5>
                                <div class="flex-grow-1">
                                    <h6 class="mb-0 fw-bold text-dark">{{ $item->product->name ?? 'Unknown' }}</h6>
                                    <small class="text-muted">{{ $item->total_terjual }} terjual</small>
                                </div>
                                <div class="text-success fw-bold">
                                    <i class="bi bi-graph-up-arrow small me-1"></i>Top
                                </div>
                            </div>
                        @empty
                            <div class="text-center text-muted py-4">
                                Belum ada data produk favorit.
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection