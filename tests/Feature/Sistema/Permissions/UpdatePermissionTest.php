<?php

declare(strict_types=1);

use App\Livewire\Permissions\UpdatePermission;
use App\Models\Permission;
use Livewire\Livewire;

uses()->group('permissions');

beforeEach(function () {
    $this->user = new_user();
});

// UpdatePermissionTest

it('can not update permission if not authorized', function () {
    $permission = Permission::factory()->create();

    Livewire::actingAs($this->user)
        ->test(UpdatePermission::class)
        ->call('show', $permission->id)
        ->call('update', ['display_name' => 'Update Permission', 'description' => 'Update Permission Description'])
        ->assertForbidden();
});

it('can update permission if authorized', function () {
    $this->user->givePermissionTo('permission update');

    $permission = Permission::factory()->create();

    Livewire::actingAs($this->user)
        ->test(UpdatePermission::class)
        ->call('show', $permission->id)
        ->call('update', ['display_name' => 'Update Permission', 'description' => 'Update Permission Description'])
        ->assertHasNoErrors()
        ->assertDispatched('permissionsUpdated');
});

it('can not update permission if validation fails', function () {
    $this->user->givePermissionTo('permission update');

    $permission = Permission::factory()->create();

    Livewire::actingAs($this->user)
        ->test(UpdatePermission::class)
        ->call('show', $permission->id)
        ->set('display_name', '')
        ->set('description', '')
        ->call('update')
        ->assertHasErrors(['display_name' => 'required', 'description' => 'required']);
});

it('can not update permission if display name exists', function () {
    $this->user->givePermissionTo('permission update');

    Permission::factory()->create(['display_name' => 'Permiso']);

    $permission = Permission::factory()->create();

    Livewire::actingAs($this->user)
        ->test(UpdatePermission::class)
        ->call('show', $permission->id)
        ->set('display_name', 'permiso')
        ->call('update')
        ->assertHasErrors(['display_name' => 'unique']);
});
