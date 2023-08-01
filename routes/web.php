<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PosController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\RegisteredUserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SalesReportController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PDFController;

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



//admin
Route::middleware(['auth', 'verified', 'admin'])->group(function () {
    // Show all products
    Route::get('/ProductList', [ProductController::class, 'show'])->name('showitems');
    Route::get('/additems', function () {
        return view('add-items');
    })->name('additems');
    Route::post('/additems', [ProductController::class, 'store'])->name('additems.store');

    //show items
    Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->name('edit');
    Route::put('/products/{id}', [ProductController::class, 'update'])->name('update');
    Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('delete');
});


Route::middleware(['auth', 'verified', 'admin'])->group(function () {
    // Show all users
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    // admin user registration
    Route::get('/register-admin', [RegisteredUserController::class, 'createAdmin'])->name('register.admin');
    Route::post('/register-admin', [RegisteredUserController::class, 'storeAdmin'])->name('register.admin.store');
    // admin user profile edit
    Route::get('/edit-admin/{id}', [UserController::class, 'editAdmin'])->name('edit-admin');
    Route::patch('/update-admin/{id}', [UserController::class, 'updateUserInformation'])->name('updateUser');
    Route::delete('/delete-user/{id}', [UserController::class, 'deleteUser'])->name('deleteUser');
    Route::patch('/users/{id}/change-password', 'UserController@changePassword')->name('users.change-password');


    Route::get('/sales', [SalesReportController::class, 'index'])->name('sales.index');
});

//add items
Route::middleware(['auth', 'verified'])->group(function () {


    // cart
    Route::get('/pos', [PosController::class, 'index'])->name('pos');
    Route::post('/search', [PosController::class, 'search'])->name('search');
    Route::post('/add-to-cart/{itemId}', [PosController::class, 'addToCart'])->name('addToCart');
    Route::delete('/remove-from-cart/{itemId}', [PosController::class, 'removeFromCart'])->name('removeFromCart');
    Route::post('/clear-cart', [PosController::class, 'clearCart'])->name('clearCart');
    Route::post('your/route/for/checkout', [PosController::class, 'checkout'])->name('checkout');
    //orders
    Route::get('/orders', [OrderController::class, 'index'])->name('orders');
    Route::get('/orders/{id}', [OrderController::class, 'show'])->name('order.details');
    Route::get('/download-pdf/{order}', [PDFController::class, 'generatePDF'])->name('download.pdf');


//dashboard
    Route::get('/getTotalSalesByMonth', [DashboardController::class, 'getTotalSalesByMonth'])->name('getTotalSalesByMonth');
    Route::get('/getTotalSalesByDay', [DashboardController::class, 'getTotalSalesByDay'])->name('getTotalSalesByDay');
});





//home

Route::get('/', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/getTotalSalesByMonth', [DashboardController::class, 'getTotalSalesByMonth'])->name('getTotalSalesByMonth');

//auth routes
Route::middleware('auth','admin')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
