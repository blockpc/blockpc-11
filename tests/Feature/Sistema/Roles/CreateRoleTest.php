<?php

declare(strict_types=1);

use App\Livewire\Roles\CreateRole;
use App\Models\Role;

uses()->group('sistema', 'roles');

beforeEach(function () {
    $this->user = new_user();

    $this->user->givePermissionTo('role create');
});

// CreateRoleTest

it('checking properties on view', function () {

    $this->actingAs($this->user)
        ->livewire(CreateRole::class)
        ->assertPropertyWired('name')
        ->assertPropertyWired('display_name')
        ->assertPropertyWired('description')
        ->assertMethodWiredToForm('save');
});

it('can not create a role if user does not have permission', function () {
    $user = new_user();

    $this->actingAs($user)
        ->livewire(CreateRole::class)
        ->assertForbidden();
});

it('can not create a role if name is empty', function () {
    $this->actingAs($this->user)
        ->livewire(CreateRole::class)
        ->set('name', '')
        ->call('save')
        ->assertHasErrors(['name']);
});

it('can not create a role if display name is empty', function () {
    $this->actingAs($this->user)
        ->livewire(CreateRole::class)
        ->set('display_name', '')
        ->call('save')
        ->assertHasErrors(['display_name']);
});

it('can create a role', function () {
    $this->actingAs($this->user)
        ->livewire(CreateRole::class)
        ->set('name', 'new_role')
        ->set('display_name', 'New Role')
        ->set('description', 'This is a new role')
        ->call('save')
        ->assertHasNoErrors();

    $this->assertDatabaseHas('roles', [
        'name' => 'new_role',
        'display_name' => 'New Role',
        'description' => 'This is a new role',
    ]);
});

it('can not create a role with existing name', function () {
    Role::factory()->create(['name' => 'existing_role']);

    $this->actingAs($this->user)
        ->livewire(CreateRole::class)
        ->set('name', 'existing_role')
        ->call('save')
        ->assertHasErrors(['name']);
});

it('can not create a role with existing display name', function () {
    Role::factory()->create(['display_name' => 'Existing Role']);

    $this->actingAs($this->user)
        ->livewire(CreateRole::class)
        ->set('name', 'new_role')
        ->set('display_name', 'Existing Role')
        ->call('save')
        ->assertHasErrors(['display_name']);
});

it('can create a role with valid data', function () {
    $this->actingAs($this->user)
        ->livewire(CreateRole::class)
        ->set('name', 'valid_role')
        ->set('display_name', 'Valid Role')
        ->set('description', 'This is a valid role')
        ->call('save')
        ->assertHasNoErrors();

    $this->assertDatabaseHas('roles', [
        'name' => 'valid_role',
        'display_name' => 'Valid Role',
        'description' => 'This is a valid role',
    ]);
});
