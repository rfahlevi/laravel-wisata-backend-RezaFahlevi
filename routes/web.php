<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\TicketCategoryController;


Route::middleware('auth')->group(function () {
    Route::get('/', function () {
        return view('pages.dashboard', ['type_menu' => 'home']);
    });

    Route::get('home', function () {
        return view('pages.dashboard', ['type_menu' => 'home']);
    })->name('home');

    // Users
    Route::resource('users', UserController::class)
        ->except(['show'])
        ->parameters(['users' => 'slug']);

    // Ticket Categories
    Route::resource('ticket-categories', TicketCategoryController::class)
        ->except(['show'])
        ->names('ticketCategories')
        ->parameters(['ticket-categories' => 'slug']);

    // Ticket
    Route::resource('tickets', TicketController::class)->parameters(['tickets' => 'slug']);
});
