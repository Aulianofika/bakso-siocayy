<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class OrderController extends Controller
{
    /**
     * Menampilkan semua pesanan
     */
    public function index(Request $request)
    {
        $query = Order::with(['user', 'orderItems.product.category'])
            ->latest();

        if ($request->filled('status_order')) {
            $query->where('status_order', $request->status_order);
        }

        if ($request->filled('payment_method')) {
            $query->where('payment_method', $request->payment_method);
        }

        if ($request->filled('category_id')) {
            $query->whereHas('orderItems.product', function ($q) use ($request) {
                $q->where('category_id', $request->category_id);
            });
        }

        // Filter Tipe (Bakso / Kopi)
        $type = $request->query('type', 'all');
        if ($type !== 'all') {
            $query->whereHas('orderItems.product.category', function ($q) use ($type) {
                // Asumsi nama kategori mengandung kata 'bakso' atau 'kopi' (case insensitive biasanya di DB)
                $q->where('name', 'like', '%' . $type . '%');
            });
        }

        $orders = $query->paginate(12)->appends(['type' => $type]);
        $categories = \App\Models\Category::all();

        return view('admin.orders.index', compact('orders', 'categories'));
    }

    /**
     * 📄 Detail pesanan
     */
    public function show(Order $order)
    {
        $order->load(['user', 'orderItems.product']);
        return view('admin.orders.show', compact('order'));
    }

    /**
     *  Update STATUS PEMBAYARAN (Belum Bayar / DP / Lunas)
     */
    public function updatePayment(Request $request, Order $order)
    {
        $request->validate([
            'status_payment' => 'required|in:Belum Bayar,DP,Lunas',
            'amount_paid' => 'nullable|numeric|min:0'
        ]);

        // Hitung amount_paid otomatis
        if ($request->status_payment === 'Lunas') {
            $amountPaid = $order->total_price;
        } elseif ($request->status_payment === 'DP') {
            $amountPaid = $request->amount_paid ?? 0;
        } else {
            $amountPaid = 0;
        }

        $order->update([
            'status_payment' => $request->status_payment,
            'amount_paid' => $amountPaid,
        ]);

        return back()->with('success', 'Status pembayaran berhasil diperbarui!');
    }

    /**
     *  Update status pesanan
     */
    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status_order' => 'required|in:Pending,Diproses,Siap Dikirim,Selesai,Ditolak',
        ]);

        // --- VALIDASI ALUR MAJU (FORWARD ONLY) ---
        // Kita beri bobot/rank untuk setiap status
        $statusRank = [
            'Pending' => 1,
            'Diproses' => 2,
            'Siap Dikirim' => 3,
            'Selesai' => 4,
            'Ditolak' => 5 // Bisa dianggap terminal state
        ];

        $currentRank = $statusRank[$order->status_order] ?? 0;
        $newRank = $statusRank[$request->status_order] ?? 0;

        // Aturan: Tidak boleh mundur (New Rank < Current Rank)
        // Kecuali jika status sekarang sudah Ditolak/Selesai mungkin tidak bisa diubah lagi?
        // Tapi request user spesifik: "tidak bisa dikembalikan lagi ke pending pokonya ga bisa mundur"
        // Jadi kita kunci jika $newRank < $currentRank

        // Pengecualian: Admin mungkin salah klik 'Ditolak' dan ingin mengembalikan ke proses? 
        // User bilang "ga bisa mundur", jadi kita strict saja. 

        if ($newRank < $currentRank) {
            return back()->with('error', "Status tidak dapat dikembalikan mundur! ({$order->status_order} -> {$request->status_order})");
        }

        // --- END VALIDASI ALUR ---

        //pembayaran 
        if (
            in_array($request->status_order, ['Diproses', 'Siap Dikirim', 'Selesai']) &&
            $order->status_payment !== 'Lunas'
        ) {
            return back()->with('error', 'Pesanan belum lunas!');
        }

        // kurangi stok
        if (
            $request->status_order === 'Diproses' &&
            !$order->stock_reduced
        ) {
            foreach ($order->items as $item) {
                $product = $item->product;

                if ($product->stock < $item->quantity) {
                    return back()->with(
                        'error',
                        "Stok {$product->name} tidak mencukupi!"
                    );
                }

                $product->decrement('stock', $item->quantity);
            }

            $order->update([
                'stock_reduced' => true,
                'processed_at' => now(),
            ]);
        }

        //update status order
        $order->status_order = $request->status_order;
        $order->save();

        return back()->with('success', 'Status pesanan berhasil diperbarui!');
    }


    /**
     *  Hapus pesanan
     */
    public function destroy(Order $order)
    {
        $order->orderItems()->delete();

        if ($order->bukti_transfer) {
            Storage::disk('public')->delete($order->bukti_transfer);
        }

        $order->delete();

        return back()->with('success', 'Pesanan berhasil dihapus.');
    }

    public function readyToShip(Order $order)
    {
        if ($order->status_payment !== 'Lunas') {
            return back()->with('error', 'Pesanan belum lunas');
        }

        if ($order->status_order !== 'Diproses') {
            return back()->with('error', 'Pesanan belum diproses');
        }

        if (!$order->shipments()->exists()) {
            // Buat shipment dengan data dari order
            $order->shipments()->create([
                'destination' => $order->alamat_lengkap ?? 'Alamat tidak tersedia',
                'shipment_date' => now()->toDateString(),
                'courier' => 'Belum ditentukan',
                'status' => 'Menunggu',
            ]);
        }

        $order->update([
            'status_order' => 'Siap Dikirim',
        ]);

        return back()->with('success', 'Pesanan siap dikirim');
    }




}
