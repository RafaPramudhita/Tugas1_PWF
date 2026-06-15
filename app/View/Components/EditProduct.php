<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

/**
 * Modul 7: Blade Component — Tombol Edit Product
 *
 * Component reusable untuk menampilkan tombol Edit yang mengarah
 * ke halaman edit product. Menerima parameter dinamis:
 * - $url  : URL tujuan edit (wajib)
 * - $label: Teks label tombol (opsional, default 'Edit')
 */
class EditProduct extends Component
{
    /**
     * URL tujuan edit product.
     */
    public string $url;

    /**
     * Label teks tombol.
     */
    public string $label;

    /**
     * Create a new component instance.
     */
    public function __construct(string $url, string $label = 'Edit')
    {
        $this->url = $url;
        $this->label = $label;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.edit-product');
    }
}
