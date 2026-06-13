<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    protected $fillable = [
        'product_id',
        'name',
    ];

    /**
     * Relasi: Kategori belongsTo Product (Modul 3)
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
