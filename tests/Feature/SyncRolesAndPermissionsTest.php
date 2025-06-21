<?php

declare(strict_types=1);

use Blockpc\App\Console\Services\PermissionSynchronizerService;
use Blockpc\App\Console\Services\RoleSynchronizerService;

uses()->group('sistema', 'permissions', 'roles');

beforeEach(function () {
    $this->user = new_user();
});

// SyncRolesAndPermissionsTest

it('roles y permisos sincronizados', function () {
    $permissionSync = app(PermissionSynchronizerService::class);
    $roleSync = app(RoleSynchronizerService::class);

    expect($permissionSync->getMissing()->isEmpty())->toBeTrue('Permisos faltantes');
    expect($permissionSync->getOrphans()->isEmpty())->toBeTrue('Permisos huérfanos');

    expect($roleSync->getMissing()->isEmpty())->toBeTrue('Roles faltantes');
    expect($roleSync->getOrphans()->isEmpty())->toBeTrue('Roles huérfanos');
});
