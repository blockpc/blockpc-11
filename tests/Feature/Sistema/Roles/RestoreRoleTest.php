<?php

declare(strict_types=1);

use App\Livewire\Roles\RestoreRole;
use App\Models\Role;

uses()->group('roles');

beforeEach(function () {
    $this->user = new_user();

    $this->user->givePermissionTo('role restore');
});

// RestoreRoleTest

it('checking properties on view', function () {
    $role = Role::factory()->create([
        'display_name' => 'test role',
    ]);

    $role->delete();

    $this->actingAs($this->user)
        ->livewire(RestoreRole::class, ['role_id' => $role->id])
        ->assertPropertyWired('name')
        ->assertPropertyWired('password')
        ->assertMethodWiredToForm('restore');
});

it('can not restore a role if user does not have permission', function () {

    $user = new_user();

    $role = Role::factory()->create([
        'display_name' => 'test role',
    ]);

    $role->delete();

    $this->actingAs($user)
        ->livewire(RestoreRole::class, ['role_id' => $role->id])
        ->assertForbidden();
});

it('can not restore a role if name is not same', function () {
    $role = Role::factory()->create([
        'display_name' => 'test role',
    ]);

    $role->delete();

    $this->actingAs($this->user)
        ->livewire(RestoreRole::class, ['role_id' => $role->id])
        ->set('name', 'wrong name')
        ->set('password', 'password')
        ->call('restore')
        ->assertHasErrors(['name']);
});

it('can not restore a role if wrong user password', function () {
    $role = Role::factory()->create([
        'display_name' => 'test role',
    ]);

    $role->delete();

    $this->actingAs($this->user)
        ->livewire(RestoreRole::class, ['role_id' => $role->id])
        ->set('name', 'test role')
        ->set('password', 'wrong password')
        ->call('restore')
        ->assertHasErrors(['password']);
});

it('can restore a role', function () {
    $role = Role::factory()->create([
        'display_name' => 'test role',
    ]);

    $role->delete();

    $this->actingAs($this->user)
        ->livewire(RestoreRole::class, ['role_id' => $role->id])
        ->set('name', 'test role')
        ->set('password', 'password')
        ->call('restore')
        ->assertHasNoErrors();

    $this->assertDatabaseHas('roles', [
        'id' => $role->id,
        'deleted_at' => null,
    ]);
});
