<?php

declare(strict_types=1);

namespace Blockpc\App\Console\Services;

use App\Models\Permission;
use Blockpc\App\Console\Classes\PermissionList;
use Illuminate\Support\Collection;

final class PermissionSynchronizerService
{
    public function __construct()
    {
        //
    }

    public function sync(): void
    {
        foreach (PermissionList::all() as $permiso) {
            [$name, $key, $description, $displayName, $guard] = array_pad($permiso, 5, 'web');

            $permission = Permission::firstOrCreate(['name' => $name, 'guard_name' => $guard]);

            $permission->key = $key;
            $permission->description = $description;
            $permission->display_name = $displayName;
            $permission->save();
        }
    }

    public function getMissing(): Collection
    {
        return collect(PermissionList::all())
            ->filter(function ($permiso) {
                [$name, $key, $description, $displayName, $guard] = array_pad($permiso, 5, 'web');

                return ! Permission::where('name', $name)->where('guard_name', $guard)->exists();
            });
    }

    public function getOutdated(): Collection
    {
        return collect(PermissionList::all())
            ->filter(function ($permiso) {
                [$name, $key, $description, $displayName, $guard] = array_pad($permiso, 5, 'web');
                $perm = Permission::where('name', $name)->where('guard_name', $guard)->first();

                if (! $perm) {
                    return false;
                }

                return $perm->key !== $key
                    || $perm->description !== $description
                    || $perm->display_name !== $displayName;
            });
    }

    public function getOrphans(): Collection
    {
        $defined = collect(PermissionList::all())->map(fn ($p) => [
            'name' => $p[0],
            'guard_name' => $p[4] ?? 'web',
        ]);

        return Permission::all()->filter(function ($perm) use ($defined) {
            return ! $defined->contains(fn ($p) => $p['name'] === $perm->name && $p['guard_name'] === $perm->guard_name);
        });
    }

    public function prune(): int
    {
        $orphans = $this->getOrphans();
        foreach ($orphans as $orphan) {
            $orphan->delete();
        }

        return $orphans->count();
    }
}