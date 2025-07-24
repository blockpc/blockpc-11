<?php

declare(strict_types=1);

namespace Blockpc\App\Console\Services;

use App\Models\Permission;
use App\Models\Role;
use Blockpc\App\Console\Classes\RoleList;
use Exception;
use Illuminate\Support\Collection;

final class RoleSynchronizerService
{
    public function sync(): void
    {
        foreach (RoleList::all() as $roleData) {
            $name = $roleData['name'];
            $display_name = $roleData['display_name'];
            $description = $roleData['description'];
            $permissions = $roleData['permissions'] ?? []; // si no viene, es array vacío
            $guard_name = $roleData['guard_name'] ?? 'web'; // si no viene, es 'web'

            // Buscar o crear el role
            $role = Role::firstOrCreate(
                ['name' => $name, 'guard_name' => $guard_name],
                ['display_name' => $display_name, 'description' => $description]
            );

            // Si ya existía, actualizamos los metadatos (por si cambian)
            $role->display_name = $display_name;
            $role->description = $description;
            $role->save();

            // Validar que todos los permisos existan
            $permissionIds = collect($permissions)->map(function ($permissionName) use ($guard_name) {
                $permission = Permission::where('name', $permissionName)
                    ->where('guard_name', $guard_name)
                    ->first();

                dump($permissionName);

                if (! $permission) {
                    throw new Exception("El permiso '{$permissionName}' no existe para el guard '{$guard_name}'");
                }

                return $permission->id;
            });

            // Sincronizar permisos del rol
            $role->syncPermissions($permissionIds);
        }
    }

    public function getMissing(): Collection
    {
        return collect(RoleList::all())
            ->filter(function ($roleData) {
                return ! Role::where('name', $roleData['name'])
                    ->where('guard_name', $roleData['guard'] ?? 'web')
                    ->exists();
            });
    }

    public function getOrphans(): Collection
    {
        $defined = collect(RoleList::all())->map(fn ($r) => [
            'name' => $r['name'],
            'guard_name' => $r['guard'] ?? 'web',
        ]);

        return Role::all()->filter(function ($role) use ($defined) {
            return ! $defined->contains(fn ($r) => $r['name'] === $role->name && $r['guard_name'] === $role->guard_name
            );
        });
    }
}
