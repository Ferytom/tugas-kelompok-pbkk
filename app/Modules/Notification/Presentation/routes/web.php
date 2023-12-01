<?php

use App\Modules\Notification\Presentation\Controllers\NotificationController;
use Illuminate\Support\Facades\Route;

Route::middleware('staff')->group(function () {
    Route::get('/notification', [NotificationController::class, 'index'])->name('notification.index');
});