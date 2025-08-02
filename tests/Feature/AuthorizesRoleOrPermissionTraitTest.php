<?php

declare(strict_types=1);

use Tests\Helpers\DummyAuthorizer;

uses()->group('sistema');

beforeEach(function () {
    $this->user = new_user();
    $this->authorizer = new DummyAuthorizer();
});

// AuthorizesRoleOrPermissionTraitTest

it('authorizes a user with a role', function () {
    $user = new_user(role: 'admin');

    $this->be($user);

    expect(
        $this->authorizer->authorizeRoleOrPermission('admin')
    )->toBeTrue(); // No lanza excepción
});

it('return false for unauthorized user with no role', function () {
    $this->be($this->user);

    expect(
        $this->authorizer->authorizeRoleOrPermission('editor')
    )->toBeFalse();
});

it('authorizes sudo role for any permission or role', function () {
    $user = new_user(role: 'sudo');

    $this->be($user);

    // No debería lanzar excepción
    expect(
        $this->authorizer->authorizeRoleOrPermission('non-existing-role')
    )->toBeTrue(); // El trait retorna `true` explícitamente para 'sudo'
});

it('authorizes a user with a permission', function () {
    $user = new_user(role: 'admin', permission: 'user list');

    $this->be($user);

    expect(
        $this->authorizer->authorizeRoleOrPermission('user list')
    )->toBeTrue(); // No lanza excepción
});

it('throws exception if user lacks role and permission', function () {
    $user = new_user();

    $this->be($user);

    expect(
        $this->authorizer->authorizeRoleOrPermission('new permission')
    )->toBeFalse();
});
