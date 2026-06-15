<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\QueryException;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     * Modul 4: CRUD - index
     */
    public function index()
    {
        $products = Product::with(['user', 'category'])->latest()->get();

        return view('product.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     * Modul 4: CRUD - create
     */
    public function create()
    {
        $users = User::orderBy('name')->get();
        $categories = Category::orderBy('name')->get();

        return view('product.create', compact('users', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     * Modul 4: CRUD - store
     * Modul 6: Validasi input (name, description, price, quantity)
     */
    public function store(Request $request)
    {
        // Modul 6: Validasi Input
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'required|string',
            'price'       => 'required|numeric|min:0',
            'quantity'    => 'required|integer|min:0',
            'category_id' => 'required|exists:category,id',
        ], [
            'name.required'        => 'Nama produk wajib diisi.',
            'name.string'          => 'Nama produk harus berupa teks.',
            'name.max'             => 'Nama produk tidak boleh lebih dari 255 karakter.',

            'description.required' => 'Deskripsi produk wajib diisi.',
            'description.string'   => 'Deskripsi produk harus berupa teks.',

            'price.required'       => 'Harga produk wajib diisi.',
            'price.numeric'        => 'Harga produk harus berupa angka yang valid.',
            'price.min'            => 'Harga produk tidak boleh kurang dari 0.',

            'quantity.required'    => 'Stok produk wajib diisi.',
            'quantity.integer'     => 'Stok produk harus berupa angka bulat.',
            'quantity.min'         => 'Stok produk tidak boleh kurang dari 0.',

            'category_id.required' => 'Kategori wajib dipilih.',
            'category_id.exists'   => 'Kategori yang dipilih tidak valid.',
        ]);

        // Set user_id otomatis dari user yang sedang login
        $validated['user_id'] = Auth::id();

        try {
            Product::create($validated);

            return redirect()
                ->route('products.index')
                ->with('success', 'Produk berhasil ditambahkan.');
        } catch (QueryException $e) {
            Log::error('Product store database error', [
                'message' => $e->getMessage(),
            ]);

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan database saat menyimpan produk.');
        } catch (\Throwable $e) {
            Log::error('Product store unexpected error', [
                'message' => $e->getMessage(),
            ]);

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan yang tidak terduga.');
        }
    }

    /**
     * Display the specified resource.
     * Modul 4: CRUD - show (Route Model Binding)
     */
    public function show(Product $product)
    {
        $product->load(['user', 'category']);

        return view('product.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     * Modul 4: CRUD - edit (Route Model Binding)
     * Modul 5: Policy authorization
     */
    public function edit(Product $product)
    {
        // Modul 5: Otorisasi — hanya admin atau pemilik data yang bisa edit
        $this->authorize('update', $product);

        $users = User::orderBy('name')->get();
        $categories = Category::orderBy('name')->get();

        return view('product.edit', compact('product', 'users', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     * Modul 4: CRUD - update (Route Model Binding)
     * Modul 5: Policy authorization
     * Modul 6: Validasi input (name, description, price, quantity)
     */
    public function update(Request $request, Product $product)
    {
        // Modul 5: Otorisasi — hanya admin atau pemilik data yang bisa update
        $this->authorize('update', $product);

        // Modul 6: Validasi Input
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'required|string',
            'price'       => 'required|numeric|min:0',
            'quantity'    => 'required|integer|min:0',
            'category_id' => 'required|exists:category,id',
        ], [
            'name.required'        => 'Nama produk wajib diisi.',
            'name.string'          => 'Nama produk harus berupa teks.',
            'name.max'             => 'Nama produk tidak boleh lebih dari 255 karakter.',

            'description.required' => 'Deskripsi produk wajib diisi.',
            'description.string'   => 'Deskripsi produk harus berupa teks.',

            'price.required'       => 'Harga produk wajib diisi.',
            'price.numeric'        => 'Harga produk harus berupa angka yang valid.',
            'price.min'            => 'Harga produk tidak boleh kurang dari 0.',

            'quantity.required'    => 'Stok produk wajib diisi.',
            'quantity.integer'     => 'Stok produk harus berupa angka bulat.',
            'quantity.min'         => 'Stok produk tidak boleh kurang dari 0.',

            'category_id.required' => 'Kategori wajib dipilih.',
            'category_id.exists'   => 'Kategori yang dipilih tidak valid.',
        ]);

        try {
            $product->update($validated);

            return redirect()
                ->route('products.index')
                ->with('success', 'Produk berhasil diperbarui.');
        } catch (QueryException $e) {
            Log::error('Product update database error', [
                'message' => $e->getMessage(),
            ]);

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan database saat memperbarui produk.');
        } catch (\Throwable $e) {
            Log::error('Product update unexpected error', [
                'message' => $e->getMessage(),
            ]);

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan yang tidak terduga.');
        }
    }

    /**
     * Remove the specified resource from storage.
     * Modul 4: CRUD - destroy (Route Model Binding)
     * Modul 5: Policy authorization
     */
    public function destroy(Product $product)
    {
        // Modul 5: Otorisasi — hanya admin atau pemilik data yang bisa hapus
        $this->authorize('delete', $product);

        $product->delete();

        return redirect()
            ->route('products.index')
            ->with('success', 'Produk berhasil dihapus.');
    }

    /**
     * Export all products as CSV.
     * Modul 5: Fitur export, dilindungi Gate 'export-product' (hanya admin).
     */
    public function export(): StreamedResponse
    {
        $products = Product::with('user')->latest()->get();

        $fileName = 'products_export_' . date('Y-m-d_His') . '.csv';

        $response = new StreamedResponse(function () use ($products) {
            $handle = fopen('php://output', 'w');

            // Header CSV
            fputcsv($handle, ['No', 'Nama Produk', 'Deskripsi', 'Quantity', 'Harga', 'Pemilik', 'Dibuat']);

            foreach ($products as $index => $product) {
                fputcsv($handle, [
                    $index + 1,
                    $product->name,
                    $product->description ?? '-',
                    $product->quantity,
                    $product->price,
                    $product->user->name ?? 'N/A',
                    $product->created_at->format('d/m/Y H:i'),
                ]);
            }

            fclose($handle);
        });

        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', 'attachment; filename="' . $fileName . '"');

        return $response;
    }
}
