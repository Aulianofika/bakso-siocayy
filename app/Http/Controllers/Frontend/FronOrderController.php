<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FronOrderController extends Controller
{
    /**
     * Customer klik "Pesanan Diterima"
     */
    public function received($id)
    {
        $order = Order::findOrFail($id);

        // Validasi status order
        if ($order->status_order !== 'Dikirim') {
            return back()->with('error', 'Pesanan belum dikirim.');
        }

        // Ambil shipment (TIDAK create baru)
        $shipment = $order->shipment;

        if (!$shipment) {
            return back()->with('error', 'Data pengiriman tidak ditemukan.');
        }

        // Update shipment
        $shipment->update([
            'status' => 'Diterima',
            'diterima_at' => now(),
        ]);

        // Update order
        $order->update([
            'status_order' => 'Selesai',
        ]);

        return back()->with('success', 'Pesanan berhasil diterima.');
    }

    /**
     * Customer request cancel
     */
    public function cancel(Request $request, $id)
    {
        $order = Order::where('user_id', auth()->id())->where('id', $id)->firstOrFail();

        if (in_array($order->status_order, ['Pending', 'Diproses'])) {
            $order->update(['status_order' => 'Menunggu Pembatalan']);
            return back()->with('success', 'Permintaan pembatalan berhasil dikirim. Menunggu persetujuan admin.');
        }

        return back()->with('error', 'Status pesanan tidak valid untuk pembatalan.');
    }

    public function invoice($id)
    {
        $order = Order::with(['orderItems.product', 'user'])
            ->where('user_id', auth()->id())
            ->where('id', $id)
            ->firstOrFail();

        return view('frontend.invoice', compact('order'));
    }
}
