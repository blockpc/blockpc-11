<?php

declare(strict_types=1);

use App\Livewire\Users\RestoreUser;
use App\Models\User;

uses()->group('sistema', 'users');

beforeEach(function () {
    $this->user = new_user();
    $this->user->givePermissionTo('user restore');
});

// RestoreUserTest

it('checking properties on view', function () {
    $user = User::factory()->trashed()->create();

    $this->actingAs($this->user)
        ->livewire(RestoreUser::class, ['user_id' => $user->id])
        ->assertPropertyWired('name')
        ->assertPropertyWired('password')
        ->assertMethodWiredToForm('restore');
});

it('can not restore a user if dont have permission', function () {
    $user = User::factory()->trashed()->create();

    $this->user->revokePermissionTo('user restore');

    $this->actingAs($this->user)
        ->livewire(RestoreUser::class, ['user_id' => $user->id])
        ->assertForbidden();
});

it('can restore a user if have permission', function () {
    $user = new_user();

    $user->delete(); // Soft delete the user

    $this->actingAs($this->user)
        ->livewire(RestoreUser::class, ['user_id' => $user->id])
        ->set('name', $user->fullname)
        ->set('password', 'password')
        ->call('restore')
        ->assertHasNoErrors();

    $this->assertDatabaseHas('users', [
        'id' => $user->id,
    ]);
});
