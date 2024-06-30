<?php

uses()->group('users');

beforeEach(function() {
    $this->user = new_user();
});

// UsersTableTest

it('no puedo acceder a la tabla de usuarios si no estoy autenticado', function ()
{
    $response = $this->get('/sistema/usuarios');

    $response->assertStatus(302);
});

it('puedo acceder a la tabla de usuarios', function ()
{
    $response = $this->actingAs($this->user)->get('/sistema/usuarios');

    $response->assertStatus(200);
});
