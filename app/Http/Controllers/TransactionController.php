<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionItem;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::with('products')->latest()->get();

        if (request()->expectsJson()) {
            return response()->json(['success' => true, 'data' => $transactions]);
        }

        return view('transactions.index', compact('transactions'));
    }

    public function create()
    {
        $products = Product::all();

        if (request()->expectsJson()) {
            return response()->json(['success' => true, 'data' => $products]);
        }

        return view('transactions.create', compact('products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'payment_method' => 'required|string',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        // 1️⃣ Buat transaksi baru
        $transaction = Transaction::create([
            'payment_method' => $validated['payment_method'],
            'total' => 0,
        ]);

        $total = 0;
        $syncData = [];

        // 2️⃣ Simpan setiap item ke pivot `transaction_items`
        foreach ($validated['items'] as $item) {
            $product = Product::find($item['product_id']);
            $subtotal = $product->price * $item['quantity'];
            $total += $subtotal;

            $syncData[$product->id] = [
                'quantity' => $item['quantity'],
                'price' => $product->price,
                'subtotal' => $subtotal,
            ];

            // Kurangi stok produk
            $product->decrement('stock', $item['quantity']);
        }

        // 3️⃣ Sinkronisasi pivot many-to-many
        $transaction->products()->sync($syncData);
        $transaction->update(['total' => $total]);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Transaksi berhasil dibuat',
                'data' => $transaction->load('products')
            ]);
        }

        return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil dibuat');
    }

    public function edit(Transaction $transaction)
    {
        $products = Product::all();
        $transaction->load('products');

        if (request()->expectsJson()) {
            return response()->json([
                'success' => true,
                'data' => [
                    'transaction' => $transaction,
                    'products' => $products
                ]
            ]);
        }

        return view('transactions.edit', compact('transaction', 'products'));
    }

    public function update(Request $request, Transaction $transaction)
    {
        $validated = $request->validate([
            'payment_method' => 'required|string',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        $total = 0;
        $syncData = [];

        // Pulihkan stok lama dulu
        foreach ($transaction->products as $product) {
            $product->increment('stock', $product->pivot->quantity);
        }

        // Buat data baru
        foreach ($validated['items'] as $item) {
            $product = Product::find($item['product_id']);
            $subtotal = $product->price * $item['quantity'];
            $total += $subtotal;

            $syncData[$product->id] = [
                'quantity' => $item['quantity'],
                'price' => $product->price,
                'subtotal' => $subtotal,
            ];

            $product->decrement('stock', $item['quantity']);
        }

        $transaction->update([
            'payment_method' => $validated['payment_method'],
            'total' => $total,
        ]);

        $transaction->products()->sync($syncData);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Transaksi berhasil diperbarui',
                'data' => $transaction->load('products')
            ]);
        }

        return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil diperbarui');
    }

    public function destroy(Transaction $transaction)
    {
        // Kembalikan stok
        foreach ($transaction->products as $product) {
            $product->increment('stock', $product->pivot->quantity);
        }

        $transaction->delete();

        if (request()->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Transaksi berhasil dihapus'
            ]);
        }

        return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil dihapus');
    }

    public function report()
    {
        $transactions = Transaction::with('products')->latest()->get();
        $total_harian = $transactions->sum('total');

        if (request()->expectsJson()) {
            return response()->json([
                'success' => true,
                'data' => [
                    'transactions' => $transactions,
                    'total_harian' => $total_harian
                ]
            ]);
        }

        return view('transactions.report', compact('transactions', 'total_harian'));
    }

    public function downloadPdf()
    {
        $transactions = Transaction::with('products')->latest()->get();
        $total_harian = $transactions->sum('total');

        $pdf = Pdf::loadView('transactions.report-pdf', compact('transactions', 'total_harian'))
                ->setPaper('a4', 'portrait');

        return $pdf->download('laporan_harian.pdf');
    }
}
