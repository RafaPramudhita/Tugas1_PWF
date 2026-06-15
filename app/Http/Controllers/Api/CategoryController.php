<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CategoryController extends Controller
{
    /**
     * Pertemuan 9: GET semua category (auth:sanctum)
     * Menampilkan products_count
     */
    public function index()
    {
        $categories = Category::withCount('products')->latest()->get();

        return response()->json([
            'message' => 'Daftar semua kategori',
            'data'    => $categories,
        ], 200);
    }

    /**
     * Pertemuan 9: POST category baru (auth:sanctum)
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:category,name',
        ], [
            'name.required' => 'Nama kategori wajib diisi.',
            'name.string'   => 'Nama kategori harus berupa teks.',
            'name.max'      => 'Nama kategori tidak boleh lebih dari 255 karakter.',
            'name.unique'   => 'Nama kategori sudah digunakan.',
        ]);

        try {
            $category = Category::create($validated);
            $category->loadCount('products');

            return response()->json([
                'message' => 'Kategori berhasil ditambahkan',
                'data'    => $category,
            ], 201);
        } catch (\Exception $e) {
            Log::error('API Category store error', ['message' => $e->getMessage()]);

            return response()->json([
                'message' => 'Terjadi kesalahan saat menyimpan kategori',
            ], 500);
        }
    }

    /**
     * Pertemuan 9: GET category by id (auth:sanctum)
     */
    public function show(int $id)
    {
        $category = Category::withCount('products')->find($id);

        if (! $category) {
            return response()->json([
                'message' => 'Kategori tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'message' => 'Detail kategori',
            'data'    => $category,
        ], 200);
    }

    /**
     * Pertemuan 9: PUT/PATCH update category (auth:sanctum)
     */
    public function update(Request $request, int $id)
    {
        $category = Category::find($id);

        if (! $category) {
            return response()->json([
                'message' => 'Kategori tidak ditemukan',
            ], 404);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:category,name,' . $category->id,
        ], [
            'name.required' => 'Nama kategori wajib diisi.',
            'name.string'   => 'Nama kategori harus berupa teks.',
            'name.max'      => 'Nama kategori tidak boleh lebih dari 255 karakter.',
            'name.unique'   => 'Nama kategori sudah digunakan.',
        ]);

        try {
            $category->update($validated);
            $category->loadCount('products');

            return response()->json([
                'message' => 'Kategori berhasil diperbarui',
                'data'    => $category,
            ], 200);
        } catch (\Exception $e) {
            Log::error('API Category update error', ['message' => $e->getMessage()]);

            return response()->json([
                'message' => 'Terjadi kesalahan saat memperbarui kategori',
            ], 500);
        }
    }

    /**
     * Pertemuan 9: DELETE category (auth:sanctum)
     */
    public function destroy(int $id)
    {
        $category = Category::find($id);

        if (! $category) {
            return response()->json([
                'message' => 'Kategori tidak ditemukan',
            ], 404);
        }

        try {
            $category->delete();

            return response()->json([
                'message' => 'Kategori berhasil dihapus',
            ], 200);
        } catch (\Exception $e) {
            Log::error('API Category destroy error', ['message' => $e->getMessage()]);

            return response()->json([
                'message' => 'Terjadi kesalahan saat menghapus kategori',
            ], 500);
        }
    }
}
