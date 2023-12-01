<?php

use App\Modules\Reservation\Presentation\Controllers\ReservationController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::get('/reservation', [ReservationController::class, 'index'])->name('reservation.index');
    Route::get('/reservation/create', [ReservationController::class, 'create'])->name('reservation.create');
    Route::post('/reservation', [ReservationController::class, 'store'])->name('reservation.store');
    Route::get('/reservation/detail/{id}', [ReservationController::class, 'detail'])->name('reservation.detail');
    Route::get('/reservation/edit/{id}', [ReservationController::class, 'edit'])->name('reservation.edit');
    Route::put('/reservation/edit/{id}', [ReservationController::class, 'update'])->name('reservation.update');
    Route::delete('/reservation/{id}', [ReservationController::class, 'destroy'])->name('reservation.destroy');
});