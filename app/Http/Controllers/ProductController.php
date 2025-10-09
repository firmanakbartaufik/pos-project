<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();

        if (request()->expectsJson()) {
            return response()->json(['success' => true, 'data' => $products]);
        }

        return view('products.index', compact('products'));
    }

    public function create()
    {
        if (request()->expectsJson()) {
            return response()->json(['success' => true, 'message' => 'Gunakan endpoint store untuk menambahkan produk']);
        }

        return view('products.create');
    }

    // Simpan produk baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'discount' => 'nullable|numeric',
            'stock' => 'required|integer',
        ]);

        $product = Product::create($validated);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Produk berhasil ditambahkan',
                'data' => $product
            ]);
        }

        return redirect()->route('products.index')->with('success', 'Produk berhasil ditambahkan');
    }

    // Edit produk
    public function edit(Product $product)
    {
        if (request()->expectsJson()) {
            return response()->json([
                'success' => true,
                'data' => $product
            ]);
        }

        return view('products.edit', compact('product'));
    }

    // Update produk
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'discount' => 'nullable|numeric',
            'stock' => 'required|integer',
        ]);

        $product->update($validated);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Produk berhasil diperbarui',
                'data' => $product
            ]);
        }

        return redirect()->route('products.index')->with('success', 'Produk berhasil diperbarui');
    }

    // Hapus produk
    public function destroy(Product $product)
    {
        $product->delete();

        if (request()->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Produk berhasil dihapus'
            ]);
        }

        return redirect()->route('products.index')->with('success', 'Produk berhasil dihapus');
    }
}
