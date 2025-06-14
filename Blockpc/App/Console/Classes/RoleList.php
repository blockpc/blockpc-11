<?php

declare(strict_types=1);

namespace Blockpc\App\Console\Classes;

final class RoleList
{
    /**
     * Devuelve todos los roles utilizados por el sistema.
     * Cada arreglo contiene:
     * - name: Nombre del rol
     * - display_name: Nombre para mostrar del rol
     * - description: Descripción del rol
     * - permissions: Lista de permisos asociados al rol (opcional, por defecto un arreglo vacio)
     * - guard_name: Nombre del guard (opcional, por defecto 'web')
     * [name, display_name, description, permissions, guard_name (opcional:web)]
     */
    public static function all(): array
    {
        // [name, display_name, description, permissions, guard_name (opcional:web)]
        return [
            [
                'name' => 'sudo',
                'display_name' => 'Super Administrador',
                'description' => 'Usuario del sistema con acceso total',
            ],
            [
                'name' => 'admin',
                'display_name' => 'Administrador',
                'description' => 'Usuario del sistema con acceso general',
                'permissions' => [
                    'user list'
                ],
            ],
            [
                'name' => 'user',
                'display_name' => 'Usuario',
                'description' => 'Usuario por defecto del sistema',
                'permissions' => [
                    // ... permisos de user
                ],
            ],
        ];
    }
}