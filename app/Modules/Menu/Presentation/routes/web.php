<?php

use App\Modules\Menu\Presentation\Controllers\MenuController;
use Illuminate\Support\Facades\Route;

Route::get('/menu', [MenuController::class, 'index'])->name('menu.index');

Route::middleware('pemilik')->group(function () {
    Route::get('/menu/create', [MenuController::class, 'create'])->name('menu.create');
    Route::post('/menu', [MenuController::class, 'store'])->name('menu.store');
    Route::get('/menu/edit/{id}', [MenuController::class, 'edit'])->name('menu.edit');
    Route::put('/menu/edit/{id}', [MenuController::class, 'update'])->name('menu.update');
    Route::delete('/menu/{id}', [MenuController::class, 'destroy'])->name('menu.destroy');
});