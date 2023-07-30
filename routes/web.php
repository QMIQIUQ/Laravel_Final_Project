<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PosController;
use Illuminate\Support\Facades\Route;;
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


//add items
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/additems', function () {
        return view('add-items');
    })->name('additems');
    Route::post('/additems', [ProductController::class, 'store'])->name('additems.store');

    //show items
    Route::get('/ProductList', [ProductController::class, 'show'])->name('showitems');

    Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->name('edit');
    Route::put('/products/{id}', [ProductController::class, 'update'])->name('update');
    Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('delete');

    // add to cart
    Route::get('/pos', [PosController::class, 'index'])->name('pos');
    Route::post('/search', [PosController::class, 'search'])->name('search');
    Route::post('/add-to-cart/{itemId}', [PosController::class, 'addToCart'])->name('addToCart');

    Route::delete('/remove-from-cart/{itemId}', [PosController::class, 'removeFromCart'])->name('removeFromCart');
    Route::post('/clear-cart', [PosController::class, 'clearCart'])->name('clearCart');
});

Route::get('/', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

//auth routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
