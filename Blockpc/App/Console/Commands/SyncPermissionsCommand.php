<?php

declare(strict_types=1);

namespace Blockpc\App\Console\Commands;

use Blockpc\App\Console\Services\PermissionSynchronizerService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

final class SyncPermissionsCommand extends Command
{
    protected $signature = 'blockpc:permissions-sync
                            {--check : Solo verificar permisos existentes}
                            {--orphans : Mostrar permisos huérfanos}
                            {--prune : Eliminar permisos huérfanos}
                            {--ci : Modo continuo para CI/CD}';

    protected $description = 'Sincroniza, valida y limpia los permisos definidos en el sistema';

    public function handle(PermissionSynchronizerService $sync): void
    {
        $errors = 0;

        if ($this->option('check')) {
            $missing = $sync->getMissing();

            if ($missing->isEmpty()) {
                $this->info('✅ Todo sincronizado.');
            } else {
                $this->warn('⚠️  Permisos faltantes:');
                foreach ($missing as $perm) {
                    $name = $perm[0];
                    $guard = $perm[4] ?? 'web';
                    $this->warn("❌ Falta permiso: {$name} (guard: {$guard})");
                    $errors++;
                }
            }
        } elseif ($this->option('orphans')) {
            $orphans = $sync->getOrphans();

            if ($orphans->isEmpty()) {
                $this->info('✅ No hay permisos huérfanos.');
            } else {
                $this->warn('⚠️  Permisos huérfanos:');
                foreach ($orphans as $orphan) {
                    $this->line("- {$orphan->name} ({$orphan->guard_name})");
                }
                $errors += $orphans->count();
            }
        } elseif ($this->option('prune')) {
            $orphans = $sync->getOrphans();
            if ($orphans->isEmpty()) {
                $this->info('✅ No hay permisos huérfanos.');

                return;
            }
            if (! $this->option('ci') && ! $this->confirm("¿Eliminar {$orphans->count()} permisos huérfanos?", false)) {
                $this->info('🛑 Cancelado.');

                return;
            }
            $deleted = $sync->prune();
            $this->info("🗑️ Eliminados: {$deleted} permisos huérfanos.");
        } else {
            $sync->sync();
            $this->info('🎉 Permisos sincronizados.');
        }

        if ($this->option('ci') && $errors > 0) {
			$this->error("Errores de sincronización de permisos: {$errors}");
            Log::error("Errores de sincronización de permisos: {$errors}");
            exit(1);
        }
    }
}
