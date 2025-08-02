<?php

declare(strict_types=1);

use App\Livewire\Permissions\UpdatePermission;
use App\Models\Permission;
use Livewire\Livewire;

uses()->group('permissions');

beforeEach(function () {
    $this->user = new_user();
    $this->user->givePermissionTo('permission update');
});

// UpdatePermissionTest

it('can not update permission if not authorized', function () {
    $permission = Permission::factory()->create();

    $this->user->revokePermissionTo('permission update');

    $this->actingAs($this->user)
        ->livewire(UpdatePermission::class, ['permission_id' => $permission->id])
        ->assertForbidden();
});

it('can update permission if authorized', function () {
    $permission = Permission::factory()->create();

    $this->actingAs($this->user)
        ->livewire(UpdatePermission::class, ['permission_id' => $permission->id])
        ->call('update', ['display_name' => 'Update Permission', 'description' => 'Update Permission Description'])
        ->assertHasNoErrors();
});

it('can not update permission if validation fails', function () {
    $permission = Permission::factory()->create();

    Livewire::actingAs($this->user)
        ->test(UpdatePermission::class, ['permission_id' => $permission->id])
        ->set('display_name', '')
        ->set('description', '')
        ->call('update')
        ->assertHasErrors(['display_name' => 'required', 'description' => 'required']);
});

it('can not update permission if display name exists', function () {
    Permission::factory()->create(['display_name' => 'Permiso']);

    $permission = Permission::factory()->create();

    Livewire::actingAs($this->user)
        ->test(UpdatePermission::class, ['permission_id' => $permission->id])
        ->set('display_name', 'permiso')
        ->call('update')
        ->assertHasErrors(['display_name' => 'unique']);
});
