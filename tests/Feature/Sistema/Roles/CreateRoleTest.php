<?php

use App\Livewire\Roles\CreateRole;
use Livewire\Livewire;

uses()->group('sistema', 'roles');

beforeEach(function () {
    $this->user = new_user();
});

// CreateRoleTest

it('no puedo crear un nuevo cargo si no estoy autenticado', function () {
    $this->get(route('roles.create'))->assertRedirect(route('login'));
});

it('no puedo crear un nuevo cargo si no tengo permiso', function () {
    $this->actingAs($this->user)->get(route('roles.create'))->assertStatus(403);
});

it('puedo crear un nuevo cargo si tengo permiso', function () {
    $this->user->givePermissionTo('role create');

    $this->actingAs($this->user)->get(route('roles.create'))->assertOk();
});

it('verificar si las propiedades existen en la vista', function () {
    $this->user->givePermissionTo('role create');

    Livewire::actingAs($this->user)
        ->test('roles.create-role')
        ->assertPropertyWired('name')
        ->assertPropertyWired('display_name')
        ->assertPropertyWired('description')
        ->assertMethodWiredToForm('save');
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
