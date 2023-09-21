<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\FrontController;
use Inertia\Inertia;
use Illuminate\Support\Facades\Route;

Route::get('/', [FrontController::class, 'home'])->name('product.home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::post('/addCart', [FrontController::class, 'addCart'])->name('product.addCart');
});


Route::middleware(['auth', 'verified'])->get('/shopping-cart', [CartController::class, 'shopping_cart'])->name('product.shopping_cart');
