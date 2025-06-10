<?php

declare(strict_types=1);

namespace Database\seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

final class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**
         * Roles
         */

        /* Role Super Administrador */
        $role_sudo = Role::firstOrCreate(['name' => 'sudo'], [
            'name' => 'sudo',
            'display_name' => 'Super Administrador',
            'description' => 'Usuario del sistema con acceso total',
        ]);

        /* Role Administrador */
        $role_admin = Role::firstOrCreate(['name' => 'admin'], [
            'name' => 'admin',
            'display_name' => 'Administrador',
            'description' => 'Usuario del sistema con acceso general',
        ]);

        /* Role Usuario */
        $role_user = Role::firstOrCreate(['name' => 'user'], [
            'name' => 'user',
            'display_name' => 'Usuario',
            'description' => 'Usuario normal',
        ]);
    }
}
