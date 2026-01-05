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
            ->whereDate('created_at', today()))
            ->sum('total_price');
        $pendapatanBulanIni = $applyTypeFilter(Order::where('status_payment', 'Lunas')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year))
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
        // GRAFIK PENJUALAN 7 HARI
        // =========================
        $penjualanMingguan = $applyTypeFilter(Order::select(
            DB::raw('DATE(created_at) as tanggal'),
            DB::raw('COUNT(*) as jumlah'),
            DB::raw('SUM(total_price) as total')
        ))
            ->where('status_payment', 'Lunas')
            ->whereDate('created_at', '>=', now()->subDays(6))
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

        return view('admin.dashboard', compact(
            'totalProduk',
            'totalPesanan',
            'pesananHariIni',
            'pesananPending',
            'pesananBaru',
            'totalPendapatan',
            'pendapatanHariIni',
            'pendapatanBulanIni',
            'pelangganAktif',
            'totalPelanggan',
            'pesananByStatus',
            'penjualanMingguan',
            'pesananTerbaru',
            'topProducts',
            'type' // Pass 'type' to view for tabs
        ));
    }
}
