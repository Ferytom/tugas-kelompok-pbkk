<?php

use App\Modules\Member\Presentation\Controllers\MemberController;
use Illuminate\Support\Facades\Route;

Route::middleware('pemilik')->group(function () {
    Route::get('/member', [MemberController::class, 'index'])->name('member.index');
});