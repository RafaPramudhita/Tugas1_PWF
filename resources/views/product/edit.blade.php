<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-2 md-4">
            <a href="{{ route('product.index') }}"
                class="text-lg font-bold text-gray-800 dark:text-gray-200 hover:text-gray-600 dark:hover:text-gray-400 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
            <span class="text-sm text-gray-500">|</span>
        </div>
        <div>
            <h2 class="text-xl font-bold text-gray-800 dark:text-gray-200 tracking-light">Edit Product</h2>
            <p class="text-sm text-gray-600 dark:text-gray-400">Update details for <em>{{ $product->name }}</em></p>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    {{-- Flash Messages --}}
                    @if (session('error'))
                        <div class="mb-4 p-4 bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-700 text-red-700 dark:text-red-400 rounded-lg text-sm">
                            {{ session('error') }}
                        </div>
                    @endif

                    {{-- Validation Errors Summary --}}
                    @if ($errors->any())
                        <div class="mb-4 p-4 bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-700 rounded-lg">
                            <div class="flex items-center gap-2 mb-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <h4 class="text-sm font-semibold text-red-700 dark:text-red-400">Terdapat kesalahan pada input:</h4>
                            </div>
                            <ul class="list-disc list-inside text-sm text-red-600 dark:text-red-400 space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form id="edit-product-form" action="{{ route('product.update', $product->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        {{-- Name --}}
                        <div>
                            <x-input-label for="name"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1" />
                            <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Name</label>

                            <input type="text" id="name" name="name"
                                value="{{ old('name', $product->name) }}" placeholder="e.g. Wireless Headphones"
                                class="w-full px-4 py-2.5 rounded-lg border text-sm
                                {{ $errors->has('name') ? 'border-red-400 bg-red-50 dark:bg-red-900/20' : 'border-gray-300 dark:border-gray-600 dark:bg-gray-800 bg-white dark:bg-gray-700' }}
                                text-gray-900 dark:text-gray-100 placeholder-gray-400 dark:placeholder-gray-500
                                focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition" />

                            @error('name')
                                <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Quantity & Price --}}
                        <div class="grid grid-cols-1 gap-4 md:grid-cols-2 mt-4">
                            <div>
                                <x-input-label for="quantity"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1" />
                                <label class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Quantity <span class="text-red-500">*</span></label>

                                <input type="number" id="quantity" name="quantity"
                                    value="{{ old('quantity', $product->quantity) }}" placeholder="0" min="0"
                                    class="w-full px-4 py-2.5 rounded-lg border text-sm
                                    {{ $errors->has('quantity') ? 'border-red-300 dark:border-red-500/50 bg-red-50/80' : 'border-gray-300 dark:border-gray-600 dark:bg-gray-800 bg-white dark:bg-gray-700' }}
                                    text-gray-900 dark:text-gray-100 placeholder-gray-400 dark:placeholder-gray-500
                                    focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition" />

                                @error('quantity')
                                    <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <x-input-label for="price"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1" />
                                <label class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Price (Rp) <span class="text-red-500">*</span></label>

                                <input type="number" id="price" name="price"
                                    value="{{ old('price', $product->price) }}" placeholder="0" min="0"
                                    class="w-full px-4 py-2.5 rounded-lg border text-sm
                                    {{ $errors->has('price') ? 'border-red-300 dark:border-red-500/50 bg-red-50/80' : 'border-gray-300 dark:border-gray-600 dark:bg-gray-800 bg-white dark:bg-gray-700' }}
                                    text-gray-900 dark:text-gray-100 placeholder-gray-400 dark:placeholder-gray-500
                                    focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition" />

                                @error('price')
                                    <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        {{-- User --}}
                        <div class="mt-4">
                            <x-input-label for="user_id"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1" />
                            <label class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                User <span class="text-red-500">*</span></label>

                            <select id="user_id" name="user_id"
                                class="w-full px-4 py-2.5 rounded-lg border text-sm
                                {{ $errors->has('user_id') ? 'border-red-400 bg-red-50 dark:bg-red-900/20' : 'border-gray-300 dark:border-gray-600 dark:bg-gray-800 bg-white dark:bg-gray-700' }}
                                text-gray-900 dark:text-gray-100
                                focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
                                <option value="">-- Select User --</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}"
                                        {{ old('user_id', $product->user_id) == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>

                            @error('user_id')
                                <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Actions --}}
                        <div class="flex items-center justify-end gap-3 pt-6">
                            <a href="{{ route('product.index') }}"
                                class="px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 text-sm font-medium text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                                Cancel
                            </a>
                            <button type="submit"
                                class="px-6 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg shadow-sm transition">
                                Update Product
                            </button>
                        </div>

                    </form>

                    {{-- Delete Section --}}
                    @can('delete', $product)
                    <div class="mt-8">
                        <div class="flex items-center gap-4">
                            <div>
                                <h3 class="text-base font-medium text-gray-700 dark:text-gray-300">Delete Product</h3>
                                <p class="text-xs text-gray-500 dark:text-gray-400">This action cannot be undone</p>
                            </div>
                        </div>

                        <form action="{{ route('product.delete', $product->id) }}" method="POST"
                            onsubmit="return confirm('Are you sure you want to delete this product?');"
                            class="mt-3">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="inline-flex items-center gap-1 px-3 py-2 text-sm text-red-600 rounded-lg hover:bg-red-50 dark:hover:bg-red-900/20 hover:text-red-700 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                                Delete Product
                            </button>
                        </form>
                    </div>
                    @endcan

                    {{-- Store Product Link --}}
                    <div class="mt-6">
                        <div class="flex items-center gap-4">
                            <a href="{{ route('product.create') }}"
                                class="px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 text-sm font-medium text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                                Store Product
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
