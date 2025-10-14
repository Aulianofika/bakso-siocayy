<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StockIncident;
use App\Models\Product;
use Illuminate\Http\Request;

class StockIncidentController extends Controller
{
    public function index()
    {
        $incidents = StockIncident::with('product')->latest()->paginate(10);
        return view('admin.stock_incidents.index', compact('incidents'));
    }

    public function create()
    {
        $products = Product::all();
        return view('admin.stock_incidents.create', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'type'       => 'required|in:Retur,Reject,Hilang',
            'quantity'   => 'required|integer|min:1',
            'loss'       => 'nullable|numeric',
            'restock'    => 'boolean',
            'note'       => 'nullable|string',
        ]);

        StockIncident::create([
            'product_id' => $request->product_id,
            'type'       => $request->type,
            'quantity'   => $request->quantity,
            'loss'       => $request->loss ?? 0,
            'restock'    => $request->restock ? true : false,
            'note'       => $request->note,
        ]);

        return redirect()->route('admin.stock-incidents.index')
            ->with('success', 'Data insiden stok berhasil ditambahkan.');
    }

    public function show(StockIncident $stockIncident)
    {
        return view('admin.stock_incidents.show', compact('stockIncident'));
    }

    public function edit(StockIncident $stockIncident)
    {
        $products = Product::all();
        return view('admin.stock_incidents.edit', compact('stockIncident', 'products'));
    }

    public function update(Request $request, StockIncident $stockIncident)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'type'       => 'required|in:Retur,Reject,Hilang',
            'quantity'   => 'required|integer|min:1',
            'loss'       => 'nullable|numeric',
            'restock'    => 'boolean',
            'note'       => 'nullable|string',
        ]);

        $stockIncident->update([
            'product_id' => $request->product_id,
            'type'       => $request->type,
            'quantity'   => $request->quantity,
            'loss'       => $request->loss ?? 0,
            'restock'    => $request->restock ? true : false,
            'note'       => $request->note,
        ]);

        return redirect()->route('admin.stock-incidents.index')
            ->with('success', 'Data insiden stok berhasil diperbarui.');
    }

    public function destroy(StockIncident $stockIncident)
    {
        $stockIncident->delete();
        return redirect()->route('admin.stock-incidents.index')
            ->with('success', 'Data insiden stok berhasil dihapus.');
    }
}
