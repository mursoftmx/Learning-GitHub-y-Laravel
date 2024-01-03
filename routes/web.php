<?php

use App\Http\Controllers\MainController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductCartController;
use App\Http\Controllers\OrderPaymentController;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProfileController;



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

Route::get('/', [MainController::class, 'index'])->name('main');

Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');

Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');

Route::resource('products.carts', ProductCartController::class)->only(['store','destroy']);

Route::resource('carts', CartController::class)->only(['index']);

Route::resource('orders', OrderController::class)
    ->middleware(['verified'])
    ->only(['create','store']);

Route::resource('orders.payments', OrderPaymentController::class)
    ->middleware(['verified'])
    ->only(['store','create']);

// Route::get('/products', [ProductController::class, 'index'])->name('products.index');

// Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');

// Route::post('/products', [ProductController::class, 'store'])->name('products.store');

// Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');

// Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');

// Route::match(['put', 'patch'], '/products/{product}', [ProductController::class, 'update'])->name('products.update');

// Route::delete('/products/{product:title}', [ProductController::class, 'destroy'])->name('products.destroy');


Auth::routes([
    'verify' => true,
    // 'reset' => false,
]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
