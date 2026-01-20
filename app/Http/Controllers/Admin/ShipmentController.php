<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Shipment;
use App\Models\Order;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ShipmentController extends Controller
{
    /**
     * List pengiriman
     */
    public function index(Request $request)
    {
        $query = Shipment::with('order.user')->latest();

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('courier', 'like', "%{$search}%")
                    ->orWhere('destination', 'like', "%{$search}%")
                    ->orWhereHas('order', function ($subQ) use ($search) {
                        $subQ->where('invoice_number', 'like', "%{$search}%")
                            ->orWhereHas('user', function ($userQ) use ($search) {
                                $userQ->where('name', 'like', "%{$search}%");
                            });
                    });
            });
        }

        $shipments = $query->paginate(10); // Keep pagination

        return view('admin.shipments.index', compact('shipments'));
    }

    /**
     * Form buat pengiriman (OPSIONAL)
     * Biasanya shipment dibuat otomatis dari order
     */
    public function create()
    {
        $orders = Order::where('status_order', 'Siap Dikirim')
            ->whereDoesntHave('shipments')
            ->with('user')
            ->get();

        return view('admin.shipments.create', compact('orders'));
    }

    /**
     * Simpan shipment manual (JIKA DIPAKAI)
     */
    public function store(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'destination' => 'required|string|max:255',
            'courier' => 'required|string|max:100',
            'shipment_date' => 'required|date',
        ]);

        $order = Order::findOrFail($request->order_id);

        if ($order->status_order !== 'Siap Dikirim') {
            return back()->with('error', 'Pesanan belum siap dikirim');
        }

        if ($order->shipments()->exists()) {
            return back()->with('error', 'Pesanan sudah memiliki pengiriman');
        }

        Shipment::create([
            'order_id' => $order->id,
            'destination' => $request->destination,
            'courier' => $request->courier,
            'shipment_date' => $request->shipment_date,
            'status' => 'Menunggu',
        ]);

        return redirect()->route('admin.shipments.index')
            ->with('success', 'Pengiriman berhasil dibuat');
    }

    /**
     * Detail pengiriman
     */
    public function show(Shipment $shipment)
    {
        $shipment->load(['order.user', 'order.orderItems.product']);
        return view('admin.shipments.show', compact('shipment'));
    }

    /**
     * Edit shipment
     */
    public function edit(Shipment $shipment)
    {
        $shipment->load('order.user');
        return view('admin.shipments.edit', compact('shipment'));
    }

    /**
     * Update shipment (alamat / kurir)
     */
    public function update(Request $request, Shipment $shipment)
    {
        $request->validate([
            'destination' => 'required|string|max:255',
            'courier' => 'required|string|max:100',
            'shipment_date' => 'required|date',
        ]);

        if ($shipment->status !== 'Menunggu') {
            return back()->with('error', 'Pengiriman sudah diproses');
        }

        $shipment->update($request->only([
            'destination',
            'courier',
            'shipment_date',
        ]));

        return redirect()->route('admin.shipments.index')
            ->with('success', 'Pengiriman diperbarui');
    }

    /**
     * Kirim pesanan
     */
    public function kirim(Shipment $shipment)
    {
        $order = $shipment->order;

        if ($order->status_payment !== 'Lunas') {
            return back()->with('error', 'Pesanan belum lunas');
        }

        if ($order->status_order !== 'Siap Dikirim') {
            return back()->with('error', 'Pesanan belum siap dikirim');
        }

        if ($shipment->status !== 'Menunggu') {
            return back()->with('error', 'Pesanan sudah dikirim');
        }

        $shipment->update([
            'status' => 'Dikirim',
            'dikirim_at' => now(),
        ]);

        return back()->with('success', 'Pesanan berhasil dikirim');
    }

    /**
     * Tandai diterima pelanggan
     */
    public function terima(Shipment $shipment)
    {
        if ($shipment->status !== 'Dikirim') {
            return back()->with('error', 'Pesanan belum dikirim');
        }

        $shipment->update([
            'status' => 'Diterima',
            'diterima_at' => now(),
        ]);

        // ❗ Order JANGAN auto selesai
        // Biarkan admin / sistem yang set "Selesai"

        return back()->with('success', 'Pesanan diterima pelanggan');
    }

    /**
     * Hapus shipment
     */
    public function destroy(Shipment $shipment)
    {
        if ($shipment->status !== 'Menunggu') {
            return back()->with('error', 'Pengiriman sedang berjalan');
        }

        $shipment->delete();

        return back()->with('success', 'Pengiriman dihapus');
    }
    /**
     * Export PDF
     */
    public function export(Request $request)
    {
        $shipments = Shipment::with('order.user')->latest()->get();

        if ($request->input('type') === 'excel') {
            return response()->streamDownload(function () use ($shipments) {
                echo view('admin.shipments.excel', compact('shipments'))->render();
            }, 'Laporan_Pengiriman_' . date('Y-m-d') . '.xls');
        }

        $pdf = Pdf::loadView('admin.shipments.pdf', compact('shipments'));
        // Set paper size & orientation
        $pdf->setPaper('a4', 'landscape');

        return $pdf->download('Laporan_Pengiriman_' . date('Y-m-d') . '.pdf');
    }
    /**
     * Preview Report
     */
    public function preview()
    {
        $shipments = Shipment::with('order.user')->latest()->get();
        return view('admin.shipments.preview', compact('shipments'));
    }
}
