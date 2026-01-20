<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Notifications\OrderStatusChanged;

class OrderController extends Controller
{
    /**
     * Menampilkan semua pesanan
     */
    public function index(Request $request)
    {
        $query = Order::with(['user', 'orderItems.product.category']);

        // Filter Sort (Terbaru / Terlama)
        if ($request->input('sort') === 'oldest') {
            $query->oldest();
        } else {
            $query->latest(); // Default newest
        }

        // Filter Search (Invoice / Nama Pelanggan)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('invoice_number', 'like', "%{$search}%")
                    ->orWhere('id', 'like', "%{$search}%") // Fallback for ID if invoice is ID
                    ->orWhereHas('user', function ($u) use ($search) {
                        $u->where('name', 'like', "%{$search}%");
                    });
            });
        }

        if ($request->filled('status_order')) {
            if ($request->status_order === 'attention') {
                $query->whereIn('status_order', ['Pending', 'Menunggu Pembatalan']);
            } else {
                $query->where('status_order', $request->status_order);
            }
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
     *  Update STATUS PEMBAYARAN (Verifikasi / Tolak)
     */
    public function updatePayment(Request $request, Order $order)
    {
        $request->validate([
            'action' => 'required|in:verify,reject',
            'note' => 'nullable|string|required_if:action,reject', // Note required if rejected
        ]);

        if ($request->action === 'verify') {
            $order->update([
                'status_payment' => 'Lunas',
                'amount_paid' => $order->total_price, // Full payment
                'payment_verified_at' => now(),
            ]);

            // Notify User
            $order->user->notify(new OrderStatusChanged($order, 'Pembayaran Anda telah diverifikasi.'));

            return back()->with('success', 'Pembayaran berhasil diverifikasi!');
        }

        if ($request->action === 'reject') {
            // Kembalikan stok
            $this->restoreStock($order);

            $order->update([
                'status_payment' => 'Ditolak',
                'status_order' => 'Ditolak',
                'amount_paid' => 0,
                'rejection_note' => $request->note,
            ]);

            // Notify User
            $order->user->notify(new OrderStatusChanged($order, 'Maaf, pembayaran Anda ditolak.'));

            return back()->with('success', 'Pembayaran dan Pesanan ditolak, stok dikembalikan!');
        }

        return back()->with('error', 'Aksi tidak valid');
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
        // Kita beri bobot/rank untuk setiap status
        $statusRank = [
            'Pending' => 1,
            'Menunggu Pembatalan' => 1, // Setara pending levelnya
            'Diproses' => 2,
            'Siap Dikirim' => 3,
            'Selesai' => 4,
            'Ditolak' => 5 // Bisa dianggap terminal state
        ];

        $currentRank = $statusRank[$order->status_order] ?? 0;
        $newRank = $statusRank[$request->status_order] ?? 0;

        // Aturan: Tidak boleh mundur (New Rank < Current Rank), KECUALI jika dari 'Menunggu Pembatalan' kembali ke 'Diproses' atau 'Pending'
        $isRevertingCancel = ($order->status_order === 'Menunggu Pembatalan' && in_array($request->status_order, ['Diproses', 'Pending']));

        if ($newRank < $currentRank && !$isRevertingCancel) {
            return back()->with('error', 'Pesanan tidak bisa diubah mundur');
        }

        // --- END VALIDASI ALUR ---

        //pembayaran 
        if (
            in_array($request->status_order, ['Diproses', 'Siap Dikirim', 'Selesai']) &&
            $order->status_payment !== 'Lunas' &&
            $order->payment_method !== 'cash' // Allow cash orders to proceed without being 'Lunas' first
        ) {
            return back()->with('error', 'Pesanan belum lunas, harap cek pembayaran terlebih dahulu!');
        }

        // Stock reduction removed from Admin - Managed by Checkout


        //update status order
        // Jika status diubah jadi Ditolak dan sebelumnya belum Ditolak, kembalikan stok
        if ($request->status_order === 'Ditolak' && $order->status_order !== 'Ditolak') {
            $this->restoreStock($order);
            $order->status_payment = 'Ditolak'; // Opsional: Sinkronkan status pembayaran
        }

        $order->status_order = $request->status_order;
        $order->save();

        // Notify User
        $order->user->notify(new OrderStatusChanged($order, "Status pesanan Anda telah berubah menjadi: {$request->status_order}"));

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
        if ($order->status_payment !== 'Lunas' && $order->payment_method !== 'cash') {
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

    /**
     * Helper: Kembalikan stok produk
     */
    private function restoreStock(Order $order)
    {
        foreach ($order->orderItems as $item) {
            $product = $item->product;
            if ($product) {
                $product->increment('stock', $item->quantity);
            }
        }
    }
}
