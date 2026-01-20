<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    // 🧺 Menampilkan isi keranjang
    public function index()
    {
        $cartItems = Cart::where('user_id', Auth::id())->with('product')->get();
        return view('frontend.cart', compact('cartItems'));
    }

    // ➕ Tambah produk ke keranjang
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($request->product_id);

        // Jika tipe checkout langsung, jangan simpan ke database cart dulu
        if ($request->input('type') === 'checkout') {
            return redirect()->route('checkout.index', [
                'direct_product_id' => $product->id,
                'direct_quantity' => $request->quantity
            ])->with('success', 'Produk ditambahkan, silakan lanjutkan pembayaran!');
        }

        // Cek apakah produk sudah ada di keranjang
        $cartItem = Cart::where('user_id', Auth::id())
            ->where('product_id', $product->id)
            ->first();

        // VALIDASI STOK (Stock Management)
        $currentCartQty = $cartItem ? $cartItem->quantity : 0;
        $totalRequested = $currentCartQty + $request->quantity;

        if ($totalRequested > $product->stock) {
            return back()->with('error', 'Stok tidak mencukupi! Sisa stok rata-rata: ' . $product->stock);
        }

        if ($cartItem) {
            $cartItem->update([
                'quantity' => $cartItem->quantity + $request->quantity
            ]);
        } else {
            Cart::create([
                'user_id' => Auth::id(),
                'product_id' => $product->id,
                'quantity' => $request->quantity,
            ]);
        }

        // Return JSON for AJAX requests
        if ($request->ajax() || $request->wantsJson()) {
            $newCartCount = Cart::where('user_id', Auth::id())->sum('quantity');
            return response()->json([
                'success' => true,
                'message' => 'Produk berhasil ditambahkan ke keranjang!',
                'cart_count' => $newCartCount
            ]);
        }

        return redirect()->route('cart.index')->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }

    // 🔄 Update quantity via AJAX
    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:carts,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $cartItem = Cart::where('id', $request->id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $product = $cartItem->product;

        // Check stock availability
        if ($request->quantity > $product->stock) {
            return response()->json([
                'success' => false,
                'message' => 'Stok tidak mencukupi! Sisa stok: ' . $product->stock,
                'current_quantity' => $cartItem->quantity // Return old quantity to revert UI
            ], 400);
        }

        $cartItem->update([
            'quantity' => $request->quantity
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Keranjang diperbarui',
            'subtotal' => $cartItem->quantity * $product->price_sale
        ]);
    }

    // ❌ Hapus item dari keranjang
    public function remove($id)
    {
        $item = Cart::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $item->delete();

        return back()->with('success', 'Item berhasil dihapus dari keranjang!');
    }
}
