<?php

namespace App\Providers;

use Dedoc\Scramble\Scramble;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Gate: hanya admin yang bisa mengelola product
        Gate::define('manage-product', function ($user) {
            return $user->role === 'admin';
        });

        // Modul 5 (Kelas B): Gate export-product — hanya admin yang boleh export
        Gate::define('export-product', function ($user) {
            return $user->role === 'admin';
        });

        // UCP 1: Gate manage-category — hanya admin yang boleh mengelola Category
        Gate::define('manage-category', function ($user) {
            return $user->role === 'admin';
        });

        // Pertemuan 9: Gate untuk melihat dokumentasi API Scramble
        Gate::define('viewApiDocs', function () {
            return true;
        });

        // Pertemuan 9: Konfigurasi Scramble — route api/* masuk dokumentasi
        Scramble::configure()->routes(function (Route $route) {
            return str_starts_with($route->uri, 'api/');
        });
    }
}
