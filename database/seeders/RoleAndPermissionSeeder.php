<?php

declare(strict_types=1);

namespace Database\seeders;

use Blockpc\App\Models\Permission;
use Blockpc\App\Models\Role;
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
        $role_sudo = Role::create([
            'name' => 'sudo',
            'display_name' => 'Super Administrador',
            'description' => 'Usuario del sistema con acceso total',
        ]);

        /* Role Administrador */
        $role_admin = Role::create([
            'name' => 'admin',
            'display_name' => 'Administrador',
            'description' => 'Usuario del sistema con acceso general',
        ]);

        /* Role Usuario */
        $role_user = Role::create([
            'name' => 'user',
            'display_name' => 'Usuario',
            'description' => 'Usuario asociado a un centro, capacitado para tomar un cargo del protocolo, solo vera su dashboard',
        ]);

        /**
         * Permisos
         */

        /* Permiso Super Administrador */
        $super_admin = Permission::create([
            'name' => 'super admin',
            'display_name' => 'Super usuario',
            'description' => 'Permiso de Super Usuario. El usuario con este permiso tiene acceso total al sistema. No necesita ningún otro permiso',
            'key' => 'sudo',
        ]);

        /**
         * Permisos Users
         */
        $user_list = Permission::create([
            'name' => 'user list',
            'display_name' => 'Listado de Usuarios',
            'description' => 'Permite acceder al listado de usuarios',
            'key' => 'users',
        ]);
        $role_admin->givePermissionTo($user_list);

        $user_create = Permission::create([
            'name' => 'user create',
            'display_name' => 'Crear Usuarios',
            'description' => 'Permite crear un nuevo usuario',
            'key' => 'users',
        ]);
        $role_admin->givePermissionTo($user_create);

        $user_update = Permission::create([
            'name' => 'user update',
            'display_name' => 'Actualizar Usuarios',
            'description' => 'Permite actualizar la información de un usuario',
            'key' => 'users',
        ]);
        $user_delete = Permission::create([
            'name' => 'user delete',
            'display_name' => 'Eliminar Usuarios',
            'description' => 'Permite eliminar un usuario',
            'key' => 'users',
        ]);
        $role_admin->givePermissionTo($user_delete);

        $user_restore = Permission::create([
            'name' => 'user restore',
            'display_name' => 'Restaurar Usuario',
            'description' => 'Permite restaurar un usuario eliminado anteriormente',
            'key' => 'users',
        ]);
        $role_admin->givePermissionTo($user_restore);

        /**
         * Permisos Roles
         */
        $role_list = Permission::create([
            'name' => 'role list',
            'display_name' => 'Listado de Cargos',
            'description' => 'Permite acceder al listado de cargos',
            'key' => 'roles',
        ]);
        $role_admin->givePermissionTo($role_list);

        $role_create = Permission::create([
            'name' => 'role create',
            'display_name' => 'Crear Cargos',
            'description' => 'Permite crear un cargo',
            'key' => 'roles',
        ]);
        $role_admin->givePermissionTo($role_create);

        $role_update = Permission::create([
            'name' => 'role update',
            'display_name' => 'Actualizar Cargos',
            'description' => 'Permite actualizar un cargo',
            'key' => 'roles',
        ]);
        $role_admin->givePermissionTo($role_update);

        $role_delete = Permission::create([
            'name' => 'role delete',
            'display_name' => 'Eliminar Cargos',
            'description' => 'Permite eliminar un cargo',
            'key' => 'roles',
        ]);
        $role_admin->givePermissionTo($role_delete);

        $role_restore = Permission::create([
            'name' => 'role restore',
            'display_name' => 'Restaurar Cargo',
            'description' => 'Permite restaurar un cargo eliminado anteriormente',
            'key' => 'roles',
        ]);
        $role_admin->givePermissionTo($role_restore);

        $permission_list = Permission::create([
            'name' => 'permission list',
            'display_name' => 'Listado de Permisos',
            'description' => 'Permite el acceso a la lista de permisos',
            'key' => 'permissions',
        ]);
        $role_admin->givePermissionTo($permission_list);

        /**
         * Permisos Permissions
         */
        $permission_update = Permission::create([
            'name' => 'permission update',
            'display_name' => 'Actualizar Permisos',
            'description' => 'Permite actualizar la información de un permiso',
            'key' => 'permissions',
        ]);
        $role_admin->givePermissionTo($permission_update);
    }
}
