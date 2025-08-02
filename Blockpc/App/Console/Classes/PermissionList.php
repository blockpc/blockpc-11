<?php

declare(strict_types=1);

namespace Blockpc\App\Console\Classes;

final class PermissionList
{
    /**
     * Devuelve todos los permisos utilizados por el sistema.
     * Cada arreglo contiene:
     * - name: Nombre del permiso
     * - key: clave de grupo del permiso
     * - description: Descripción del permiso
     * - display_name: Nombre para mostrar del permiso
     * - guard_name: Nombre del guard (opcional, por defecto 'web')
     * [name, key, description, display_name, guard_name (, opcional:web)]
     */
    public static function all(): array
    {
        return [
            ...self::system(),
            ...self::users(),
            ...self::roles(),
            ...self::permissions(),
        ];
    }

    private static function system(): array
    {
        return [
            ['super admin', 'sudo', 'Permiso de Super Usuario. El usuario con este permiso tiene acceso total al sistema. No necesita ningún otro permiso', 'Super usuario'],
            // ['jobs control', 'jobs', 'Controla las tareas pendientes y fallidas del sistema', 'Control Tareas'],
            // ['settings control', 'settings', 'Controla el acceso a la configuración del sistema', 'Control Configuración'],
        ];
    }

    private static function users(): array
    {
        return [
            ['user list', 'users', 'Permite acceder al listado de usuarios', 'Listado de Usuarios'],
            ['user create', 'users', 'Permite crear un nuevo usuario', 'Crear Usuarios'],
            ['user update', 'users', 'Permite actualizar la información de un usuario', 'Actualizar Usuarios'],
            ['user delete', 'users', 'Permite eliminar un usuario', 'Eliminar Usuarios'],
            ['user restore', 'users', 'Permite restaurar un usuario eliminado anteriormente', 'Restaurar Usuario'],
        ];
    }

    private static function roles(): array
    {
        return [
            ['role list', 'roles', 'Permite acceder al listado de cargos', 'Listado de Cargos'],
            ['role create', 'roles', 'Permite crear un cargo', 'Crear Cargos'],
            ['role update', 'roles', 'Permite actualizar un cargo', 'Actualizar Cargos'],
            ['role delete', 'roles', 'Permite eliminar un cargo', 'Eliminar Cargos'],
            ['role restore', 'roles', 'Permite restaurar un cargo eliminado anteriormente', 'Restaurar Cargo'],
        ];
    }

    private static function permissions(): array
    {
        return [
            ['permission list', 'permissions', 'Permite el acceso a la lista de permisos', 'Listado de Permisos'],
            ['permission update', 'permissions', 'Permite actualizar la información de un permiso', 'Actualizar Permisos'],
        ];
    }
}
