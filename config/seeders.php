<?php

use Database\Seeders\RoleAndPermissionSeeder;
use Database\Seeders\TestPermissionsSeeder;
use Database\Seeders\UsersSeeder;

return [
    'local' => [
        ['name' => RoleAndPermissionSeeder::class, 'callable' => true],
        ['name' => TestPermissionsSeeder::class, 'callable' => true],
        ['name' => UsersSeeder::class, 'callable' => true],
    ],
    'testing' => [
        ['name' => RoleAndPermissionSeeder::class, 'callable' => true],
        ['name' => TestPermissionsSeeder::class, 'callable' => true],
    ],
    'production' => [
        ['name' => RoleAndPermissionSeeder::class, 'callable' => true],
    ],
];
