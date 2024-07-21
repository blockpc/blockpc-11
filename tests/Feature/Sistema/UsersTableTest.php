<?php

uses()->group('sistema', 'users');

beforeEach(function () {
    $this->user = new_user();
});

// UsersTableTest

it('no puedo acceder a la tabla de usuarios si no estoy autenticado', function () {
    $response = $this->get('/sistema/usuarios');

    $response->assertStatus(302);
});

it('no puedo acceder a la tabla de usuarios si no tengo permiso', function () {
    $response = $this->actingAs($this->user)->get('/sistema/usuarios');

    $response->assertStatus(403);
});

it('puedo acceder a la tabla de usuarios autenticado y con permiso', function () {
    $this->user->givePermissionTo('user list');

    $response = $this->actingAs($this->user)->get('/sistema/usuarios');

    $response->assertStatus(200);
});
