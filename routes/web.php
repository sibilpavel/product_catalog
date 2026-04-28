<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ProductController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Inertia Pages (Frontend Pages)
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return Inertia::render('Home');
})->name('home');

Route::get('/login', function () {
    return Inertia::render('Login');
})->name('login');

Route::get('/product/{id}', function ($id) {
    return Inertia::render('ProductShow', [
        'productId' => $id,
    ]);
})->name('product.show');

Route::get('/admin/products', function () {
    return Inertia::render('Admin/Products/Index');
})->name('admin.products.index');

Route::get('/admin/products/create', function () {
    return Inertia::render('Admin/Products/Create');
})->name('admin.products.create');

Route::get('/admin/products/{id}/edit', function ($id) {
    return Inertia::render('Admin/Products/Edit', [
        'productId' => $id,
    ]);
})->name('admin.products.edit');


/*
|--------------------------------------------------------------------------
| Public API Routes
|--------------------------------------------------------------------------
*/

Route::post('/api/login', [AuthController::class, 'login']);

Route::get('/api/categories', [CategoryController::class, 'index']);

Route::apiResource('api/products', ProductController::class)
    ->only(['index', 'show']);


/*
|--------------------------------------------------------------------------
| Protected API Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/api/logout', [AuthController::class, 'logout']);

    Route::apiResource('api/products', ProductController::class)
        ->only(['store', 'update', 'destroy']);
});
