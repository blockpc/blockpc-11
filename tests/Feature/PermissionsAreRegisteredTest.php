<?php

use App\Models\Permission;
use Blockpc\App\Console\Classes\PermissionList;

uses()->group('sistema', 'permissions');

beforeEach(function() {
    $this->user = new_user();
});

// PermissionsAreRegisteredTest

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
