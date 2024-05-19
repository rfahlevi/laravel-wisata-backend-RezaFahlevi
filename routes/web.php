<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TicketCategoryController;

Route::get('/', function () {
    return view('pages.auth.login');
});

Route::middleware('auth')->group(function() {
    Route::get('home', function() {
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
    });

