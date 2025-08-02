<?php

declare(strict_types=1);

use App\Livewire\Users\RestoreUser;
use App\Models\User;

use function Pest\Livewire\livewire;

uses()->group('sistema', 'users');

beforeEach(function () {
    $this->user = new_user();
});

// RestoreUserTest

it('checking properties on view', function () {
    $user = User::factory()->trashed()->create();

    livewire(RestoreUser::class, ['user_id' => $user->id])
        ->assertPropertyWired('name')
        ->assertPropertyWired('password')
        ->assertMethodWiredToForm('restore');
});

it('can not restore a user if dont have permission', function () {
    $user = User::factory()->trashed()->create();

    livewire(RestoreUser::class, ['user_id' => $user->id])
        ->set('name', $user->fullname)
        ->set('password', 'password')
        ->call('restore')
        ->assertForbidden();
});

it('can restore a user if have permission', function () {
    $this->user->givePermissionTo('user restore');

    $user = User::factory()->trashed()->create();

    livewire(RestoreUser::class, ['user_id' => $user->id])
        ->set('name', $user->fullname)
        ->set('password', 'password')
        ->call('restore')
        ->assertHasNoErrors();

    $this->assertDatabaseHas('users', [
        'id' => $user->id,
    ]);
});
