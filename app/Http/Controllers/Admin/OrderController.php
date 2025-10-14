<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Customer;
use App\Models\Product;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * 🧾 Tampilkan semua pesanan dengan filter dan pagination
     */
    public function index(Request $request)
    {
        $query = Order::with(['customer', 'orderItems.product', 'shipments'])->latest();

        if ($request->filled('status_order')) {
            $query->where('status_order', $request->status_order);
        }

        if ($request->filled('status_payment')) {
            $query->where('status_payment', $request->status_payment);
        }

        $orders = $query->paginate(10);

        return view('admin.orders.index', compact('orders'));
    }

    /**
     * 🛍️ Form tambah pesanan
     */
    public function create()
    {
        $customers = Customer::select('id', 'nama_lengkap', 'email')->get();
        $products = Product::select('id', 'name', 'price_sale')->get();

        return view('admin.orders.create', compact('customers', 'products'));
    }

    /**
     * 💾 Simpan pesanan baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'customer_id'    => 'required|exists:customers,id',
            'products'       => 'required|array|min:1',
            'products.*.id'  => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
            'status_order'   => 'required|in:Pending,Diproses,Selesai',
            'status_payment' => 'required|in:Belum Bayar,DP,Lunas',
            'amount_paid'    => 'nullable|numeric',
        ]);

        // Hitung total harga berdasarkan produk yang dipilih
        $total = 0;
        foreach ($request->products as $item) {
            $product = Product::findOrFail($item['id']);
            $total += $product->price_sale * $item['quantity'];
        }

        // Simpan order utama
        $order = Order::create([
            'customer_id'    => $request->customer_id,
            'total_price'    => $total,
            'status_order'   => $request->status_order,
            'status_payment' => $request->status_payment,
            'amount_paid'    => $request->amount_paid ?? 0,
        ]);

        // Simpan item-item order
        foreach ($request->products as $item) {
            $product = Product::findOrFail($item['id']);
            $order->orderItems()->create([
                'product_id' => $product->id,
                'quantity'   => $item['quantity'],
                'price'      => $product->price_sale,
            ]);
        }

        return redirect()->route('admin.orders.show', $order->id)
            ->with('success', 'Pesanan berhasil dibuat.');
    }

    /**
     * 🔍 Detail pesanan
     */
    public function show(Order $order)
    {
        $order->load(['customer', 'orderItems.product', 'shipments']);
        return view('admin.orders.show', compact('order'));
    }

    /**
     * ✏️ Form edit pesanan
     */
    public function edit(Order $order)
    {
        $customers = Customer::select('id', 'nama_lengkap', 'email')->get();
        return view('admin.orders.edit', compact('order', 'customers'));
    }

    /**
     * 🔄 Update data pesanan
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
     * ⚙️ Update status pesanan langsung (shortcut)
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
     * 🗑️ Hapus pesanan
     */
    public function destroy(Order $order)
    {
        $order->delete();
        return redirect()->route('admin.orders.index')
            ->with('success', 'Pesanan berhasil dihapus.');
    }
}
