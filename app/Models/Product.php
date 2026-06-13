<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'description',
        'quantity',
        'price',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi: Product hasMany Kategori (Modul 3)
     */
    public function kategoris()
    {
        return $this->hasMany(Kategori::class);
    }
}
