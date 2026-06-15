<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    /**
     * Pertemuan 9: GET semua product (public)
     */
    public function index()
    {
        $products = Product::with(['user', 'category'])->latest()->get();

        return response()->json([
            'message' => 'Daftar semua produk',
            'data'    => $products,
        ], 200);
    }

    /**
     * Pertemuan 9: POST product baru (auth:sanctum)
     */
    public function store(StoreProductRequest $request)
    {
        try {
            $validated = $request->validated();
            $validated['user_id'] = Auth::id();

            $product = Product::create($validated);
            $product->load(['user', 'category']);

            return response()->json([
                'message' => 'Produk berhasil ditambahkan',
                'data'    => $product,
            ], 201);
        } catch (\Exception $e) {
            Log::error('API Product store error', ['message' => $e->getMessage()]);

            return response()->json([
                'message' => 'Terjadi kesalahan saat menyimpan produk',
            ], 500);
        }
    }

    /**
     * Pertemuan 9: GET product by id (public)
     */
    public function show(int $id)
    {
        $product = Product::with(['user', 'category'])->find($id);

        if (! $product) {
            return response()->json([
                'message' => 'Produk tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'message' => 'Detail produk',
            'data'    => $product,
        ], 200);
    }

    /**
     * Pertemuan 9: PUT/PATCH update product (auth:sanctum)
     */
    public function update(UpdateProductRequest $request, int $id)
    {
        $product = Product::find($id);

        if (! $product) {
            return response()->json([
                'message' => 'Produk tidak ditemukan',
            ], 404);
        }

        try {
            $product->update($request->validated());
            $product->load(['user', 'category']);

            return response()->json([
                'message' => 'Produk berhasil diperbarui',
                'data'    => $product,
            ], 200);
        } catch (\Exception $e) {
            Log::error('API Product update error', ['message' => $e->getMessage()]);

            return response()->json([
                'message' => 'Terjadi kesalahan saat memperbarui produk',
            ], 500);
        }
    }

    /**
     * Pertemuan 9: DELETE product (auth:sanctum)
     */
    public function destroy(int $id)
    {
        $product = Product::find($id);

        if (! $product) {
            return response()->json([
                'message' => 'Produk tidak ditemukan',
            ], 404);
        }

        try {
            $product->delete();

            return response()->json([
                'message' => 'Produk berhasil dihapus',
            ], 200);
        } catch (\Exception $e) {
            Log::error('API Product destroy error', ['message' => $e->getMessage()]);

            return response()->json([
                'message' => 'Terjadi kesalahan saat menghapus produk',
            ], 500);
        }
    }
}
