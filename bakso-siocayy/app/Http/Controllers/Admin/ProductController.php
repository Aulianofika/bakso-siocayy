<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
            public function index() {
            $products = Product::with('category')->get();
            return view('admin.products.index', compact('products'));
        }

        public function create() {
            $categories = Category::all();
            return view('admin.products.create', compact('categories'));
        }

        public function store(Request $request) {
            $request->validate([
                'name'=>'required',
                'category_id'=>'required',
                'price_sale'=>'required|numeric',
                'price_cost'=>'required|numeric',
                'stock'=>'required|integer',
                'image'=>'nullable|image|mimes:jpeg,png,jpg|max:2048'
            ]);

            $data = $request->all();
            if($request->hasFile('image')){
                $file = $request->file('image');
                $filename = time().'_'.$file->getClientOriginalName();
                $file->move(public_path('images/products'), $filename);
                $data['image'] = $filename;
            }

            Product::create($data);
            return redirect()->route('admin.products.index')->with('success','Product created.');
        }

        public function edit(Product $product) {
            $categories = Category::all();
            return view('admin.products.edit', compact('product','categories'));
        }

        public function update(Request $request, Product $product) {
            $request->validate([
                'name'=>'required',
                'category_id'=>'required',
                'price_sale'=>'required|numeric',
                'price_cost'=>'required|numeric',
                'stock'=>'required|integer',
                'image'=>'nullable|image|mimes:jpeg,png,jpg|max:2048'
            ]);

            $data = $request->all();
            if($request->hasFile('image')){
                $file = $request->file('image');
                $filename = time().'_'.$file->getClientOriginalName();
                $file->move(public_path('images/products'), $filename);
                $data['image'] = $filename;
            }

            $product->update($data);
            return redirect()->route('admin.products.index')->with('success','Product updated.');
        }

        public function destroy(Product $product) {
            $product->delete();
            return redirect()->route('admin.products.index')->with('success','Product deleted.');
        }

}
