<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ReturnModel;
use App\Models\Product;
use App\Models\Shipment;
use Illuminate\Http\Request;

class ReturnModelController extends Controller
{
    public function index()
    {
        $returns = ReturnModel::with(['shipment.order.customer', 'product'])->latest()->paginate(10);
        return view('admin.returns.index', compact('returns'));
    }

    public function create()
    {
        $shipments = Shipment::with('order')->get();
        $products = Product::all();
        return view('admin.returns.create', compact('shipments', 'products'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'shipment_id' => 'required|exists:shipments,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'reason' => 'nullable|string|max:255',
            'restock' => 'boolean',
        ]);

        $product = Product::findOrFail($data['product_id']);
        $data['loss'] = $product->price_cost * $data['quantity'];

        $return = ReturnModel::create($data);

        // kalau barang direstock → tambah stok produk
        if ($request->restock) {
            $product->increment('stock', $data['quantity']);
        }

        return redirect()->route('admin.returns.index')->with('success', 'Data retur berhasil disimpan.');
    }

    public function show($id)
    {
        $return = ReturnModel::with(['shipment.order.customer', 'product'])->findOrFail($id);
        return view('admin.returns.show', compact('return'));
    }

    // ================= EDIT & UPDATE =================
    public function edit($id)
    {
        $return = ReturnModel::findOrFail($id);
        $shipments = Shipment::with('order')->get();
        $products = Product::all();
        return view('admin.returns.edit', compact('return', 'shipments', 'products'));
    }

    public function update(Request $request, $id)
    {
        $return = ReturnModel::findOrFail($id);

        $data = $request->validate([
            'shipment_id' => 'required|exists:shipments,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'reason' => 'nullable|string|max:255',
            'restock' => 'boolean',
        ]);

        $product = Product::findOrFail($data['product_id']);

        // hitung ulang loss
        $data['loss'] = $product->price_cost * $data['quantity'];

        // jika sebelumnya direstock, kurangi stok lama
        if ($return->restock) {
            $oldProduct = Product::findOrFail($return->product_id);
            $oldProduct->decrement('stock', $return->quantity);
        }

        // simpan update
        $return->update($data);

        // jika sekarang direstock, tambahkan stok baru
        if ($request->restock) {
            $product->increment('stock', $data['quantity']);
        }

        return redirect()->route('admin.returns.index')->with('success', 'Data retur berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $return = ReturnModel::findOrFail($id);

        // jika sebelumnya direstock, kurangi stok produk
        if ($return->restock) {
            $product = Product::findOrFail($return->product_id);
            $product->decrement('stock', $return->quantity);
        }

        $return->delete();

        return redirect()->route('admin.returns.index')->with('success', 'Data retur berhasil dihapus.');
    }
}
