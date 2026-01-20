@extends('layouts.frontend')

@section('title', 'Riwayat Pesanan')

@section('content')
    <div class="container py-5">

        {{-- Page Header --}}
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-5 gap-3">
            <div class="d-flex align-items-center">
                <div class="bg-success bg-gradient p-3 rounded-4 shadow-sm text-white me-3">
                    <i class="bi bi-bag-check-fill fs-3"></i>
                </div>
                <div>
                    <h3 class="fw-bold text-dark mb-1">Riwayat Pesanan</h3>
                    <p class="text-secondary mb-0">Kelola dan pantau semua transaksi Anda</p>
                </div>
            </div>
            <a href="{{ url('/menu') }}" class="btn btn-outline-success rounded-pill fw-bold px-4 py-2">
                <i class="bi bi-bag me-2"></i>Ayo Belanja lagi
            </a>
        </div>


        @if(isset($notifications) && $notifications->count() > 0)
            <div class="mb-4">
                @foreach($notifications as $notification)
                    <div class="alert alert-info border-0 shadow-sm d-flex align-items-center gap-3 rounded-4 fade show"
                        role="alert">
                        <div class="bg-white text-info rounded-circle d-flex align-items-center justify-content-center flex-shrink-0"
                            style="width: 40px; height: 40px;">
                            <i class="bi bi-bell-fill"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold mb-0 text-dark alert-heading">
                                Update Pesanan: #{{ $notification->data['invoice_number'] }}
                            </h6>
                            <p class="mb-0 small text-secondary">
                                {{ $notification->data['message'] }}
                            </p>
                        </div>
                        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endforeach
            </div>
        @endif

        <div class="row g-4">
            @forelse ($orders as $order)
                @php
                    $statusColor = match ($order->status_order) {
                        'Pending' => 'warning',
                        'Diproses' => 'primary',
                        'Siap Dikirim' => 'info',
                        'Dikirim' => 'primary',
                        'Selesai', 'Diterima' => 'success',
                        'Ditolak' => 'danger',
                        default => 'secondary'
                    };

                    $statusLabel = $order->status_order;
                    if ($statusLabel == 'Siap Dikirim')
                        $statusLabel = 'Siap Kirim';

                    $paymentColor = match ($order->status_payment) {
                        'Lunas' => 'success',
                        'Ditolak' => 'danger',
                        'Menunggu Verifikasi' => 'warning',
                        'Belum Bayar' => 'warning',
                        default => 'secondary'
                    };
                @endphp

                <div class="col-12">
                    <div class="card border-0 rounded-4 shadow-sm overflow-hidden card-order transition-all">

                        {{-- Card Header --}}
                        <div class="card-header bg-white p-4 border-bottom-0">
                            <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
                                <div class="d-flex flex-wrap align-items-center gap-3">
                                    <span
                                        class="badge bg-{{ $statusColor }}-subtle text-{{ $statusColor }} border border-{{ $statusColor }}-subtle px-3 py-2 rounded-pill fw-bold">
                                        <i class="bi bi-circle-fill me-1" style="font-size: 6px; vertical-align: middle;"></i>
                                        {{ $order->status_order }}
                                    </span>
                                    <div class="vr mx-2 bg-secondary opacity-25 d-none d-md-block"></div>
                                    <span class="text-secondary fw-medium small">
                                        <i class="bi bi-hash me-1"></i>{{ $order->invoice_number }}
                                    </span>
                                    <span class="text-secondary fw-medium small d-none d-md-inline">
                                        <i class="bi bi-calendar3 me-1 ms-2"></i>
                                        {{ $order->created_at->translatedFormat('d M Y, H:i') }}
                                    </span>
                                </div>

                                {{-- Mobile date --}}
                                <small class="text-muted d-block d-md-none w-100">
                                    {{ $order->created_at->translatedFormat('d M Y, H:i') }}
                                </small>
                            </div>
                        </div>

                        {{-- Card Body --}}
                        <div class="card-body px-4 pt-0 pb-4">
                            <div class="row g-0">

                                {{-- Product List Section --}}
                                <div class="col-lg-8 pe-lg-5">
                                    <div class="d-flex flex-column gap-3">
                                        @foreach ($order->orderItems as $item)
                                            @php
                                                $imgSrc = $item->product && $item->product->image
                                                    ? asset('images/products/' . $item->product->image)
                                                    : asset('images/no-image.png');
                                            @endphp
                                            <div
                                                class="d-flex align-items-center p-3 rounded-3 bg-light bg-opacity-50 border border-light-subtle product-item">
                                                <img src="{{ $imgSrc }}" alt="{{ $item->product->name ?? 'Produk' }}"
                                                    class="rounded-3 shadow-sm object-fit-cover" style="width: 70px; height: 70px;">

                                                <div class="ms-3 flex-grow-1">
                                                    <h6 class="mb-1 fw-bold text-dark">
                                                        {{ $item->product->name ?? 'Produk Dihapus' }}
                                                    </h6>
                                                    <div class="d-flex align-items-center text-muted small">
                                                        <span class="bg-white px-2 py-1 rounded border">{{ $item->quantity }}
                                                            x</span>
                                                        <span class="ms-2">Rp {{ number_format($item->price, 0, ',', '.') }}</span>
                                                    </div>
                                                </div>
                                                <div class="fw-bold text-dark text-end">
                                                    Rp {{ number_format($item->quantity * $item->price, 0, ',', '.') }}
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                {{-- Summary & Actions Section --}}
                                <div class="col-lg-4 mt-4 mt-lg-0 border-start-lg ps-lg-4">
                                    <div class="h-100 d-flex flex-column justify-content-between">
                                        <div>
                                            <h6 class="text-uppercase text-secondary fw-bold small mb-3 ls-1">Rincian Pembayaran
                                            </h6>

                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <span class="text-muted small">Metode</span>
                                                <span class="fw-semibold text-dark">{{ ucfirst($order->payment_method) }}</span>
                                            </div>

                                            <div class="d-flex justify-content-between align-items-center mb-3">
                                                <span class="text-muted small">Status Bayar</span>
                                                <span
                                                    class="badge bg-{{ $paymentColor }}-subtle text-{{ $paymentColor }} rounded-pill px-2">
                                                    {{ $order->status_payment }}
                                                </span>
                                            </div>

                                            @if($order->status_payment === 'Ditolak' && $order->rejection_note)
                                                <div class="alert alert-danger py-2 px-3 rounded-3 small mb-3">
                                                    <strong>Alasan Penolakan:</strong><br>
                                                    {{ $order->rejection_note }}
                                                </div>
                                            @endif

                                            <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                                                <span class="fw-bold text-dark">Total Tagihan</span>
                                                <span class="fw-bold text-success fs-5">Rp
                                                    {{ number_format($order->total_price, 0, ',', '.') }}</span>
                                            </div>
                                        </div>

                                        <div class="mt-4 d-grid gap-2">
                                            @if($order->status_order === 'Dikirim')
                                                <form action="{{ route('orders.received', $order->id) }}" method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button onclick="return confirm('Pesanan sudah diterima dengan baik?')"
                                                        class="btn btn-success w-100 fw-bold shadow-sm py-2">
                                                        <i class="bi bi-box-seam-fill me-2"></i>Pesanan Diterima
                                                    </button>
                                                </form>
                                            @endif

                                            @if($order->status_order === 'Selesai' || $order->status_order === 'Diterima')
                                                <div class="d-grid gap-2">
                                                    <div class="bg-success-subtle rounded-pill p-2 text-center border border-success">
                                                        <span class="text-success fw-bold small"><i class="bi bi-check-circle-fill me-1"></i> Transaksi Selesai</span>
                                                    </div>
                                                    
                                                    <div class="row g-2">
                                                        @if ($order->payment_method === 'transfer' && $order->bukti_transfer)
                                                            <div class="col-6">
                                                                <button class="btn btn-outline-secondary btn-sm fw-bold w-100 py-2 rounded-pill small hover-scale"
                                                                    data-bs-toggle="modal" data-bs-target="#buktiModal{{ $order->id }}">
                                                                    <i class="bi bi-image me-1"></i> Bukti Bayar
                                                                </button>
                                                            </div>
                                                            <div class="col-6">
                                                                <a href="{{ route('orders.invoice', $order->id) }}" target="_blank"
                                                                    class="btn btn-white border shadow-sm w-100 py-2 rounded-pill fw-bold text-dark small hover-scale">
                                                                    <i class="bi bi-receipt me-1"></i> Struk
                                                                </a>
                                                            </div>
                                                        @else
                                                            <div class="col-12">
                                                                <a href="{{ route('orders.invoice', $order->id) }}" target="_blank"
                                                                    class="btn btn-white border shadow-sm w-100 py-2 rounded-pill fw-bold text-dark small hover-scale">
                                                                    <i class="bi bi-receipt me-1"></i> Lihat Struk Belanja
                                                                </a>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            @elseif ($order->payment_method === 'transfer' && $order->bukti_transfer)
                                                 <button class="btn btn-outline-secondary btn-sm fw-medium w-100 py-2 rounded-pill"
                                                    data-bs-toggle="modal" data-bs-target="#buktiModal{{ $order->id }}">
                                                    <i class="bi bi-receipt me-2"></i>Lihat Bukti Bayar
                                                </button>
                                            @endif

                                            @if(in_array($order->status_order, ['Pending', 'Diproses']))
                                                <form action="{{ route('orders.cancel', $order->id) }}" method="POST" class="mt-2">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button onclick="return confirm('Apakah Anda yakin ingin membatalkan pesanan ini?')"
                                                        class="btn btn-outline-danger w-100 fw-bold py-2">
                                                        <i class="bi bi-x-circle me-2"></i>Batalkan Pesanan
                                                    </button>
                                                </form>
                                            @endif
                                            
                                            @if($order->status_order === 'Menunggu Pembatalan')
                                                 <button class="btn btn-secondary w-100 fw-bold py-2" disabled>
                                                    <i class="bi bi-hourglass-split me-2"></i>Menunggu Persetujuan
                                                </button>
                                            @endif

                                            @if($order->status_order === 'Ditolak')
                                                <div class="alert alert-danger text-center small py-2 mt-2 mb-0 fw-bold">
                                                    <i class="bi bi-x-circle me-1"></i> Pesanan Anda sudah dibatalkan
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Decorative footer bar --}}
                        <div class="card-footer p-0 border-0 bg-success" style="height: 4px; opacity: 0.1;"></div>
                    </div>
                </div>

                {{-- Modal Bukti --}}
                @if ($order->bukti_transfer)
                    <div class="modal fade" id="buktiModal{{ $order->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content border-0 shadow rounded-4">
                                <div class="modal-header border-0">
                                    <h6 class="modal-title fw-bold">Bukti Pembayaran</h6>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body text-center p-4 pt-0">
                                    <div class="bg-light p-3 rounded-4">
                                        <img src="{{ asset('storage/' . $order->bukti_transfer) }}"
                                            class="img-fluid rounded-3 shadow-sm" alt="Bukti Transfer">
                                    </div>
                                    <p class="text-muted small mt-3 mb-0">Invoice #{{ $order->invoice_number }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

            @empty
                <div class="col-12 py-5">
                    <div class="text-center">
                        <div class="mb-4">
                            <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center animate-bounce"
                                style="width: 120px; height: 120px;">
                                <i class="bi bi-bag-x text-secondary opacity-25" style="font-size: 3rem;"></i>
                            </div>
                        </div>
                        <h4 class="fw-bold text-dark mb-2">Belum Ada Pesanan</h4>
                        <p class="text-muted mb-4 mx-auto" style="max-width: 400px;">
                            Sepertinya Anda belum pernah melakukan pemesanan. Yuk cari menu favoritmu sekarang!
                        </p>
                        <a href="{{ url('/menu') }}"
                            class="btn btn-success btn-lg px-5 rounded-pill shadow-lg hover-scale fw-bold">
                            <i class="bi bi-cart-plus me-2"></i>Mulai Belanja
                        </a>
                    </div>
                </div>
            @endforelse
        </div>
    </div>

    <style>
        .ls-1 {
            letter-spacing: 0.5px;
        }

        .transition-all {
            transition: all 0.3s ease;
        }

        .card-order:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08) !important;
        }

        .hover-scale {
            transition: transform 0.2s;
        }

        .hover-scale:hover {
            transform: scale(1.05);
        }

        .product-item {
            transition: background-color 0.2s;
        }

        .product-item:hover {
            background-color: #f8f9fa !important;
        }

        @media (min-width: 992px) {
            .border-start-lg {
                border-left: 1px dashed rgba(0, 0, 0, 0.1);
            }
        }
    </style>
@endsection