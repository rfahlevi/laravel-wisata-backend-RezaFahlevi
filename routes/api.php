<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\TicketController;
use App\Http\Controllers\Api\SummaryController;
use App\Http\Controllers\Api\TicketCategoryController;

Route::post('/login', [AuthController::class, 'login'])->name('api/login');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [AuthController::class, 'getUser'])->name('api/user');

    Route::apiResource('tickets', TicketController::class)
        ->only('index', 'store', 'update', 'destroy')
        ->names('api-tickets');

    Route::apiResource('ticket-categories', TicketCategoryController::class)
        ->only('index', 'store', 'update', 'destroy')
        ->names('api-ticket-categories');

    Route::apiResource('orders', OrderController::class)
        ->only('index', 'store')
        ->names('api-orders');

    Route::apiResource('summaries', SummaryController::class)
        ->only('index')
        ->names('api-summaries');

    Route::post('/logout', [AuthController::class, 'logout'])->name('api/logout');
});
