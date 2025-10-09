<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\LoginController;

Route::get('/', function () {
    if (!Auth::check()) {
        return redirect()->route('login');
    }
    return view('dashboard');
});

// === LOGIN ROUTES ===
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// === PROTECTED ROUTES ===
Route::middleware('auth')->group(function () {
    Route::resource('products', ProductController::class);
    Route::resource('users', UserController::class);
    Route::get('transactions', [TransactionController::class, 'index'])->name('transactions.index');
    Route::get('transactions/create', [TransactionController::class, 'create'])->name('transactions.create');
    Route::post('transactions', [TransactionController::class, 'store'])->name('transactions.store');
    Route::get('transactions/report', [TransactionController::class, 'report'])->name('transactions.report');
    Route::resource('settings', SettingController::class)->only(['index', 'update']);
    Route::get('/transactions/report/pdf', [TransactionController::class, 'downloadPdf'])
    ->name('transactions.report.pdf');
});
