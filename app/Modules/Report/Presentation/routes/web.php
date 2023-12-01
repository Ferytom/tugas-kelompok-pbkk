<?php

use App\Modules\Report\Presentation\Controllers\ReportController;
use Illuminate\Support\Facades\Route;

Route::middleware('pemilik')->group(function () {
    Route::get('/report', [ReportController::class, 'index'])->name('report.index');
    Route::get('/report/daily', [ReportController::class, 'daily'])->name('report.daily');
    Route::get('/report/monthly', [ReportController::class, 'monthly'])->name('report.monthly');
    Route::get('/report/misc', [ReportController::class, 'misc'])->name('report.misc');
});    