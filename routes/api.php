<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\TransactionController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\ReportController;

Route::post('/login', [UserController::class, 'login']);
Route::post('/register', [UserController::class, 'register']);

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('products', ProductController::class);
    Route::apiResource('transactions', TransactionController::class);
    Route::apiResource('users', UserController::class)->except(['store']); // store via register
    Route::get('reports/sales', [ReportController::class, 'sales']);
    Route::post('/logout', [UserController::class, 'logout']);
});
