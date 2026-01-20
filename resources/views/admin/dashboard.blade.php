@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
    <div class="container-fluid px-0">
        <!-- Header Section -->
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-5 gap-3">
            <div>
                @php
                    $title = match (request('type')) {
                        'bakso' => 'Dashboard Bakso',
                        'kopi' => 'Dashboard Kopi',
                        default => 'Overview'
                    };
                @endphp
                <h2 class="fw-bolder text-dark mb-1 display-6" style="font-family: 'Outfit', sans-serif;">{{ $title }}</h2>
                <p class="text-muted mb-0">Selamat datang kembali, <span
                        class="fw-semibold text-dark">{{ Auth::user()->name ?? 'Admin' }}</span>! 👋</p>
            </div>

            <div class="d-flex gap-3 align-items-center">
                <div class="text-end d-none d-md-block">
                    <small class="text-muted d-block text-uppercase"
                        style="font-size: 0.7rem; letter-spacing: 1px;">Tanggal</small>
                    <span class="fw-bold text-dark">{{ now()->translatedFormat('d F Y') }}</span>
                </div>
                <div class="bg-white p-2 rounded-circle shadow-sm border">
                    <i class="bi bi-calendar-event text-success fs-5"></i>
                </div>
            </div>
        </div>

        <!-- Stock Alert (Preserved Logic) -->
        @if(isset($lowStockProducts) && $lowStockProducts->count() > 0)
            <div class="alert alert-dismissible fade show border-0 shadow-sm rounded-4 mb-5 p-4 position-relative overflow-hidden"
                style="background: linear-gradient(120deg, #fef2f2 0%, #fff 100%); border-left: 4px solid #ef4444 !important;"
                role="alert">

                <div class="d-flex align-items-start gap-4 position-relative z-1">
                    <div class="flex-shrink-0">
                        <div class="d-flex align-items-center justify-content-center bg-danger bg-opacity-10 text-danger rounded-circle"
                            style="width: 48px; height: 48px;">
                            <i class="bi bi-exclamation-triangle-fill fs-5"></i>
                        </div>
                    </div>

                    <div class="flex-grow-1">
                        <h5 class="fw-bold text-dark mb-1">Perhatian! Stok Menipis</h5>
                        <p class="text-muted small mb-3">Terdapat <strong class="text-danger">{{ $lowStockProducts->count() }}
                                produk</strong> yang perlu segera di-restock.</p>

                        <div class="d-flex flex-wrap gap-2">
                            @foreach($lowStockProducts->take(6) as $product)
                                <div
                                    class="d-flex align-items-center gap-2 bg-white ps-2 pe-3 py-1 rounded-pill shadow-sm border border-danger border-opacity-10">
                                    <div class="rounded-circle overflow-hidden bg-light position-relative flex-shrink-0"
                                        style="width: 28px; height: 28px;">
                                        <img src="{{ asset('images/products/' . $product->image) }}"
                                            class="w-100 h-100 object-fit-cover" alt="{{ $product->name }}">
                                    </div>
                                    <span class="fw-bold text-dark small text-truncate"
                                        style="max-width: 100px;">{{ $product->name }}</span>
                                    <span
                                        class="badge {{ $product->stock <= 0 ? 'bg-danger' : 'bg-warning text-dark' }} rounded-pill"
                                        style="font-size: 0.6rem;">
                                        {{ $product->stock <= 0 ? 'Habis' : 'Sisa ' . $product->stock }}
                                    </span>
                                    <a href="{{ route('admin.products.edit', $product->id) }}"
                                        class="text-muted hover-text-primary ms-1"><i class="bi bi-pencil-fill"
                                            style="font-size: 0.7rem;"></i></a>
                                </div>
                            @endforeach
                            @if($lowStockProducts->count() > 6)
                                <a href="{{ route('admin.products.index') }}"
                                    class="btn btn-sm btn-link text-danger text-decoration-none fw-bold small">+{{ $lowStockProducts->count() - 6 }}
                                    Lainnya</a>
                            @endif
                        </div>
                    </div>
                    <button type="button" class="btn-close opacity-50" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        @endif

        <!-- Stats Overview Row -->
        <div class="row g-4 mb-5">
            <!-- Total Pesanan -->
            <div class="col-xl-3 col-md-6">
                <div
                    class="card border-0 shadow-sm rounded-4 h-100 position-relative overflow-hidden group hover-translate-up bg-white">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div class="bg-success bg-opacity-10 text-success p-3 rounded-4">
                                <i class="bi bi-receipt fs-4"></i>
                            </div>
                            <span class="badge bg-light text-muted border rounded-pill">{{ $pesananPending ?? 0 }}
                                Pending</span>
                        </div>
                        <h3 class="fw-bolder text-dark mb-1">{{ number_format($totalPesanan ?? 0) }}</h3>
                        <p class="text-muted small mb-0">Total Pesanan</p>
                    </div>
                </div>
            </div>

            <!-- Pesanan Hari Ini -->
            <div class="col-xl-3 col-md-6">
                <div
                    class="card border-0 shadow-sm rounded-4 h-100 position-relative overflow-hidden group hover-translate-up bg-white">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div class="bg-primary bg-opacity-10 text-primary p-3 rounded-4">
                                <i class="bi bi-calendar-check fs-4"></i>
                            </div>
                            <span
                                class="badge bg-primary-subtle text-primary border border-primary-subtle rounded-pill">+{{ $pesananBaru ?? 0 }}
                                Baru</span>
                        </div>
                        <h3 class="fw-bolder text-dark mb-1">{{ number_format($pesananHariIni ?? 0) }}</h3>
                        <p class="text-muted small mb-0">Pesanan Hari Ini</p>
                    </div>
                </div>
            </div>

            <!-- Revenue -->
            <div class="col-xl-3 col-md-6">
                <div
                    class="card border-0 shadow-sm rounded-4 h-100 position-relative overflow-hidden group hover-translate-up bg-white">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div class="bg-warning bg-opacity-10 text-warning p-3 rounded-4">
                                <i class="bi bi-wallet2 fs-4"></i>
                            </div>
                            <!-- Export Button (Trigger Modal) -->
                            <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill"
                                data-bs-toggle="modal" data-bs-target="#exportModal">
                                <i class="bi bi-printer me-1"></i> Cetak
                            </button>
                        </div>
                        <h3 class="fw-bolder text-dark mb-1">Rp {{ number_format($totalPendapatan ?? 0, 0, ',', '.') }}</h3>
                        <p class="text-muted small mb-0">Total Pendapatan</p>
                    </div>
                </div>
            </div>

            <!-- Products & Users -->
            <div class="col-xl-3 col-md-6">
                <div
                    class="card border-0 shadow-sm rounded-4 h-100 position-relative overflow-hidden group hover-translate-up bg-white">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div class="bg-info bg-opacity-10 text-info p-3 rounded-4">
                                <i class="bi bi-box-seam fs-4"></i>
                            </div>
                            <div class="text-end">
                                <small class="text-muted d-block" style="font-size: 0.65rem;">Pelanggan</small>
                                <span class="fw-bold text-dark">{{ number_format($totalPelanggan ?? 0) }}</span>
                            </div>
                        </div>
                        <h3 class="fw-bolder text-dark mb-1">{{ number_format($totalProduk ?? 0) }}</h3>
                        <p class="text-muted small mb-0">Total Menu Aktif</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Revenue Chart Section --}}
        <div class="row mb-5">
            <div class="col-12">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-header bg-white border-0 py-4 px-4 d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="fw-bold text-dark mb-0">Perkembangan Pendapatan</h6>
                            <small class="text-muted">Grafik penjualan berdasarkan periode</small>
                        </div>
                        <div class="d-flex bg-light rounded-pill p-1">
                            <button class="btn btn-sm btn-light rounded-pill px-3 fw-bold shadow-sm" id="btn-chart-month"
                                onclick="switchChart('month')">Bulan Ini</button>
                            <button class="btn btn-sm btn-light rounded-pill px-3 text-muted" id="btn-chart-year"
                                onclick="switchChart('year')">Tahun Ini</button>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <canvas id="revenueGrowthChart" height="80"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content Grid -->
        <div class="row g-4">
            <!-- Left Column: Order Stats & Recent Orders -->
            <div class="col-lg-8">
                <!-- Order Status Overview -->
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-body p-4">
                        <h6 class="fw-bold text-dark mb-4">Status Pesanan</h6>
                        <div class="row g-3 text-center">
                            @foreach(['Pending' => ['warning', 'hourglass-split'], 'Diproses' => ['primary', 'gear-wide-connected'], 'Siap Dikirim' => ['info', 'box'], 'Selesai' => ['success', 'check-lg']] as $status => $style)
                                <div class="col-3">
                                    <div
                                        class="p-3 rounded-4 bg-light h-100 transition-hover border border-transparent hover-border-{{ $style[0] }}">
                                        <div class="text-{{ $style[0] }} mb-2"><i class="bi bi-{{ $style[1] }} fs-4"></i></div>
                                        <h4 class="fw-bold text-dark mb-0">{{ $pesananByStatus[$status] ?? 0 }}</h4>
                                        <small class="text-muted" style="font-size: 0.75rem;">{{ $status }}</small>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Recent Orders -->
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-header bg-white border-0 py-4 px-4 d-flex justify-content-between align-items-center">
                        <h6 class="fw-bold text-dark mb-0">Pesanan Terbaru</h6>
                        <a href="{{ route('admin.orders.index') }}"
                            class="btn btn-sm btn-light rounded-pill px-3 fw-medium text-muted hover-bg-light">Lihat
                            Semua</a>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="ps-4 py-3 text-muted small text-uppercase fw-bold border-bottom-0">
                                            Invoice</th>
                                        <th class="py-3 text-muted small text-uppercase fw-bold border-bottom-0">Pelanggan
                                        </th>
                                        <th class="py-3 text-muted small text-uppercase fw-bold border-bottom-0">Total</th>
                                        <th class="py-3 text-muted small text-uppercase fw-bold border-bottom-0">Status</th>
                                        <th
                                            class="pe-4 py-3 text-end text-muted small text-uppercase fw-bold border-bottom-0">
                                            Waktu</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($pesananTerbaru as $order)
                                        <tr>
                                            <td class="ps-4 fw-medium text-dark">#{{ $order->invoice_number }}</td>
                                            <td>
                                                <div class="d-flex align-items-center gap-2">
                                                    <div class="avatar-xs bg-primary-subtle text-primary rounded-circle d-flex align-items-center justify-content-center fw-bold"
                                                        style="width: 24px; height: 24px; font-size: 0.7rem;">
                                                        {{ substr($order->user->name ?? 'U', 0, 1) }}
                                                    </div>
                                                    <span class="text-dark">{{ $order->user->name ?? 'Guest' }}</span>
                                                </div>
                                            </td>
                                            <td class="fw-bold text-success">Rp
                                                {{ number_format($order->total_price, 0, ',', '.') }}
                                            </td>
                                            <td>
                                                @php
                                                    $statusColor = match ($order->status_order) {
                                                        'Pending' => 'warning',
                                                        'Diproses' => 'primary',
                                                        'Siap Dikirim' => 'info',
                                                        'Selesai' => 'success',
                                                        'Ditolak' => 'danger',
                                                        default => 'secondary'
                                                    };
                                                @endphp
                                                <span
                                                    class="badge bg-{{ $statusColor }}-subtle text-{{ $statusColor }} border border-{{ $statusColor }}-subtle rounded-pill px-2 py-1 fw-normal">
                                                    {{ $order->status_order }}
                                                </span>
                                            </td>
                                            <td class="pe-4 text-end text-muted small">{{ $order->created_at->diffForHumans() }}
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center py-5 text-muted">Belum ada pesanan terbaru.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Revenue Card & Top Products -->
            <div class="col-lg-4">
                <!-- Revenue Breakdown Card -->
                <div class="card border-0 shadow-sm rounded-4 bg-success text-white mb-4 position-relative overflow-hidden"
                    id="revenue-card">
                    <div class="position-absolute top-0 end-0 p-3 opacity-10">
                        <i class="bi bi-wallet2 display-1"></i>
                    </div>

                    <div class="card-body p-4 position-relative z-1">
                        <!-- Tab Switcher -->
                        <div class="d-flex justify-content-center mb-4">
                            <div class="bg-white bg-opacity-25 rounded-pill p-1 d-inline-flex">
                                <button onclick="setRevenue('day')"
                                    class="btn btn-sm rounded-pill text-white fw-medium px-3 py-1 revenue-tab" id="tab-day"
                                    style="border:none;">Hari</button>
                                <button onclick="setRevenue('month')"
                                    class="btn btn-sm rounded-pill bg-white text-success fw-bold px-3 py-1 revenue-tab shadow-sm"
                                    id="tab-month" style="border:none;">Bulan</button>
                                <button onclick="setRevenue('year')"
                                    class="btn btn-sm rounded-pill text-white fw-medium px-3 py-1 revenue-tab" id="tab-year"
                                    style="border:none;">Tahun</button>
                            </div>
                        </div>

                        <!-- Content -->
                        <div class="text-center">
                            <p class="text-white text-opacity-75 mb-1 text-uppercase small letter-spacing-1"
                                id="revenue-label">
                                Pendapatan {{ now()->translatedFormat('F Y') }}
                            </p>
                            <h2 class="display-5 fw-bolder mb-3 transition-all" id="revenue-amount">
                                Rp {{ number_format($pendapatanBulanIni ?? 0, 0, ',', '.') }}
                            </h2>
                            <div class="d-inline-block bg-white bg-opacity-20 rounded-pill px-3 py-1">
                                <small class="text-black"><i class="bi bi-arrow-up-circle me-1"></i>Realtime Update</small>
                            </div>
                        </div>
                    </div>
                </div>

                <script>
                    const revenueData = {
                        day: {
                            amount: "Rp {{ number_format($pendapatanHariIni ?? 0, 0, ',', '.') }}",
                            label: "Pendapatan {{ now()->translatedFormat('d F Y') }}"
                        },
                        month: {
                            amount: "Rp {{ number_format($pendapatanBulanIni ?? 0, 0, ',', '.') }}",
                            label: "Pendapatan {{ now()->translatedFormat('F Y') }}"
                        },
                        year: {
                            amount: "Rp {{ number_format($pendapatanTahunIni ?? 0, 0, ',', '.') }}",
                            label: "Pendapatan Tahun {{ now()->year }}"
                        }
                    };

                    function setRevenue(type) {
                        // Update Data
                        document.getElementById('revenue-amount').innerText = revenueData[type].amount;
                        document.getElementById('revenue-label').innerText = revenueData[type].label;

                        // Update Tabs Style
                        document.querySelectorAll('.revenue-tab').forEach(btn => {
                            btn.classList.remove('bg-white', 'text-success', 'fw-bold', 'shadow-sm');
                            btn.classList.add('text-white', 'fw-medium');
                        });

                        const activeBtn = document.getElementById('tab-' + type);
                        activeBtn.classList.remove('text-white', 'fw-medium');
                        activeBtn.classList.add('bg-white', 'text-success', 'fw-bold', 'shadow-sm');
                    }
                </script>

                <!-- Top Products -->
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-header bg-white border-0 py-4 px-4">
                        <h6 class="fw-bold text-dark mb-0">Menu Terlaris</h6>
                    </div>
                    <div class="card-body p-0">
                        <div class="list-group list-group-flush">
                            @forelse($topProducts as $index => $item)
                                <div
                                    class="list-group-item border-0 px-4 py-3 d-flex align-items-center gap-3 hover-bg-light transition-hover">
                                    <div class="fw-bold text-muted opacity-25 fs-4" style="width: 20px;">0{{ $index + 1 }}</div>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-0 fw-bold text-dark">{{ $item->product->name ?? 'Unknown' }}</h6>
                                        <small class="text-muted">{{ $item->total_terjual }} terjual</small>
                                    </div>
                                    <i class="bi bi-trophy-fill text-warning opacity-50"></i>
                                </div>
                            @empty
                                <div class="text-center py-5 text-muted">Belum ada data.</div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Export Modal -->
    <div class="modal fade" id="exportModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-4">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold">Cetak Laporan Pendapatan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <form action="{{ route('admin.dashboard.export') }}" method="GET" id="exportForm">
                        <div class="mb-3">
                            <label class="form-label fw-bold small text-muted text-uppercase">Tipe Laporan</label>
                            <select name="type" class="form-select" id="exportType" onchange="toggleExportInputs()">
                                <option value="daily">Harian</option>
                                <option value="monthly">Bulanan</option>
                                <option value="yearly">Tahunan</option>
                            </select>
                        </div>

                        <div id="exportDaily" class="mb-4">
                            <label class="form-label fw-bold small text-muted text-uppercase">Pilih Tanggal</label>
                            <input type="date" name="date" class="form-control" value="{{ now()->format('Y-m-d') }}">
                        </div>

                        <div id="exportMonthly" class="mb-4 d-none">
                            <label class="form-label fw-bold small text-muted text-uppercase">Pilih Bulan</label>
                            <input type="month" name="month" class="form-control" value="{{ now()->format('Y-m') }}">
                        </div>

                        <div id="exportYearly" class="mb-4 d-none">
                            <label class="form-label fw-bold small text-muted text-uppercase">Pilih Tahun</label>
                            <select name="year" class="form-select">
                                @for($y = date('Y'); $y >= 2024; $y--)
                                    <option value="{{ $y }}">{{ $y }}</option>
                                @endfor
                            </select>
                        </div>

                        <button type="button" onclick="submitExport('preview')"
                            class="btn btn-outline-primary rounded-pill fw-bold py-2 w-100">
                            <i class="bi bi-eye me-2"></i>Tampilkan
                        </button>
                        <button type="button" onclick="submitExport('download_pdf')"
                            class="btn btn-danger rounded-pill fw-bold py-2 w-100">
                            <i class="bi bi-file-earmark-pdf me-2"></i>PDF
                        </button>
                        <button type="button" onclick="submitExport('download_excel')"
                            class="btn btn-success rounded-pill fw-bold py-2 w-100">
                            <i class="bi bi-file-earmark-excel me-2"></i>Excel
                        </button>
                </div>
                <input type="hidden" name="action" id="exportAction" value="preview">

                <script>
                    function submitExport(action) {
                        document.getElementById('exportAction').value = action;
                        document.getElementById('exportForm').submit();
                    }
                </script>
                </form>
            </div>
        </div>
    </div>
    </div>

    @push('scripts')
        {{-- Chart JS --}}
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            // Modal Logic
            function toggleExportInputs() {
                const type = document.getElementById('exportType').value;
                document.getElementById('exportDaily').classList.add('d-none');
                document.getElementById('exportMonthly').classList.add('d-none');
                document.getElementById('exportYearly').classList.add('d-none');

                document.getElementById('export' + type.charAt(0).toUpperCase() + type.slice(1)).classList.remove('d-none');
            }

            // Chart Logic
            const ctx = document.getElementById('revenueGrowthChart');
            let myChart;

            const monthData = {
                labels: {!! json_encode($chartMonth->pluck('tanggal')->map(fn($d) => \Carbon\Carbon::parse($d)->format('d'))) !!},
                data: {!! json_encode($chartMonth->pluck('total')) !!}
            };

            const yearData = {
                labels: {!! json_encode($chartYear->pluck('bulan')->map(fn($m) => \Carbon\Carbon::createFromFormat('m', $m)->translatedFormat('M'))) !!},
                data: {!! json_encode($chartYear->pluck('total')) !!}
            };

            function switchChart(type) {
                const btnMonth = document.getElementById('btn-chart-month');
                const btnYear = document.getElementById('btn-chart-year');

                if (type === 'month') {
                    // Active Month
                    btnMonth.classList.remove('text-muted');
                    btnMonth.classList.add('btn-light', 'fw-bold', 'shadow-sm');
                    // Inactive Year
                    btnYear.classList.add('text-muted');
                    btnYear.classList.remove('btn-light', 'fw-bold', 'shadow-sm');

                    updateChart(monthData.labels, monthData.data, 'Pendapatan Bulan Ini (Per Hari)');
                } else {
                    // Active Year
                    btnYear.classList.remove('text-muted');
                    btnYear.classList.add('btn-light', 'fw-bold', 'shadow-sm');
                    // Inactive Month
                    btnMonth.classList.add('text-muted');
                    btnMonth.classList.remove('btn-light', 'fw-bold', 'shadow-sm');

                    updateChart(yearData.labels, yearData.data, 'Pendapatan Tahun Ini (Per Bulan)');
                }
            }

            function updateChart(labels, data, label) {
                myChart.data.labels = labels;
                myChart.data.datasets[0].data = data;
                myChart.data.datasets[0].label = label;
                myChart.update();
            }

            // Init Chart
            myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: monthData.labels,
                    datasets: [{
                        label: 'Pendapatan Bulan Ini (Per Hari)',
                        data: monthData.data,
                        backgroundColor: 'rgba(25, 135, 84, 0.6)',
                        borderColor: 'rgba(25, 135, 84, 1)',
                        borderWidth: 1,
                        borderRadius: 4,
                        barThickness: 20
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function (value) {
                                    return 'Rp ' + value.toLocaleString('id-ID');
                                }
                            }
                        }
                    },
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function (context) {
                                    let label = context.dataset.label || '';
                                    if (label) {
                                        label += ': ';
                                    }
                                    if (context.parsed.y !== null) {
                                        label += new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(context.parsed.y);
                                    }
                                    return label;
                                }
                            }
                        }
                    }
                }
            });
        </script>
    @endpush

    <style>
        .hover-translate-up:hover {
            transform: translateY(-5px);
            transition: transform 0.3s ease;
        }

        .transition-hover {
            transition: all 0.2s ease;
        }

        .hover-border-warning:hover {
            border-color: var(--bs-warning) !important;
            background-color: var(--bs-warning-bg-subtle) !important;
        }

        .hover-border-primary:hover {
            border-color: var(--bs-primary) !important;
            background-color: var(--bs-primary-bg-subtle) !important;
        }

        .hover-border-info:hover {
            border-color: var(--bs-info) !important;
            background-color: var(--bs-info-bg-subtle) !important;
        }

        .hover-border-success:hover {
            border-color: var(--bs-success) !important;
            background-color: var(--bs-success-bg-subtle) !important;
        }
    </style>
@endsection