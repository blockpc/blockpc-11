<?php

declare(strict_types=1);

namespace Blockpc\App\Console\Commands;

use App\Models\Permission;
use Blockpc\App\Console\Classes\PermissionList;
use Illuminate\Console\Command;

final class RegisterPermissionsCommand extends Command
{
    protected $signature = 'blockpc:permissions-register';

    protected $description = 'Registra los permisos necesarios para nuevas funcionalidades del sistema';

    public function handle()
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

            $this->info("✅ Permiso registrado o actualizado: {$name}");
        }

        $this->info('🎉 Registro de permisos completado.');
    }
}
