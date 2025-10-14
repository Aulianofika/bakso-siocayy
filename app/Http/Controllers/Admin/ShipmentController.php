<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Shipment;
use App\Models\Order;
use Illuminate\Http\Request;

class ShipmentController extends Controller
{
    public function index()
    {
        $shipments = Shipment::with('order')->latest()->paginate(10);
        return view('admin.shipments.index', compact('shipments'));
    }

    public function create()
    {
        $orders = Order::all(); // untuk dropdown pilih order
        return view('admin.shipments.create', compact('orders'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'destination' => 'required|string|max:255',
            'shipment_date' => 'required|date',
            'courier' => 'required|string|max:100',
        ]);

        Shipment::create($request->all());

        return redirect()->route('admin.shipments.index')
            ->with('success', 'Pengiriman berhasil ditambahkan.');
    }

    public function show(Shipment $shipment)
    {
        return view('admin.shipments.show', compact('shipment'));
    }

    public function edit(Shipment $shipment)
    {
        $orders = Order::all();
        return view('admin.shipments.edit', compact('shipment', 'orders'));
    }

    public function update(Request $request, Shipment $shipment)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'destination' => 'required|string|max:255',
            'shipment_date' => 'required|date',
            'courier' => 'required|string|max:100',
        ]);

        $shipment->update($request->all());

        return redirect()->route('admin.shipments.index')
            ->with('success', 'Pengiriman berhasil diperbarui.');
    }

    public function destroy(Shipment $shipment)
    {
        $shipment->delete();

        return redirect()->route('admin.shipments.index')
            ->with('success', 'Pengiriman berhasil dihapus.');
    }
}
