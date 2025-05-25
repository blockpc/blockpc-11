<?php

uses()->group('sistema', 'roles');

beforeEach(function () {
    $this->user = new_user();
});

// TableRolesTest

it('I cannot access the roles table if I am not authenticated', function () {
    $response = $this->get('/sistema/cargos');

    $response->assertStatus(302);
});

it('I cannot access the roles table if I do not have permission', function () {
    $response = $this->actingAs($this->user)->get('/sistema/cargos');

    $response->assertStatus(403);
});

it('I can access the roles table authenticated and with permission', function () {
    $this->user->givePermissionTo('role list');

    $response = $this->actingAs($this->user)->get('/sistema/cargos');

    $response->assertStatus(200);
});
