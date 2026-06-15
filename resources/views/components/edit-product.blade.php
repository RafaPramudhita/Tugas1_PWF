{{-- Modul 7: Component Tombol Edit Product --}}
{{-- Parameter: $url (route tujuan), $label (teks tombol, default 'Edit') --}}
<a href="{{ $url }}"
    class="inline-flex items-center gap-1 px-3 py-2 text-sm rounded-lg border border-amber-300 dark:border-amber-600 text-amber-600 dark:text-amber-400 hover:bg-amber-50 dark:hover:bg-amber-900/20 transition"
    {{ $attributes }}>
    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
        stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round"
            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
    </svg>
    {{ $label }}
</a>
