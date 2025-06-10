<?php

declare(strict_types=1);

namespace Blockpc\App\Console\Classes;

final class PermissionList
{
    /**
     * Devuelve todos los permisos utilizados por el sistema.
     */
    public static function all(): array
    {
        // cada arreglo contiene [name, key, description, display_name, guard_name (opcional:web)]
        return [
            ['super admin', 'sudo', 'Permiso de Super Usuario. El usuario con este permiso tiene acceso total al sistema. No necesita ningún otro permiso', 'Super usuario'],
            ['jobs control', 'jobs', 'Controla las tareas pendientes y fallidas del sistema', 'Control Tareas'],
            ['settings control', 'settings', 'Controla el acceso a la configuración del sistema', 'Control Configuración'],
            ['user list', 'users', 'Permite acceder al listado de usuarios', 'Listado de Usuarios'],
            ['user create', 'users', 'Permite crear un nuevo usuario', 'Crear Usuarios'],
            ['user update', 'users', 'Permite actualizar la información de un usuario', 'Actualizar Usuarios'],
            ['user delete', 'users', 'Permite eliminar un usuario', 'Eliminar Usuarios'],
            ['user restore', 'users', 'Permite restaurar un usuario eliminado anteriormente', 'Restaurar Usuario'],
            ['role list', 'roles', 'Permite acceder al listado de cargos', 'Listado de Cargos'],
            ['role create', 'roles', 'Permite crear un cargo', 'Crear Cargos'],
            ['role update', 'roles', 'Permite actualizar un cargo', 'Actualizar Cargos'],
            ['role delete', 'roles', 'Permite eliminar un cargo', 'Eliminar Cargos'],
            ['role restore', 'roles', 'Permite restaurar un cargo eliminado anteriormente', 'Restaurar Cargo'],
            ['permission list', 'permissions', 'Permite el acceso a la lista de permisos', 'Listado de Permisos'],
            ['permission update', 'permissions', 'Permite actualizar la información de un permiso', 'Actualizar Permisos'],
        ];
    }
}