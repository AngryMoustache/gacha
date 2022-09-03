<?php

use App\Http\Livewire;
use App\Http\Middleware\CheckLoggedIn;
use Illuminate\Support\Facades\Route;

Route::get('/login', Livewire\Auth\Portal::class)->name('auth.login');

Route::middleware([CheckLoggedIn::class])->group(function () {
    Route::get('{location}', Livewire\Router::class)
        ->where('location', '.*')
        ->name('game.dashboard');
});
