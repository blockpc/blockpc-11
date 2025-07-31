<?php

declare(strict_types=1);

use App\Http\Controllers\Auth\LogoutController;
use App\Livewire\Permissions\TablePermissions;
use App\Livewire\Roles\TableRoles;
use App\Livewire\Roles\UpdateRole;
use App\Livewire\Users\TableUsers;
use App\Livewire\Users\UpdateUser;
use Illuminate\Support\Facades\Route;

Route::get('/', App\Livewire\Home::class)->name('home');
Route::get('/contacto', App\Livewire\Contact::class)->name('contact');
Route::post('/logout', LogoutController::class)->name('logout');

Route::middleware(['auth'])
    ->group(function () {
        Route::get('/dashboard', App\Livewire\Dashboard::class)->name('dashboard');
        Route::get('/perfil-usuario', App\Livewire\Profile::class)->name('profile');

        Route::prefix('sistema')->group(function () {
            Route::get('/usuarios', TableUsers::class)->name('users.table');
            Route::get('/usuarios/editar/{user}', UpdateUser::class)->name('users.update');
        });

        Route::prefix('sistema')->group(function () {
            Route::get('/cargos', TableRoles::class)->name('roles.table');
            Route::get('/cargos/editar/{role}', UpdateRole::class)->name('roles.update');
        });

        Route::prefix('sistema')->group(function () {
            Route::get('/permisos', TablePermissions::class)->name('permissions.table');
        });
    });

// fallback
Route::fallback(function () {
    return redirect()->route('home');
});

require __DIR__.'/auth.php';
