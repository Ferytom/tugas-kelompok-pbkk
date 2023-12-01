<?php

use App\Modules\Promo\Presentation\Controllers\PromoController;
use Illuminate\Support\Facades\Route;

Route::get('/promo', [PromoController::class, 'index'])->name('promo.index');

Route::middleware('pemilik')->group(function () {
    Route::get('/promo/create', [PromoController::class, 'create'])->name('promo.create');
    Route::post('/promo', [PromoController::class, 'store'])->name('promo.store');
    Route::get('/promo/edit/{id}', [PromoController::class, 'edit'])->name('promo.edit');
    Route::put('/promo/edit/{id}', [PromoController::class, 'update'])->name('promo.update');
    Route::delete('/promo/{id}', [PromoController::class, 'destroy'])->name('promo.destroy');
});