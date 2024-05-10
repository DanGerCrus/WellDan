<?php

use App\Http\Controllers\BasketController;
use App\Http\Controllers\FilesController;
use App\Http\Controllers\IngredientsController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductsCategoriesController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [WelcomeController::class, 'index'])->name('welcome');
Route::get('/products', [ProductsController::class, 'index'])->name('products.index');
Route::get('/products/{id}', [ProductsController::class, 'show'])
    ->whereNumber('id')
    ->name('products.show');

Route::get('{upload}', [FilesController::class, 'get'])->where('upload', '(upload\/)(.*)');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);

    Route::middleware('permission:product-edit')->group(function () {
        Route::get('/products/create', [ProductsController::class, 'create'])->name('products.create');
        Route::get('/products/{id}/edit', [ProductsController::class, 'edit'])
            ->whereNumber('id')
            ->name('products.edit');
        Route::post('/products', [ProductsController::class, 'store'])
            ->name('products.store');
        Route::patch('/products/{id}', [ProductsController::class, 'update'])
            ->whereNumber('id')
            ->name('products.update');
    });

    Route::middleware('permission:product-delete')
        ->delete('/products/{id}', [ProductsController::class, 'destroy'])
        ->whereNumber('id')
        ->name('products.destroy');
    Route::get('/basket', [BasketController::class, 'index'])->name('basket.index');
    Route::post('/products/{id}/basket', [BasketController::class, 'store'])->whereNumber('id')->name('basket.store');
    Route::patch('/basket', [BasketController::class, 'update'])->name('basket.update');

    Route::resource('categories', ProductsCategoriesController::class);
    Route::resource('ingredients', IngredientsController::class);
    Route::resource('orders', OrderController::class);
    Route::post('/orders/{id}/repeat', [OrderController::class, 'repeat'])->whereNumber('id')->name('orders.repeat');
    Route::post('/orders/{id}/cancel', [OrderController::class, 'cancel'])->whereNumber('id')->name('orders.cancel');
});

require __DIR__.'/auth.php';
