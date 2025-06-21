<?php

declare(strict_types=1);

use App\Livewire\Roles\DeleteRole;
use App\Models\Role;
use Livewire\Livewire;

uses()->group('roles');

beforeEach(function () {
    $this->user = new_user();

    $this->role = Role::factory()->create([
        'display_name' => 'new role',
    ]);
});

// DeleteRoleTest

it('checking properties on view', function () {

    Livewire::test(DeleteRole::class)
        ->assertPropertyWired('name')
        ->assertPropertyWired('password')
        ->assertMethodWiredToForm('save');
});

it('can not delete a role if name is not same', function () {
    Livewire::actingAs($this->user)
        ->test(DeleteRole::class)
        ->call('show', $this->role->id)
        ->assertSet('current_name', 'new role')
        ->set('name', 'wrong name')
        ->set('password', 'password')
        ->call('save', $this->role->id)
        ->assertHasErrors(['name']);
});

it('can not delete a role if wrong user password', function () {
    Livewire::actingAs($this->user)
        ->test(DeleteRole::class)
        ->call('show', $this->role->id)
        ->assertSet('current_name', 'new role')
        ->set('name', 'new role')
        ->set('password', 'wrong password')
        ->call('save', $this->role->id)
        ->assertHasErrors(['password']);
});

it('can delete a role', function () {
    Livewire::actingAs($this->user)
        ->test(DeleteRole::class)
        ->call('show', $this->role->id)
        ->assertSet('current_name', 'new role')
        ->set('name', 'new role')
        ->set('password', 'password')
        ->call('save', $this->role->id)
        ->assertHasNoErrors();

    $this->assertSoftDeleted('roles', [
        'id' => $this->role->id,
    ]);
});
