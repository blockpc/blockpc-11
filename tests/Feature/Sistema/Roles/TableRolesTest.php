<?php

uses()->group('sistema', 'roles');

beforeEach(function () {
    $this->user = new_user();
});

// TableRolesTest

it('no puedo acceder a la tabla de cargos si no estoy autenticado', function () {
    $response = $this->get('/sistema/cargos');

    $response->assertStatus(302);
});

it('no puedo acceder a la tabla de cargos si no tengo permiso', function () {
    $response = $this->actingAs($this->user)->get('/sistema/cargos');

    $response->assertStatus(403);
});

it('puedo acceder a la tabla de cargos autenticado y con permiso', function () {
    $this->user->givePermissionTo('role list');

    $response = $this->actingAs($this->user)->get('/sistema/cargos');

    $response->assertStatus(200);
});
