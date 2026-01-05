@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h3 class="fw-bold mb-4" style="color:#4a3aff;">
        <i class="bi bi-info-circle me-2"></i> Detail Pengiriman
    </h3>

    <div class="row g-3">
        <div class="col-md-8">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-header bg-white border-bottom">
                    <h5 class="fw-bold mb-0">Informasi Pengiriman</h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <th width="200">Invoice Pesanan</th>
                            <td><strong>#{{ $shipment->order->invoice_number }}</strong></td>
                        </tr>
                        <tr>
                            <th>Pemesan</th>
                            <td>{{ $shipment->order->user->name ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Alamat Tujuan (Kemana)</th>
                            <td>
                                <strong>{{ $shipment->destination }}</strong>
                                @if($shipment->order->nama_penerima)
                                    <br><small class="text-muted">Penerima: {{ $shipment->order->nama_penerima }}</small>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Tanggal Pengiriman (Kapan)</th>
                            <td>
                                <strong>{{ $shipment->shipment_date ? \Carbon\Carbon::parse($shipment->shipment_date)->translatedFormat('d F Y') : '-' }}</strong>
                                @if($shipment->dikirim_at)
                                    <br><small class="text-muted">
                                        Dikirim pada: {{ \Carbon\Carbon::parse($shipment->dikirim_at)->format('d M Y, H:i') }}
                                    </small>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Kurir / Ekspedisi</th>
                            <td><span class="badge bg-info text-dark">{{ $shipment->courier }}</span></td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>
                                @php
                                    $colors = [
                                        'Menunggu' => 'secondary',
                                        'Dikirim'  => 'primary',
                                        'Diterima' => 'success',
                                    ];
                                @endphp
                                <span class="badge bg-{{ $colors[$shipment->status] }}">
                                    {{ $shipment->status }}
                                </span>
                            </td>
                        </tr>
                        @if($shipment->diterima_at)
                        <tr>
                            <th>Diterima Pada</th>
                            <td>{{ \Carbon\Carbon::parse($shipment->diterima_at)->format('d M Y, H:i') }}</td>
                        </tr>
                        @endif
                    </table>
                </div>
            </div>

            <!-- Barang yang Dikirim -->
            <div class="card shadow-sm border-0 rounded-4 mt-3">
                <div class="card-header bg-white border-bottom">
                    <h5 class="fw-bold mb-0">Barang yang Dikirim (Apa)</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Produk</th>
                                    <th class="text-center">Jumlah</th>
                                    <th class="text-end">Harga</th>
                                    <th class="text-end">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($shipment->order->orderItems as $item)
                                    <tr>
                                        <td>{{ $item->product->name ?? 'Produk Dihapus' }}</td>
                                        <td class="text-center">{{ $item->quantity }}</td>
                                        <td class="text-end">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                                        <td class="text-end fw-semibold">
                                            Rp {{ number_format($item->quantity * $item->price, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr class="table-success">
                                    <th colspan="3" class="text-end">Total:</th>
                                    <th class="text-end">Rp {{ number_format($shipment->order->total_price, 0, ',', '.') }}</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-header bg-white border-bottom">
                    <h5 class="fw-bold mb-0">Aksi</h5>
                </div>
                <div class="card-body">
                    @if($shipment->status === 'Menunggu')
                        <form action="{{ route('admin.shipments.send', $shipment->id) }}" method="POST" class="mb-2">
                            @csrf
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="bi bi-send me-1"></i> Tandai Dikirim
                            </button>
                        </form>
                        <a href="{{ route('admin.shipments.edit', $shipment->id) }}" class="btn btn-outline-primary w-100 mb-2">
                            <i class="bi bi-pencil me-1"></i> Edit Pengiriman
                        </a>
                    @elseif($shipment->status === 'Dikirim')
                        <form action="{{ route('admin.shipments.received', $shipment->id) }}" method="POST" class="mb-2">
                            @csrf
                            <button type="submit" class="btn btn-success w-100">
                                <i class="bi bi-check-circle me-1"></i> Tandai Diterima
                            </button>
                        </form>
                    @else
                        <div class="alert alert-success mb-0">
                            <i class="bi bi-check-circle me-1"></i> Pengiriman sudah selesai
                        </div>
                    @endif
                    <a href="{{ route('admin.shipments.index') }}" class="btn btn-secondary w-100 mt-2">
                        <i class="bi bi-arrow-left me-1"></i> Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
