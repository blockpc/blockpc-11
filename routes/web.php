<?php

use App\Http\Controllers\Auth\LogoutController;
use App\Livewire\Roles\CreateRole;
use App\Livewire\Roles\TableRoles;
use App\Livewire\Users\CreateUser;
use App\Livewire\Users\TableUsers;
use Illuminate\Support\Facades\Route;

Route::get('/', \App\Livewire\Home::class)->name('home');
Route::post('/logout', LogoutController::class)->name('logout');

Route::middleware(['auth'])
    ->group(function () {
        Route::get('/dashboard', \App\Livewire\Dashboard::class)->name('dashboard');
        Route::get('/perfil-usuario', \App\Livewire\Profile::class)->name('profile');

        Route::prefix('sistema')->group(function () {
            Route::get('/usuarios', TableUsers::class)->name('users.table');
            Route::get('/usuarios/crear', CreateUser::class)->name('users.create');
        });

        Route::prefix('sistema')->group(function () {
            Route::get('/cargos', TableRoles::class)->name('roles.table');
            Route::get('/cargos/crear', CreateRole::class)->name('roles.create');
        });
    });

require __DIR__.'/auth.php';
