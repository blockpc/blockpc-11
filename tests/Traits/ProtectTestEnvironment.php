<?php

declare(strict_types=1);

namespace Tests\Traits;

use Illuminate\Support\Facades\Artisan;

trait ProtectTestEnvironment
{
    protected function ensureSafeTestEnvironment(): void
    {
        if (! app()->environment('testing')) {
            exit("❌ Tests abortados: El entorno actual no es 'testing'.");
        }

        $db = config('database.connections.'.config('database.default').'.database');

        if (! str_contains($db, 'test') && ! str_contains($db, 'testing')) {
            exit("❌ Tests abortados: La base de datos '{$db}' no parece de testing.");
        }

        Artisan::call('route:clear');
        Artisan::call('config:clear');
    }
}
