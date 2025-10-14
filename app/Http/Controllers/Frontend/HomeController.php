<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $products = Product::latest()->take(8)->get();
        return view('frontend.home', compact('products'));
    }

    public function menu()
    {
        $products = Product::all();
        return view('frontend.menu', compact('products'));
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);
        return view('frontend.detail', compact('product'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity'   => 'required|integer|min:1',
        ]);

        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu untuk memesan.');
        }

        $product = Product::findOrFail($request->product_id);
        $total = $product->price * $request->quantity;

        Order::create([
            'user_id'        => Auth::id(),
            'total_price'    => $total,
            'status_order'   => 'Pending',
            'status_payment' => 'Belum Bayar',
            'amount_paid'    => 0,
        ]);

        return redirect()->route('home')->with('success', 'Pesanan berhasil dibuat!');
    }
}
