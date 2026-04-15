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
            <h2 class="text-xl font-bold text-gray-800 dark:text-gray-200 tracking-light">Add Product</h2>
            <p class="text-sm text-gray-600 dark:text-gray-400">Fill in the details to add a new
                product</p>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    {{-- Form --}}
                    <form action="{{ route('product.store') }}" method="POST" class="space-y-6">
                        @csrf

                        {{-- Name --}}
                        <div>
                            <x-input-label for="name"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1" />
                            <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Name</label>

                            <input type="text" id="name" name="name" value="{{ old('name') }}"
                                placeholder="e.g. Wireless Headphones"
                                class="w-full px-4 py-2.5 rounded-lg border text-sm
                                {{ $errors->has('name') ? 'border-red-300 focus:ring-red-500 dark:bg-red-900/10' : 'border-gray-300 dark:border-gray-600 dark:bg-gray-800 bg-white dark:bg-gray-700' }}
                                text-gray-900 dark:text-gray-100 placeholder-gray-400 dark:placeholder-gray-500
                                focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition" />

                            @error('name')
                                <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Quantity & Price --}}
                        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                            <div>
                                <x-input-label for="quantity"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1" />
                                <label class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Quantity <span class="text-red-500">*</span></label>

                                <input type="number" id="quantity" name="quantity" value="{{ old('quantity') }}"
                                    min="0" placeholder="0"
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

                                <input type="number" id="price" name="price" value="{{ old('price') }}"
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
                        <div>
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
                                        {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>

                            @error('user_id')
                                <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Actions --}}
                        <div class="flex items-center justify-end gap-3 pt-2">
                            <a href="{{ route('product.index') }}"
                                class="px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 text-sm font-medium text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                                Cancel
                            </a>
                            <button type="submit"
                                class="px-6 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg shadow-sm transition">
                                Save Product
                            </button>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
