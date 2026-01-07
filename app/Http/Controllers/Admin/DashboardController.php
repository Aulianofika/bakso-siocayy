<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Order;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $type = $request->query('type', 'all'); // 'all', 'bakso', 'kopi'

        // Helper untuk filter query
        $applyTypeFilter = function ($query) use ($type) {
            if ($type !== 'all') {
                $query->whereHas('orderItems.product.category', function ($q) use ($type) {
                    $q->where('name', 'like', '%' . $type . '%');
                });
            }
            return $query;
        };

        // Helper khusus untuk Product filter
        $applyProductFilter = function ($query) use ($type) {
            if ($type !== 'all') {
                $query->whereHas('category', function ($q) use ($type) {
                    $q->where('name', 'like', '%' . $type . '%');
                });
            }
            return $query;
        };

        // =========================
        // RINGKASAN CARD
        // =========================
        $totalProduk = $applyProductFilter(Product::query())->count();

        $totalPesanan = $applyTypeFilter(Order::query())->count();
        $pesananHariIni = $applyTypeFilter(Order::whereDate('created_at', today()))->count();
        $pesananPending = $applyTypeFilter(Order::where('status_order', 'Pending'))->count();
        $pesananBaru = $applyTypeFilter(Order::where('status_order', 'Pending')
            ->whereDate('created_at', '>=', today()->subDays(7)))
            ->count();

        $totalPendapatan = $applyTypeFilter(Order::where('status_payment', 'Lunas'))
            ->sum('total_price');
        $pendapatanHariIni = $applyTypeFilter(Order::where('status_payment', 'Lunas')
            ->whereDate('payment_verified_at', today()))
            ->sum('total_price');
        $pendapatanBulanIni = $applyTypeFilter(Order::where('status_payment', 'Lunas')
            ->whereMonth('payment_verified_at', now()->month)
            ->whereYear('payment_verified_at', now()->year))
            ->sum('total_price');
        $pendapatanTahunIni = $applyTypeFilter(Order::where('status_payment', 'Lunas')
            ->whereYear('payment_verified_at', now()->year))
            ->sum('total_price');

        // Untuk user, kita tidak filter berdasarkan pembelian karena user itu global
        // Tapi jika diminta "total pelanggan bakso", itu agak bias. Kita biarkan global dulu utk user.
        $pelangganAktif = User::where('role', 'user')
            ->whereMonth('created_at', now()->month)
            ->count();
        $totalPelanggan = User::where('role', 'user')->count();

        // =========================
        // STATUS PESANAN BREAKDOWN
        // =========================
        $pesananByStatus = $applyTypeFilter(Order::select('status_order', DB::raw('count(*) as total')))
            ->groupBy('status_order')
            ->get()
            ->pluck('total', 'status_order');

        // =========================
        // GRAFIK PENJUALAN (Dynamic)
        // =========================
        // Default: Monthly Trend (Daily data for current month)
        // Yearly Trend (Monthly data for current year)
        // Yearly Trend (Monthly data for current year)
        // Yearly Trend (Monthly data for current year)
        $chartMonth = $applyTypeFilter(Order::select(
            DB::raw('DATE(payment_verified_at) as tanggal'),
            DB::raw('SUM(total_price) as total')
        ))
            ->where('status_payment', 'Lunas')
            ->whereMonth('payment_verified_at', now()->month)
            ->whereYear('payment_verified_at', now()->year)
            ->groupBy('tanggal')
            ->orderBy('tanggal')
            ->get();

        $chartYear = $applyTypeFilter(Order::select(
            DB::raw('MONTH(payment_verified_at) as bulan'),
            DB::raw('SUM(total_price) as total')
        ))
            ->where('status_payment', 'Lunas')
            ->whereYear('payment_verified_at', now()->year)
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();

        // =========================
        // GRAFIK PENJUALAN 7 HARI
        // =========================
        // =========================
        // GRAFIK PENJUALAN 7 HARI
        // =========================
        $penjualanMingguan = $applyTypeFilter(Order::select(
            DB::raw('DATE(payment_verified_at) as tanggal'),
            DB::raw('COUNT(*) as jumlah'),
            DB::raw('SUM(total_price) as total')
        ))
            ->where('status_payment', 'Lunas')
            ->whereDate('payment_verified_at', '>=', now()->subDays(6))
            ->groupBy('tanggal')
            ->orderBy('tanggal')
            ->get();

        // =========================
        // PESANAN TERBARU (UNTUK NOTIFIKASI)
        // =========================
        $pesananTerbaru = $applyTypeFilter(Order::with(['user', 'orderItems.product']))
            ->latest()
            ->limit(10)
            ->get();

        // =========================
        // TOP PRODUCTS
        // =========================
        $queryTop = \App\Models\OrderItem::select('product_id', DB::raw('SUM(quantity) as total_terjual'))
            ->with('product')
            ->groupBy('product_id')
            ->orderBy('total_terjual', 'desc')
            ->limit(5);

        if ($type !== 'all') {
            $queryTop->whereHas('product.category', function ($q) use ($type) {
                $q->where('name', 'like', '%' . $type . '%');
            });
        }
        $topProducts = $queryTop->get();

        // =========================
        // STOCK ALERTS (New)
        // =========================
        // Cari produk dengan stok <= 5
        $lowStockProducts = Product::where('stock', '<=', 5)->orderBy('stock', 'asc')->get();

        return view('admin.dashboard', compact(
            'totalProduk',
            'totalPesanan',
            'pesananHariIni',
            'pesananPending',
            'pesananBaru',
            'totalPendapatan',
            'pendapatanHariIni',
            'pendapatanBulanIni',
            'pendapatanTahunIni',
            'pelangganAktif',
            'totalPelanggan',
            'pesananByStatus',
            'penjualanMingguan',
            'pesananTerbaru',
            'topProducts',
            'type',
            'lowStockProducts',
            'chartMonth',
            'chartYear'
        ));
    }

    public function exportPdf(Request $request)
    {
        $type = $request->query('type', 'daily'); // daily, monthly, yearly
        $date = $request->query('date', now()->format('Y-m-d'));
        $month = $request->query('month', now()->format('Y-m'));
        $year = $request->query('year', now()->format('Y'));

        $query = Order::where('status_payment', 'Lunas');
        $title = 'Laporan Pendapatan';
        $period = '';

        if ($type == 'daily') {
            $query->whereDate('payment_verified_at', $date);
            $title = 'Laporan Harian';
            $period = Carbon::parse($date)->translatedFormat('d F Y');
        } elseif ($type == 'monthly') {
            $d = Carbon::createFromFormat('Y-m', $month);
            $query->whereYear('payment_verified_at', $d->year)->whereMonth('payment_verified_at', $d->month);
            $title = 'Laporan Bulanan';
            $period = $d->translatedFormat('F Y');
        } elseif ($type == 'yearly') {
            $query->whereYear('payment_verified_at', $year);
            $title = 'Laporan Tahunan';
            $period = 'Tahun ' . $year;
        }

        $orders = $query->latest()->get();
        $totalRevenue = $orders->sum('total_price');

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.reports.pdf', compact('orders', 'totalRevenue', 'title', 'period', 'type'));

        if ($request->input('action') === 'preview') {
            return $pdf->stream('laporan-pendapatan-' . $type . '-' . time() . '.pdf');
        }

        return $pdf->download('laporan-pendapatan-' . $type . '-' . time() . '.pdf');
    }
}
