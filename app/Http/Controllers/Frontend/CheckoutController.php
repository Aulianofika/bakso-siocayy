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
    public function index(Request $request)
    {
        // 1. Cek apakah ini checkout langsung (Beli Langsung)
        if ($request->has('direct_product_id') && $request->has('direct_quantity')) {
            $product = \App\Models\Product::find($request->direct_product_id);

            if (!$product) {
                return redirect()->route('menu')->with('error', 'Produk tidak ditemukan!');
            }

            // Buat objek Cart "palsu" untuk ditampilkan di view, tanpa simpan ke DB
            $fakeCartItem = new \App\Models\Cart([
                'id' => null, // ID null menandakan item ini bukan dari DB cart
                'user_id' => Auth::id(),
                'product_id' => $product->id,
                'quantity' => $request->direct_quantity,
            ]);
            $fakeCartItem->setRelation('product', $product);

            $cartItems = collect([$fakeCartItem]);
            $total = $product->price_sale * $request->direct_quantity;

            // Kirim flag direct_checkout agar view tahu
            return view('frontend.checkout', compact('cartItems', 'total'))->with('direct_mode', true);
        }

        // 2. Checkout normal dari keranjang
        $query = Cart::with('product')
            ->where('user_id', Auth::id());

        // Jika ada item yang dipilih dari keranjang
        if ($request->has('selected_items')) {
            $query->whereIn('id', $request->selected_items);
        }

        $cartItems = $query->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Silakan pilih produk yang ingin di-checkout, tidak boleh kosong!');
        }

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
            // selected_items required only if NOT direct checkout
            'selected_items' => 'required_without:direct_product_id|array',
            'selected_items.*' => 'exists:carts,id',
            'direct_product_id' => 'nullable|exists:products,id',
            'direct_quantity' => 'nullable|integer|min:1',
        ]);

        $cartItems = collect([]);

        // A. Handle Direct Checkout
        if ($request->has('direct_product_id') && $request->has('direct_quantity')) {
            $product = \App\Models\Product::find($request->direct_product_id);
            if (!$product) {
                return back()->with('error', 'Produk tidak valid.');
            }

            // Buat item sementara
            $fakeItem = new \stdClass();
            $fakeItem->product_id = $product->id;
            $fakeItem->quantity = $request->direct_quantity;
            $fakeItem->product = $product; // Untuk akses harga nanti

            $cartItems->push($fakeItem);

        } else {
            // B. Handle Cart Checkout
            $cartItems = Cart::with('product')
                ->where('user_id', Auth::id())
                ->whereIn('id', $request->selected_items)
                ->get();

            if ($cartItems->isEmpty()) {
                return redirect()->route('menu')->with('error', 'Keranjang kamu masih kosong!');
            }
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
        // Status pembayaran: 'Menunggu Verifikasi', 'Lunas' (sesuai enum di database)
        $status_payment = 'Menunggu Verifikasi';
        $amount_paid = 0;



        // ======================
        // Simpan order
        // ======================
        $order = Order::create([
            'user_id' => Auth::id(),
            'source' => 'web',
            'total_price' => $total,
            'status_order' => $status_order,
            'status_payment' => $status_payment,
            'payment_method' => $request->payment_method,
            'amount_paid' => $amount_paid,
            'nama_penerima' => $request->nama_penerima,
            'telepon' => $request->no_telepon,
            'alamat_lengkap' => $request->alamat,
            'catatan' => $request->catatan,
            'rekening_tujuan' => $request->payment_method === 'transfer'
                ? 'BANK BRI - 1234 5678 9012 a.n Bakso Siocay'
                : null,
            'bukti_transfer' => $buktiPath,
        ]);

        // ======================
        // Simpan item pesanan
        // ======================
        foreach ($cartItems as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'price' => $item->product->price_sale,
            ]);

            // ======================
            // Kurangi Stok Produk
            // ======================
            $product = \App\Models\Product::find($item->product_id);
            if ($product) {
                // Pastikan stok tidak negatif (optional safety check)
                $newStock = max(0, $product->stock - $item->quantity);
                $product->update(['stock' => $newStock]);
            }
        }

        // ======================
        // Kosongkan keranjang (Hanya jika checkout dari keranjang)
        // ======================
        if (!$request->has('direct_product_id')) {
            Cart::where('user_id', Auth::id())
                ->whereIn('id', $request->selected_items)
                ->delete();
        }

        return redirect()
            ->route('frontend.riwayat')
            ->with('success', 'Pesanan kamu berhasil dibuat! Tunggu konfirmasi admin 💜');
    }
}
