<?php

declare(strict_types=1);

namespace Database\seeders;

use App\Models\Permission;
use Blockpc\App\Console\Classes\PermissionList;
use Illuminate\Database\Seeder;

final class TestPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (PermissionList::all() as $permiso) {
            [$name, $key, $description, $displayName, $guard] = array_pad($permiso, 5, 'web');

            $permission = Permission::firstOrCreate(
                ['name' => $name, 'guard_name' => $guard]
            );

            $permission->key = $key;
            $permission->description = $description;
            $permission->display_name = $displayName;
            $permission->save();
        }
    }
}
