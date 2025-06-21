<?php

declare(strict_types=1);

namespace Blockpc\App\Console\Commands;

use Blockpc\App\Console\Services\RoleSynchronizerService;
use Illuminate\Support\Facades\Log;

final class SyncRolesCommand extends \Illuminate\Console\Command
{
    protected $signature = 'blockpc:roles-sync
                            {--check : Solo verificar roles existentes}
                            {--orphans : Mostrar roles huérfanos}
                            {--prune : Eliminar roles huérfanos}
                            {--ci : Modo continuo para CI/CD}';

    protected $description = 'Sincroniza, valida y limpia los roles definidos en el sistema';

    public function handle(RoleSynchronizerService $sync): void
    {
        $errors = 0;

        if ($this->option('check')) {
            $missing = $sync->getMissing();

            if ($missing->isEmpty()) {
                $this->info('✅ Todo sincronizado.');
            } else {
                $this->warn('⚠️  Roles faltantes:');
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
                $this->info('✅ No hay roles huérfanos.');
            } else {
                $this->warn('⚠️  Roles huérfanos:');
                foreach ($orphans as $orphan) {
                    $this->line("- {$orphan->name} ({$orphan->guard_name})");
                }
                $errors += $orphans->count();
            }
        } elseif ($this->option('prune')) {
            $orphans = $sync->getOrphans();
            if ($orphans->isEmpty()) {
                $this->info('✅ No hay roles huérfanos.');

                return;
            }
            if (! $this->option('ci') && ! $this->confirm("¿Eliminar {$orphans->count()} roles huérfanos?", false)) {
                $this->info('🛑 Cancelado.');

                return;
            }
            $deleted = $sync->prune();
            $this->info("🗑️ Eliminados: {$deleted} roles huérfanos.");
        } else {
            $sync->sync();
            $this->info('🎉 Roles sincronizados.');
        }

        if ($this->option('ci') && $errors > 0) {
            $this->error("Errores de sincronización de roles: {$errors}");
            Log::error("Errores de sincronización de roles: {$errors}");
            exit(1);
        }
    }
}
