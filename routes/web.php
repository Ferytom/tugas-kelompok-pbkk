<?php

use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PromoController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\TransactionController;
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

    Route::get('/reservation', [ReservationController::class, 'index'])->name('reservation.index');
    Route::get('/reservation/create', [ReservationController::class, 'create'])->name('reservation.create');
    Route::post('/reservation', [ReservationController::class, 'store'])->name('reservation.store');
    Route::get('/reservation/detail/{id}', [ReservationController::class, 'detail'])->name('reservation.detail');
    Route::get('/reservation/edit/{id}', [ReservationController::class, 'edit'])->name('reservation.edit');
    Route::put('/reservation/edit/{id}', [ReservationController::class, 'update'])->name('reservation.update');
    Route::delete('/reservation/{id}', [ReservationController::class, 'destroy'])->name('reservation.destroy');

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

        Route::get('/member', [MemberController::class, 'index'])->name('member.index');

        Route::get('/employee', [EmployeeController::class, 'index'])->name('employee.index');
        Route::get('/employee/create', [EmployeeController::class, 'create'])->name('employee.create');
        Route::post('/employee', [EmployeeController::class, 'store'])->name('employee.store');
        Route::get('/employee/edit/{id}', [EmployeeController::class, 'edit'])->name('employee.edit');
        Route::put('/employee/edit/{id}', [EmployeeController::class, 'update'])->name('employee.update');
        Route::delete('/employee/{id}', [EmployeeController::class, 'destroy'])->name('employee.destroy');

        Route::get('/report', [ReportController::class, 'index'])->name('report.index');
        Route::get('/report/daily', [ReportController::class, 'daily'])->name('report.daily');
        Route::get('/report/monthly', [ReportController::class, 'monthly'])->name('report.monthly');
        Route::get('/report/misc', [ReportController::class, 'misc'])->name('report.misc');
    });    

    Route::middleware('staff')->group(function () {
        Route::get('/waitlist', [WaitlistController::class, 'index'])->name('waitlist.index');
        Route::get('/waitlist/create', [WaitlistController::class, 'create'])->name('waitlist.create');
        Route::post('/waitlist', [WaitlistController::class, 'store'])->name('waitlist.store');
        Route::delete('/waitlist/{id}', [WaitlistController::class, 'destroy'])->name('waitlist.destroy');

        Route::get('/transaction', [TransactionController::class, 'index'])->name('transaction.index');
        Route::get('/transaction/create', [TransactionController::class, 'create'])->name('transaction.create');
        Route::post('/transaction', [TransactionController::class, 'store'])->name('transaction.store');
        Route::get('/transaction/detail/{id}', [TransactionController::class, 'detail'])->name('transaction.detail');
        Route::get('/transaction/edit/{id}', [TransactionController::class, 'edit'])->name('transaction.edit');
        Route::put('/transaction/edit/{id}', [TransactionController::class, 'update'])->name('transaction.update');
        Route::delete('/transaction/{id}', [TransactionController::class, 'destroy'])->name('transaction.destroy');

        Route::get('/notification', [NotificationController::class, 'index'])->name('notification.index');
    });
});

require __DIR__.'/auth.php';
