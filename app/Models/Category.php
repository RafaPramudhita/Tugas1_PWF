<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    /**
     * Nama tabel yang digunakan oleh model.
     * UCP 1: Menggunakan tabel 'category'
     */
    protected $table = 'category';

    protected $fillable = [
        'name',
    ];

    /**
     * Relasi: Category hasMany Product (UCP 1)
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
