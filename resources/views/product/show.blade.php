<x-app-layout>
    <x-slot name="header">
    </x-slot>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    {{-- Header --}}
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center gap-3">
                            <a href="{{ route('products.index') }}"
                                class="p-1.5 rounded-md text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                                </svg>
                            </a>
                        </div>
                    </div>

                    <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-200 tracking-tight">🏷️ Product Detail</h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5">All Products > #{{ $product->id }}</p>

                    {{-- Action Buttons — Modul 7: Menggunakan Blade Component --}}
                    <div class="flex items-center gap-2 mt-4">
                        @can('update', $product)
                            <x-edit-product :url="route('products.edit', $product)" />
                        @endcan

                        @can('delete', $product)
                            <x-delete-product :action="route('products.destroy', $product)" :id="$product->id" />
                        @endcan
                    </div>

                    {{-- Detail Card --}}
                    <div class="rounded-lg border border-gray-200 dark:border-gray-700 divide-y divide-gray-100 dark:divide-gray-700 mt-6">
                        <div class="flex items-center px-5 py-4">
                            <div class="w-32 shrink-0 text-sm text-gray-500 dark:text-gray-400">Product Name</div>
                            <div class="text-sm font-semibold text-gray-800 dark:text-gray-100">{{ $product->name }}</div>
                        </div>
                        <div class="flex items-start px-5 py-4">
                            <div class="w-32 shrink-0 text-sm text-gray-500 dark:text-gray-400">Description</div>
                            <div class="text-sm text-gray-800 dark:text-gray-100">{{ $product->description ?? '-' }}</div>
                        </div>
                        <div class="flex items-center px-5 py-4">
                            <div class="w-32 shrink-0 text-sm text-gray-500 dark:text-gray-400">Quantity</div>
                            <div>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $product->quantity > 0 ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' : 'bg-red-100 text-red-700 dark:bg-red-900/40 dark:text-red-400' }}">
                                    {{ $product->quantity }}
                                </span>
                                {{ $product->quantity > 0 ? 'In Stock' : 'Out of Stock' }}
                            </div>
                        </div>
                        <div class="flex items-center px-5 py-4">
                            <div class="w-32 shrink-0 text-sm text-gray-500 dark:text-gray-400">Price</div>
                            <div class="text-sm font-medium text-gray-800 dark:text-gray-100">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
                        </div>
                        <div class="flex items-center px-5 py-4">
                            <div class="w-32 shrink-0 text-sm text-gray-500 dark:text-gray-400">Owner</div>
                            <div class="flex items-center gap-2.5">
                                <div class="h-7 w-7 rounded-full bg-indigo-500 flex items-center justify-center text-white text-xs font-bold uppercase">
                                    {{ strtoupper(substr($product->user->name ?? '?', 0, 1)) }}
                                </div>
                                <span class="text-sm text-gray-800 dark:text-gray-100">{{ $product->user->name ?? '-' }}</span>
                            </div>
                        </div>
                        <div class="flex items-center px-5 py-4">
                            <div class="w-32 shrink-0 text-sm text-gray-500 dark:text-gray-400">Created At</div>
                            <div class="text-sm text-gray-800 dark:text-gray-100">{{ $product->created_at->format('d M Y, H:i') }}</div>
                        </div>
                        <div class="flex items-center px-5 py-4">
                            <div class="w-32 shrink-0 text-sm text-gray-500 dark:text-gray-400">Updated At</div>
                            <div class="text-sm text-gray-800 dark:text-gray-100">{{ $product->updated_at->format('d M Y, H:i') }}</div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
