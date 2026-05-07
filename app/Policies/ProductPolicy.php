<?php

namespace App\Policies;

use App\Models\Product;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ProductPolicy
{
    /**
     * Determine whether the user can view any models.
     * Modul 5: Terbuka untuk semua user terautentikasi.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     * Modul 5: Terbuka untuk semua user terautentikasi.
     */
    public function view(User $user, Product $product): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     * Modul 5: Terbuka untuk semua user terautentikasi.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     * Modul 5: HANYA admin ATAU pemilik data (user_id cocok) yang bisa mengupdate.
     */
    public function update(User $user, Product $product): bool
    {
        return $user->role === 'admin' || $user->id === $product->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     * Modul 5: HANYA admin ATAU pemilik data (user_id cocok) yang bisa menghapus.
     */
    public function delete(User $user, Product $product): bool
    {
        return $user->role === 'admin' || $user->id === $product->user_id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Product $product): bool
    {
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Product $product): bool
    {
        return $user->role === 'admin';
    }
}
