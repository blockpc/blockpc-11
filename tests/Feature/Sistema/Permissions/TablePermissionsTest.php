<?php

declare(strict_types=1);

uses()->group('permissions');

beforeEach(function () {
    $this->user = new_user();
});

// TablePermissionsTest

it('I cant access the permissions table if Im not authenticated', function () {
    $response = $this->get('/sistema/permisos');

    $response->assertStatus(302);
});

it('I cant access the permissions table if I dont have permission', function () {
    $response = $this->actingAs($this->user)->get('/sistema/permisos');

    $response->assertStatus(403);
});

it('I can access the permissions table authenticated and with permission', function () {
    $this->user->givePermissionTo('permission list');

    $response = $this->actingAs($this->user)->get('/sistema/permisos');

    $response->assertStatus(200);
});
