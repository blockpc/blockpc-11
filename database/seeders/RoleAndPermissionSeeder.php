<?php

declare(strict_types=1);

namespace Database\seeders;

use App\Models\Permission;
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

        /**
         * Permisos
         */

        /* Permiso Super Administrador */
        $super_admin = Permission::firstOrCreate(['name' => 'super admin'], [
            'name' => 'super admin',
            'display_name' => 'Super usuario',
            'description' => 'Permiso de Super Usuario. El usuario con este permiso tiene acceso total al sistema. No necesita ningún otro permiso',
            'key' => 'sudo',
        ]);

        /**
         * Permisos Users
         */
        $user_list = Permission::firstOrCreate(['name' => 'user list'], [
            'name' => 'user list',
            'display_name' => 'Listado de Usuarios',
            'description' => 'Permite acceder al listado de usuarios',
            'key' => 'users',
        ]);
        $role_admin->givePermissionTo($user_list);

        $user_create = Permission::firstOrCreate(['name' => 'user create'], [
            'name' => 'user create',
            'display_name' => 'Crear Usuarios',
            'description' => 'Permite crear un nuevo usuario',
            'key' => 'users',
        ]);
        $role_admin->givePermissionTo($user_create);

        $user_update = Permission::firstOrCreate(['name' => 'user update'], [
            'name' => 'user update',
            'display_name' => 'Actualizar Usuarios',
            'description' => 'Permite actualizar la información de un usuario',
            'key' => 'users',
        ]);
        $user_delete = Permission::firstOrCreate(['name' => 'user delete'], [
            'name' => 'user delete',
            'display_name' => 'Eliminar Usuarios',
            'description' => 'Permite eliminar un usuario',
            'key' => 'users',
        ]);
        $role_admin->givePermissionTo($user_delete);

        $user_restore = Permission::firstOrCreate(['name' => 'user restore'], [
            'name' => 'user restore',
            'display_name' => 'Restaurar Usuario',
            'description' => 'Permite restaurar un usuario eliminado anteriormente',
            'key' => 'users',
        ]);
        $role_admin->givePermissionTo($user_restore);

        /**
         * Permisos Roles
         */
        $role_list = Permission::firstOrCreate(['name' => 'role list'], [
            'name' => 'role list',
            'display_name' => 'Listado de Cargos',
            'description' => 'Permite acceder al listado de cargos',
            'key' => 'roles',
        ]);
        $role_admin->givePermissionTo($role_list);

        $role_create = Permission::firstOrCreate(['name' => 'role create'], [
            'name' => 'role create',
            'display_name' => 'Crear Cargos',
            'description' => 'Permite crear un cargo',
            'key' => 'roles',
        ]);
        $role_admin->givePermissionTo($role_create);

        $role_update = Permission::firstOrCreate(['name' => 'role update'], [
            'name' => 'role update',
            'display_name' => 'Actualizar Cargos',
            'description' => 'Permite actualizar un cargo',
            'key' => 'roles',
        ]);
        $role_admin->givePermissionTo($role_update);

        $role_delete = Permission::firstOrCreate(['name' => 'role delete'], [
            'name' => 'role delete',
            'display_name' => 'Eliminar Cargos',
            'description' => 'Permite eliminar un cargo',
            'key' => 'roles',
        ]);
        $role_admin->givePermissionTo($role_delete);

        $role_restore = Permission::firstOrCreate(['name' => 'role restore'], [
            'name' => 'role restore',
            'display_name' => 'Restaurar Cargo',
            'description' => 'Permite restaurar un cargo eliminado anteriormente',
            'key' => 'roles',
        ]);
        $role_admin->givePermissionTo($role_restore);

        /**
         * Permisos Permissions
         */
        $permission_list = Permission::firstOrCreate(['name' => 'permission list'], [
            'name' => 'permission list',
            'display_name' => 'Listado de Permisos',
            'description' => 'Permite el acceso a la lista de permisos',
            'key' => 'permissions',
        ]);
        $role_admin->givePermissionTo($permission_list);

        $permission_update = Permission::firstOrCreate(['name' => 'permission update'], [
            'name' => 'permission update',
            'display_name' => 'Actualizar Permisos',
            'description' => 'Permite actualizar la información de un permiso',
            'key' => 'permissions',
        ]);
        $role_admin->givePermissionTo($permission_update);
    }
}
