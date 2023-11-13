<?php

use App\Http\Controllers\AdminAlertController;
use App\Http\Controllers\AdminCategoryController;
use App\Http\Controllers\AdminProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProfileController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('/dashboard', 'dashboard')->name('dashboard');
    Route::view('/about', 'about')->name('about');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/cart', [CartController::class, 'index'])->name('cart');
    //Route::get('/product/{product}', [ProductController::class, 'show'])->name('product.detail');

    Route::prefix('admin')->middleware('admin')->group(function () {
        Route::view('/dashboard', 'admin.dashboard')->name('admin.dashboard');
        Route::view('/ecommerce', 'admin.ecommerce')->name('admin.ecommerce');
        Route::get('/alert', [AdminAlertController::class, 'index'])->name('admin.alert');
        Route::view('/email', 'admin.email')->name('admin.email');
        Route::get('/cart', [CartController::class, 'index'])->name('admin.cart');
        Route::get('/cart/filter', [CartController::class, 'filter'])->name('admin.cart.filter');
        

        Route::resource('categories', AdminCategoryController::class, [
            'names' => [
                'index' => 'admin.categories.index',
                'create' => 'admin.categories.create',
                'store' => 'admin.categories.store',
                'edit' => 'admin.categories.edit',
                'update' => 'admin.categories.update',
                'destroy' => 'admin.categories.destroy',
            ]
        ])->except(['show']);

        Route::resource('products', AdminProductController::class, [
            'names' => [
                'index' => 'admin.products.index',
                'create' => 'admin.products.create',
                'store' => 'admin.products.store',
                'show' => 'admin.products.show',
                'edit' => 'admin.products.edit',
                'update' => 'admin.products.update',
                'destroy' => 'admin.products.destroy',
            ]
        ]);
    });
});

require __DIR__ . '/auth.php';
