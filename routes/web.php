<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CartController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;

// Home
Route::get('/', [ProductController::class, 'index'])->name('home');

// Auth routes (Required)
require __DIR__ . '/auth.php';

// Client Dashboard (Gha l-client)
Route::middleware(['auth'])->get('/dashboard', [ProductController::class, 'userDashboard'])->name('dashboard');

// Admin Routes (Gha l-admin)
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {


    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/commandes', [OrderController::class, 'index'])->name('commandes');

    Route::get('/produits', [ProductController::class, 'list'])->name('produits'); // admin.produits
    Route::post('/produits/store', [ProductController::class, 'store'])->name('produits.store'); // admin.produits.store
    Route::post('/commandes/{order}/valider', [App\Http\Controllers\OrderController::class, 'valider'])->name('admin.commandes.valider');
});
Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
Route::post('/order/store', [OrderController::class, 'store'])->name('order.store');
Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove'); // هادي للحدف
Route::get('/confirmation', function () {
    return "تم استلام طلبك بنجاح!"; // تقدر تبدلها بـ return view('confirmation');
})->name('confirmation');

// Profile Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
