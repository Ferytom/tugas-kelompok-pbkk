<?php

use App\Modules\Location\Presentation\Controllers\LocationController;
use Illuminate\Support\Facades\Route;

Route::middleware('pemilik')->group(function () {
    Route::get('/location', [LocationController::class, 'index'])->name('location.index');
    Route::get('/location/create', [LocationController::class, 'create'])->name('location.create');
    Route::post('/location', [LocationController::class, 'store'])->name('location.store');
    Route::get('/location/edit/{id}', [LocationController::class, 'edit'])->name('location.edit');
    Route::put('/location/edit/{id}', [LocationController::class, 'update'])->name('location.update');
    Route::delete('/location/{id}', [LocationController::class, 'destroy'])->name('location.destroy');
});