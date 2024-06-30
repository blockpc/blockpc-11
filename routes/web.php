<?php

use App\Http\Controllers\Auth\LogoutController;
use App\Livewire\Users\TableUsers;
use Illuminate\Support\Facades\Route;

Route::get('/', \App\Livewire\Home::class)->name('home');
Route::post('/logout', LogoutController::class)->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', \App\Livewire\Dashboard::class)->name('dashboard');
    Route::get('/profile', \App\Livewire\Profile::class)->name('profile');
});

Route::middleware(['auth'])->prefix('sistema')->group(function () {
    Route::get('/usuarios', TableUsers::class)->name('users.table');
});

require __DIR__.'/auth.php';
