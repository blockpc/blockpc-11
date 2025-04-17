<?php

use App\Livewire\Roles\CreateRole;
use App\Models\Role;
use Livewire\Livewire;

uses()->group('sistema', 'roles');

beforeEach(function () {
    $this->user = new_user();
});

// CreateRoleTest

it('checking properties on view', function () {

    Livewire::actingAs($this->user)
        ->test(CreateRole::class)
        ->assertPropertyWired('name')
        ->assertPropertyWired('display_name')
        ->assertPropertyWired('description')
        ->assertMethodWiredToForm('save');
});

it('can not create a new position if not authenticated', function () {
    Livewire::test(CreateRole::class)
        ->set('name', 'newrole')
        ->set('display_name', 'New Role')
        ->set('description', 'lorem ipsum')
        ->call('save')
        ->assertForbidden();
});

it('can not create a new position if dont have permission', function () {
    Livewire::actingAs($this->user)
        ->test(CreateRole::class)
        ->set('name', 'newrole')
        ->set('display_name', 'New Role')
        ->set('description', 'lorem ipsum')
        ->call('save')
        ->assertForbidden();
});

it('can create a new role', function () {
    $this->user->givePermissionTo('role create');

    Livewire::actingAs($this->user)
        ->test(CreateRole::class)
        ->set('name', 'newrole')
        ->set('display_name', 'New Role')
        ->set('description', 'lorem ipsum')
        ->call('save')
        ->assertHasNoErrors();

    $this->assertDatabaseHas('roles', [
        'name' => 'newrole',
        'guard_name' => 'web',
    ]);
});

it('cant create a new role with invalid data', function () {
    $this->user->givePermissionTo('role create');

    Livewire::actingAs($this->user)
        ->test(CreateRole::class)
        ->set('name', '')
        ->set('display_name', '')
        ->call('save')
        ->assertHasErrors([
            'name' => 'required',
            'display_name' => 'required',
        ]);
});

it('cant create a new role with a name that already exists', function () {
    $this->user->givePermissionTo('role create');

    // $role = Role::factory()->create([
    //     'name' => 'newrole',
    // ]);

    // expect($role->name)->toBe('newrole');

    $role = Role::factory()->create();

    Livewire::actingAs($this->user)
        ->test(CreateRole::class)
        ->set('name', $role->name)
        ->set('display_name', 'New Role')
        ->set('description', 'lorem ipsum')
        ->call('save')
        ->assertHasErrors([
            'name' => 'unique',
        ]);
});

it('cant create a new role with a display_name that already exists', function () {
    $this->user->givePermissionTo('role create');

    $role = Role::factory()->create();

    Livewire::actingAs($this->user)
        ->test(CreateRole::class)
        ->set('name', 'lorem')
        ->set('display_name', $role->display_name)
        ->set('description', 'lorem ipsum')
        ->call('save')
        ->assertHasErrors([
            'display_name' => 'unique',
        ]);
});
