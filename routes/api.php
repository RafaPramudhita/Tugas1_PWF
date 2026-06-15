<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController as CategoryApiController;
use App\Http\Controllers\Api\ProductController as ProductApiController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Pertemuan 9: API Routes
|--------------------------------------------------------------------------
|
| Route API untuk Product dan Category CRUD.
| Autentikasi menggunakan Laravel Sanctum (Bearer Token).
|
*/

// Login API — menghasilkan access_token
Route::post('/login', [AuthController::class, 'getToken']);

// Product API
// GET index & show bersifat public
Route::get('/product', [ProductApiController::class, 'index']);
Route::get('/product/{id}', [ProductApiController::class, 'show']);

// POST, PUT, DELETE memerlukan auth:sanctum
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/product', [ProductApiController::class, 'store']);
    Route::put('/product/{id}', [ProductApiController::class, 'update']);
    Route::delete('/product/{id}', [ProductApiController::class, 'destroy']);
});

// Category API — semua endpoint memerlukan auth:sanctum
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/category', [CategoryApiController::class, 'index']);
    Route::post('/category', [CategoryApiController::class, 'store']);
    Route::get('/category/{id}', [CategoryApiController::class, 'show']);
    Route::put('/category/{id}', [CategoryApiController::class, 'update']);
    Route::delete('/category/{id}', [CategoryApiController::class, 'destroy']);
});
