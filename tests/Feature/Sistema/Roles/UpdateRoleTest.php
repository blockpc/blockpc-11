<?php

use App\Models\Role;

uses()->group('roles');

beforeEach(function () {
    $this->user = new_user();

    $this->role = Role::factory()->create();
});

// UpdateRoleTest

it('I cannot access the roles update if I am not authenticated', function () {
    $response = $this->get(route('roles.update', ['role' => $this->role->id]));

    $response->assertStatus(302);
});

it('I cannot access the roles update if I do not have permission', function () {
    $response = $this->actingAs($this->user)->get(route('roles.update', ['role' => $this->role->id]));

    $response->assertStatus(403);
});

it('I can access the roles update authenticated and with permission', function () {
    $this->user->givePermissionTo('role update');

    $response = $this->actingAs($this->user)->get(route('roles.update', ['role' => $this->role->id]));

    $response->assertStatus(200);
});
