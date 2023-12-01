<?php

use App\Modules\Transaction\Presentation\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

Route::middleware('staff')->group(function () {
    Route::get('/transaction', [TransactionController::class, 'index'])->name('transaction.index');
    Route::get('/transaction/create', [TransactionController::class, 'create'])->name('transaction.create');
    Route::post('/transaction', [TransactionController::class, 'store'])->name('transaction.store');
    Route::get('/transaction/detail/{id}', [TransactionController::class, 'detail'])->name('transaction.detail');
    Route::get('/transaction/edit/{id}', [TransactionController::class, 'edit'])->name('transaction.edit');
    Route::put('/transaction/edit/{id}', [TransactionController::class, 'update'])->name('transaction.update');
    Route::delete('/transaction/{id}', [TransactionController::class, 'destroy'])->name('transaction.destroy');
});
