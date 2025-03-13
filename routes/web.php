<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CategoryController;


use Illuminate\Support\Facades\Route;

Route::get('/loginregister', function () {
    return view('welcome');
})->name('loginregister');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/', [ProductController::class, 'shop'])->name('shop');
Route::post('/cart/add/{productId}', [CartController::class, 'addToCart'])->name('cart.add');
Route::delete('/cart/{id}', [CartController::class, 'destroy'])->name('cart.remove');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth'])->group(function () {
    Route::resource('products', ProductController::class);
    Route::resource('cart', CartController::class);
    Route::resource('orders', OrderController::class);
    Route::resource('categories', CategoryController::class);
    Route::post('checkout', [OrderController::class, 'checkout'])->name('orders.checkout');
    Route::post('/cart/add/{product}', [CartController::class, 'addToCart'])->name('cart.add');

});


require __DIR__.'/auth.php';
