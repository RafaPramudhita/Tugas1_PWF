<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-2 md-4">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Product List</h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Manage your product inventory</h3>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                        </div>
                        <a href="{{ route('product.create') }}"
                            class="text-sm font-bold text-gray-800 dark:text-gray-200 tracking-light">Add Product</a>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Fill in the details to add a new
                            product</p>
                    </div>

                    {{-- Flash message --}}
                    @if (session('success'))
                        <div
                            class="mb-4 p-4 bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-700 text-green-700 dark:text-green-400 rounded-lg font-sm">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div
                            class="mb-4 p-4 bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-700 text-red-700 dark:text-red-400 rounded-lg text-sm">
                            {{ session('error') }}
                        </div>
                    @endif

                    {{-- Table --}}
                    <div class="overflow-x-auto rounded-lg border border-gray-200 dark:border-gray-700">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead>
                                <tr>
                                    <th
                                        class="px-3 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-300 uppercase tracking-wider w-8">
                                        #</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Product</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Quantity</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Price</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Owner</th>
                                    <th
                                        class="px-6 py-3 text-center text-xs font-semibold text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse ($products as $product)
                                    <tr
                                        class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition duration-150">
                                        <td class="px-3 py-4 text-sm text-gray-600 dark:text-gray-300">
                                            {{ $loop->iteration }}</td>
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-3">
                                                <div
                                                    class="h-10 w-10 rounded-full bg-indigo-400 flex items-center justify-center text-white font-bold">
                                                    {{ strtoupper(substr($product->name, 0, 1)) }}
                                                </div>
                                                <div>
                                                    <p class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                                        {{ $product->name }}</p>
                                                    <p class="text-xs text-gray-500 dark:text-gray-400">
                                                        By {{ $product->user->name ?? 'Unknown' }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                {{ $product->quantity > 0 ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' : 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400' }}">
                                                {{ number_format($product->quantity, 0, ',', '.') }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-300">
                                            Rp {{ number_format($product->price, 0, ',', '.') }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-300">
                                            {{ $product->user->name ?? 'N/A' }}
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex items-center justify-center gap-2">
                                                {{-- View --}}
                                                <a href="{{ route('product.show', $product->id) }}"
                                                    class="p-1.5 rounded-md text-gray-500 dark:text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400 hover:bg-indigo-50 dark:hover:bg-indigo-900/30 transition">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-4"
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                        stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                    </svg>
                                                </a>

                                                {{-- Edit --}}
                                                @can('update', $product)
                                                <a href="{{ route('product.edit', $product) }}"
                                                    class="p-1.5 rounded-md text-gray-500 dark:text-gray-400 hover:text-amber-600 dark:hover:text-amber-400 hover:bg-amber-50 dark:hover:bg-amber-900/30 transition">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-4"
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                        stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                    </svg>
                                                </a>
                                                @endcan

                                                {{-- Delete --}}
                                                @can('delete', $product)
                                                <form action="{{ route('product.delete', $product) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('Delete this product?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="p-1.5 rounded-md text-gray-500 dark:text-gray-400 hover:text-red-600 dark:hover:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/30 transition">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-4"
                                                            fill="none" viewBox="0 0 24 24"
                                                            stroke="currentColor" stroke-width="2">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                        </svg>
                                                    </button>
                                                </form>
                                                @endcan
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    {{-- Empty --}}
                                    <tr>
                                        <td colspan="6">
                                            <div class="text-center py-8">
                                                <svg class="mx-auto h-12 w-12 text-gray-400 dark:text-gray-500"
                                                    fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="1.5"
                                                        d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                                </svg>
                                                <p
                                                    class="mt-2 text-sm text-gray-500 dark:text-gray-400 font-medium">
                                                    No products found.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Pagination --}}
                    @if ($products instanceof \Illuminate\Pagination\LengthAwarePaginator)
                        <div class="mt-4">
                            {{ $products->links() }}
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
