<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Models\Category;
use App\Http\Controllers\ProductController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('categories')->group(function () {
    Route::get('list_categories', [CategoryController::class, 'list_categories'])->name('list_categories');
    Route::post('add_category', [CategoryController::class, 'store'])->name('add_category');
    Route::put('edit_category/{id}', [CategoryController::class, 'update'])->name('edit_category');
    Route::delete('{id}', [CategoryController::class, 'destroy'])->name('destroy_category');
});

Route::prefix('products')->group(function () {
    Route::get('list_products', [ProductController::class, 'list_products'])->name('list_products');
    Route::post('add_product', [ProductController::class, 'store'])->name('add_products');
    Route::put('edit_product/{id}', [ProductController::class, 'update'])->name('edit_product');
    Route::delete('{id}', [ProductController::class, 'destroy'])->name('destroy_product');
});
