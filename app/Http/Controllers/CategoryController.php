<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;

class CategoryController extends Controller
{
    /**
     * Display a listing of categories.
     * UCP 1: Index menampilkan nama category + total product
     */
    public function index()
    {
        $categories = Category::withCount('products')->latest()->get();

        return view('category.index', compact('categories'));
    }

    /**
     * Show the form for creating a new category.
     */
    public function create()
    {
        return view('category.create');
    }

    /**
     * Store a newly created category in storage.
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
            Category::create($validated);

            return redirect()
                ->route('categories.index')
                ->with('success', 'Kategori berhasil ditambahkan.');
        } catch (QueryException $e) {
            Log::error('Category store database error', [
                'message' => $e->getMessage(),
            ]);

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan database saat menyimpan kategori.');
        }
    }

    /**
     * Show the form for editing the specified category.
     */
    public function edit(Category $category)
    {
        return view('category.edit', compact('category'));
    }

    /**
     * Update the specified category in storage.
     */
    public function update(Request $request, Category $category)
    {
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

            return redirect()
                ->route('categories.index')
                ->with('success', 'Kategori berhasil diperbarui.');
        } catch (QueryException $e) {
            Log::error('Category update database error', [
                'message' => $e->getMessage(),
            ]);

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan database saat memperbarui kategori.');
        }
    }

    /**
     * Remove the specified category from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()
            ->route('categories.index')
            ->with('success', 'Kategori berhasil dihapus.');
    }
}
