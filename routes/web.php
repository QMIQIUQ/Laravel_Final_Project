<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
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
    Route::get('/ProductList', [ProductController::class, 'index'])->name('showitems');

    Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->name('edit');
    Route::put('/products/{id}', [ProductController::class, 'update'])->name('update');
    Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('delete');
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
