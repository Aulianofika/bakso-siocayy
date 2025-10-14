<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use App\Models\Product;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Tampilkan semua pesanan (dengan filter & pagination)
     */
    public function index(Request $request)
    {
        $query = Order::with(['user', 'orderItems.product', 'shipments'])->latest();

        // filter by status_order
        if ($request->has('status_order') && $request->status_order != '') {
            $query->where('status_order', $request->status_order);
        }

        // filter by status_payment
        if ($request->has('status_payment') && $request->status_payment != '') {
            $query->where('status_payment', $request->status_payment);
        }

        $orders = $query->paginate(10);

        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Form tambah pesanan (opsional kalau admin bisa buat pesanan manual)
     */
    public function create()
    {
        $users = User::all();
        $products = Product::all();

        return view('admin.orders.create', compact('users', 'products'));
    }

    /**
     * Simpan pesanan baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id'        => 'required|exists:users,id',
            'total_price'    => 'required|numeric',
            'status_order'   => 'required|in:Pending,Diproses,Selesai',
            'status_payment' => 'required|in:Belum Bayar,DP,Lunas',
            'amount_paid'    => 'nullable|numeric',
        ]);

        $order = Order::create($request->only([
            'user_id',
            'total_price',
            'status_order',
            'status_payment',
            'amount_paid',
        ]));

        return redirect()->route('admin.orders.show', $order->id)
            ->with('success', 'Pesanan berhasil dibuat.');
    }

    /**
     * Detail pesanan
     */
    public function show(Order $order)
    {
        $order->load(['user', 'orderItems.product', 'shipments']);
        return view('admin.orders.show', compact('order'));
    }

    /**
     * Form edit pesanan
     */
    public function edit(Order $order)
    {
        return view('admin.orders.edit', compact('order'));
    }

    /**
     * Update data pesanan
     */
    public function update(Request $request, Order $order)
    {
        $request->validate([
            'status_order'   => 'required|in:Pending,Diproses,Selesai',
            'status_payment' => 'required|in:Belum Bayar,DP,Lunas',
            'amount_paid'    => 'nullable|numeric',
        ]);

        $order->update($request->only([
            'status_order',
            'status_payment',
            'amount_paid',
        ]));

        return redirect()->route('admin.orders.show', $order->id)
            ->with('success', 'Pesanan berhasil diperbarui.');
    }

    /**
     * Update status pesanan & pembayaran (shortcut)
     */
    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status_order'   => 'required|in:Pending,Diproses,Selesai',
            'status_payment' => 'required|in:Belum Bayar,DP,Lunas',
            'amount_paid'    => 'nullable|numeric',
        ]);

        $order->update([
            'status_order'   => $request->status_order,
            'status_payment' => $request->status_payment,
            'amount_paid'    => $request->amount_paid ?? $order->amount_paid,
        ]);

        return redirect()->route('admin.orders.index')
            ->with('success', 'Status pesanan berhasil diperbarui.');
    }

    /**
     * Hapus pesanan
     */
    public function destroy(Order $order)
    {
        $order->delete();
        return redirect()->route('admin.orders.index')
            ->with('success', 'Pesanan berhasil dihapus.');
    }
}
