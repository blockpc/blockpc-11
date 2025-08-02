<?php

declare(strict_types=1);

use App\Livewire\Users\DeleteUser;
use App\Models\User;
use Livewire\Livewire;

uses()->group('sistema', 'users');

beforeEach(function () {
    $this->user = new_user();
    $this->user->givePermissionTo('user delete');
});

// DeleteUserTest

it('checking properties on view', function () {
    $user = User::factory()->create();

    Livewire::actingAs($this->user)
        ->test(DeleteUser::class, ['user_id' => $user->id])
        ->assertPropertyWired('name')
        ->assertPropertyWired('password')
        ->assertMethodWiredToForm('delete');
});

it('can not delete a user if dont have permission', function () {
    $user = User::factory()->create();

    $this->user->revokePermissionTo('user delete');

    Livewire::actingAs($this->user)
        ->test(DeleteUser::class, ['user_id' => $user->id])
        ->assertForbidden();
});

it('can delete a user if have permission', function () {
    $this->user->givePermissionTo('user delete');

    $user = new_user();

    Livewire::actingAs($this->user)
        ->test(DeleteUser::class, ['user_id' => $user->id])
        ->set('name', $user->fullname)
        ->set('password', 'password')
        ->call('delete')
        ->assertHasNoErrors();

    $this->assertSoftDeleted('users', [
        'id' => $user->id,
    ]);
});
