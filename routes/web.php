<?php

use App\Http\Controllers\MenuController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PromoController;
use App\Http\Controllers\WaitlistController;
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
    return view('index');
})->name('dashboard');

Route::get('/menu', [MenuController::class, 'index'])->name('menu.index');
Route::get('/promo', [PromoController::class, 'index'])->name('promo.index');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::middleware('pemilik')->group(function () {
        Route::get('/menu/create', [MenuController::class, 'create'])->name('menu.create');
        Route::post('/menu', [MenuController::class, 'store'])->name('menu.store');
        Route::get('/menu/edit/{id}', [MenuController::class, 'edit'])->name('menu.edit');
        Route::put('/menu/edit/{id}', [MenuController::class, 'update'])->name('menu.update');
        Route::delete('/menu/{id}', [MenuController::class, 'destroy'])->name('menu.destroy');

        Route::get('/promo/create', [PromoController::class, 'create'])->name('promo.create');
        Route::post('/promo', [PromoController::class, 'store'])->name('promo.store');
        Route::get('/promo/edit/{id}', [PromoController::class, 'edit'])->name('promo.edit');
        Route::put('/promo/edit/{id}', [PromoController::class, 'update'])->name('promo.update');
        Route::delete('/promo/{id}', [PromoController::class, 'destroy'])->name('promo.destroy');
    });    

    Route::middleware('staff')->group(function () {
        Route::get('/waitlist', [WaitlistController::class, 'index'])->name('waitlist.index');
        Route::get('/waitlist/create', [WaitlistController::class, 'create'])->name('waitlist.create');
        Route::post('/waitlist', [WaitlistController::class, 'store'])->name('waitlist.store');
        Route::delete('/waitlist/{id}', [WaitlistController::class, 'destroy'])->name('waitlist.destroy');
    });
});

require __DIR__.'/auth.php';
