<?php

use App\Modules\Waitlist\Presentation\Controllers\WaitlistController;
use Illuminate\Support\Facades\Route;

Route::middleware('staff')->group(function () {
    Route::get('/waitlist', [WaitlistController::class, 'index'])->name('waitlist.index');
    Route::get('/waitlist/create', [WaitlistController::class, 'create'])->name('waitlist.create');
    Route::post('/waitlist', [WaitlistController::class, 'store'])->name('waitlist.store');
    Route::delete('/waitlist/{id}', [WaitlistController::class, 'destroy'])->name('waitlist.destroy');
});