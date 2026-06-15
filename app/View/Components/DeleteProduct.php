<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

/**
 * Modul 7: Blade Component — Tombol Delete Product
 *
 * Component reusable untuk menampilkan tombol Delete dengan form POST
 * dan konfirmasi penghapusan. Menerima parameter dinamis:
 * - $action : URL action form delete (wajib)
 * - $label  : Teks label tombol (opsional, default 'Delete')
 * - $id     : ID product untuk identifikasi (opsional)
 */
class DeleteProduct extends Component
{
    /**
     * URL action form delete.
     */
    public string $action;

    /**
     * Label teks tombol.
     */
    public string $label;

    /**
     * ID product (opsional).
     */
    public ?int $id;

    /**
     * Create a new component instance.
     */
    public function __construct(string $action, string $label = 'Delete', ?int $id = null)
    {
        $this->action = $action;
        $this->label = $label;
        $this->id = $id;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.delete-product');
    }
}
