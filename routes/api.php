<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Models\Category;

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
    // Route::get('/json-data', function () {
    //     return Category::paginate();
    // });
});
