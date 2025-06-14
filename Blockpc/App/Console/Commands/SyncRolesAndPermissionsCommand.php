<?php

declare(strict_types=1);

namespace Blockpc\App\Console\Commands;

use Blockpc\App\Console\Services\PermissionSynchronizerService;
use Blockpc\App\Console\Services\RoleSynchronizerService;

final class SyncRolesAndPermissionsCommand extends \Illuminate\Console\Command
{
    protected $signature = 'blockpc:sync-all {--ci}';
    protected $description = 'Sincroniza roles y permisos definidos en código';

    public function handle(
        PermissionSynchronizerService $permissionSync,
        RoleSynchronizerService $roleSync
    ) {
        $this->info("🔄 Sincronizando permisos...");
        $permissionSync->sync();

        $this->info("🔄 Sincronizando roles...");
        $roleSync->sync();

        $missingPerms = $permissionSync->getMissing();
        $orphanPerms = $permissionSync->getOrphans();

        $missingRoles = $roleSync->getMissing();
        $orphanRoles = $roleSync->getOrphans();

        if ($missingPerms->isEmpty() && $orphanPerms->isEmpty() && $missingRoles->isEmpty() && $orphanRoles->isEmpty()) {
            $this->info("✅ Todo está perfectamente sincronizado.");
            return;
        }

        if (!$missingPerms->isEmpty()) {
            $this->error("❌ Permisos faltantes:");
            foreach ($missingPerms as $perm) {
                $this->line("- {$perm[0]}");
            }
        }

        if (!$orphanPerms->isEmpty()) {
            $this->warn("⚠️ Permisos huérfanos:");
            foreach ($orphanPerms as $perm) {
                $this->line("- {$perm->name}");
            }
        }

        if (!$missingRoles->isEmpty()) {
            $this->error("❌ Roles faltantes:");
            foreach ($missingRoles as $role) {
                $this->line("- {$role['name']}");
            }
        }

        if (!$orphanRoles->isEmpty()) {
            $this->warn("⚠️ Roles huérfanos:");
            foreach ($orphanRoles as $role) {
                $this->line("- {$role->name}");
            }
        }

        if ($this->option('ci')) {
            exit(1);
        }
    }
}