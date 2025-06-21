<?php

declare(strict_types=1);

uses()->group('sistema', 'users');

beforeEach(function () {
    $this->user = new_user();
});

// UsersTableTest

it('I cant access the users table if Im not authenticated', function () {
    $response = $this->get('/sistema/usuarios');

    $response->assertStatus(302);
});

it('I cant access the users table if I dont have permission', function () {
    $response = $this->actingAs($this->user)->get('/sistema/usuarios');

    $response->assertStatus(403);
});

it('I can access the users table authenticated and with permission', function () {
    $this->user->givePermissionTo('user list');

    $response = $this->actingAs($this->user)->get('/sistema/usuarios');

    $response->assertStatus(200);
});
