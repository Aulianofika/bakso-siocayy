<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;

class RiwayatController extends Controller
{
    public function index()
    {
        $orders = Order::with(['orderItems.product'])
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('frontend.riwayat', compact('orders'));
    }
}
