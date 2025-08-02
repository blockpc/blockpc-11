<?php

declare(strict_types=1);

use App\Livewire\Roles\DeleteRole;
use App\Models\Role;

uses()->group('roles');

beforeEach(function () {
    $this->user = new_user();

    $this->user->givePermissionTo('role delete');

    $this->role = Role::factory()->create([
        'display_name' => 'new role',
    ]);
});

// DeleteRoleTest

it('checking properties on view', function () {
    $this->actingAs($this->user)
        ->livewire(DeleteRole::class, ['role_id' => $this->role->id])
        ->assertPropertyWired('name')
        ->assertPropertyWired('password')
        ->assertMethodWiredToForm('save');
});

it('can not delete a role if user does not have permission', function () {
    $user = new_user();

    $this->actingAs($user)
        ->livewire(DeleteRole::class, ['role_id' => $this->role->id])
        ->assertForbidden();
});

it('can not delete a role if name is not same', function () {
    $this->actingAs($this->user)
        ->livewire(DeleteRole::class, ['role_id' => $this->role->id])
        ->set('name', 'wrong name')
        ->set('password', 'password')
        ->call('save')
        ->assertHasErrors(['name']);
});

it('can not delete a role if password is not same', function () {
    $this->actingAs($this->user)
        ->livewire(DeleteRole::class, ['role_id' => $this->role->id])
        ->set('name', $this->role->display_name)
        ->set('password', 'wrong password')
        ->call('save')
        ->assertHasErrors(['password']);
});

it('can delete a role', function () {
    $this->actingAs($this->user)
        ->livewire(DeleteRole::class, ['role_id' => $this->role->id])
        ->set('name', $this->role->display_name)
        ->set('password', 'password')
        ->call('save')
        ->assertHasNoErrors()
        ->assertRedirect(route('roles.table'));

    expect(Role::find($this->role->id))->toBeNull();
});
