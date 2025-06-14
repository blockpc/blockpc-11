<?php

use App\Models\Permission;
use Blockpc\App\Console\Classes\PermissionList;
use Blockpc\App\Console\Services\PermissionSynchronizerService;

uses()->group('sistema', 'permissions');

// SyncPermissionsTest

it('todos los permisos definidos están registrados con su guard_name', function () {
    foreach (PermissionList::all() as $permiso) {
        // Asegurar que haya al menos los primeros 4 campos definidos
        expect(count($permiso))->toBeGreaterThanOrEqual(4);

        [$name, $key, $description, $displayName, $guard] = array_pad($permiso, 5, 'web');

        $existe = Permission::where('name', $name)
            ->where('guard_name', $guard)
            ->exists();

        expect($existe)
            ->toBeTrue("Falta el permiso '{$name}' con guard '{$guard}'");
    }
});

it('todos los permisos están registrados y sincronizados', function () {
    $sync = app(PermissionSynchronizerService::class);

    $missing = $sync->getMissing();
    $outdated = $sync->getOutdated();

    expect($missing->isEmpty())->toBeTrue('Hay permisos faltantes');
    expect($outdated->isEmpty())->toBeTrue('Hay permisos desactualizados');
});
