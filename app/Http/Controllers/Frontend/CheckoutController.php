<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;

class CheckoutController extends Controller
{
    /**
     * Halaman checkout
     */
    public function index()
    {
        $cartItems = Cart::with('product')
            ->where('user_id', Auth::id())
            ->get();

        $total = $cartItems->sum(fn($item) => $item->product->price_sale * $item->quantity);

        return view('frontend.checkout', compact('cartItems', 'total'));
    }

    /**
     * Proses checkout
     */
    public function process(Request $request)
    {
        $request->validate([
            'nama_penerima' => 'required|string|max:255',
            'no_telepon' => 'required|string|max:20',
            'alamat' => 'required|string',
            'catatan' => 'nullable|string',
            'payment_method' => 'required|in:cash,transfer',
            'bukti_transfer' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $cartItems = Cart::with('product')
            ->where('user_id', Auth::id())
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('menu')->with('error', 'Keranjang kamu masih kosong!');
        }

        $total = $cartItems->sum(fn($item) => $item->product->price_sale * $item->quantity);

        // ======================
        // Upload bukti transfer
        // ======================
        $buktiPath = null;

        if ($request->payment_method === 'transfer' && $request->hasFile('bukti_transfer')) {
            $buktiPath = $request->file('bukti_transfer')->store('bukti_transfer', 'public');
        }

        // ======================
        // Status awal - sinkron dengan admin
        // ======================
        $status_order = 'Pending';
        // Status pembayaran: 'Belum Bayar', 'DP', 'Lunas' (sesuai enum di database)
        $status_payment = 'Belum Bayar';
        $amount_paid = 0;



        // ======================
        // Simpan order
        // ======================
        $order = Order::create([
            'user_id'         => Auth::id(),
            'source'          => 'web',
            'total_price'     => $total,
            'status_order'    => $status_order,
            'status_payment'  => $status_payment,
            'payment_method'  => $request->payment_method,
            'amount_paid'     => $amount_paid,
            'nama_penerima'   => $request->nama_penerima,
            'telepon'         => $request->no_telepon,
            'alamat_lengkap'  => $request->alamat,
            'catatan'         => $request->catatan,
            'rekening_tujuan' => $request->payment_method === 'transfer'
                ? 'BANK BRI - 1234 5678 9012 a.n Bakso Siocay'
                : null,
            'bukti_transfer'  => $buktiPath,
        ]);

        // ======================
        // Simpan item pesanan
        // ======================
        foreach ($cartItems as $item) {
            OrderItem::create([
                'order_id'   => $order->id,
                'product_id' => $item->product_id,
                'quantity'   => $item->quantity,
                'price'      => $item->product->price_sale,
            ]);
        }

        // ======================
        // Kosongkan keranjang
        // ======================
        Cart::where('user_id', Auth::id())->delete();

        return redirect()
            ->route('frontend.riwayat')
            ->with('success', 'Pesanan kamu berhasil dibuat! Tunggu konfirmasi admin 💜');
    }
}
