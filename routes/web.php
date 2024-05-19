<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('pages.auth.login');
});

Route::middleware('auth')->group(function() {
    Route::get('home', function() {
        return view('pages.dashboard', ['type_menu' => 'dashboard']);
    })->name('home');

    // Users
    Route::resource('users', UserController::class)->except(['show'])
        ->parameters(['users' => 'slug']);
});

