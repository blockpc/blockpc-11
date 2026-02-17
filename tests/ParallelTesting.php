<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

use function Laravel\ParallelTesting\parallel;

// Configuración para tests paralelos

parallel()
    ->setUp(function ($worker) {
        // Configurar variables de entorno para el worker
        putenv("PEST_PARALLEL_WORKER_ID={$worker->id}");

        // Crear carpeta de vistas compiladas única por worker
        $customViewPath = storage_path("framework/testing/views/worker_{$worker->id}");
        if (! File::exists($customViewPath)) {
            File::makeDirectory($customViewPath, 0755, true);
        }

        // Configurar path de vistas compiladas para este worker
        config(['view.compiled' => $customViewPath]);
        putenv("VIEW_COMPILED_PATH={$customViewPath}");

        // Configurar base de datos única por worker
        $databaseName = 'testing_test_'.$worker->id;
        config(['database.connections.mysql.database' => $databaseName]);

        // Limpiar conexión y reconectar
        DB::purge('mysql');
        DB::reconnect('mysql');

        // Limpiar cachés una vez por worker
        \Illuminate\Support\Facades\Cache::flush();
    })
    ->tearDown(function ($worker) {
        // Eliminar vistas compiladas del worker al final
        $customViewPath = storage_path("framework/testing/views/worker_{$worker->id}");
        if (File::exists($customViewPath)) {
            File::deleteDirectory($customViewPath);
        }
    })
    ->setUpDatabase(function ($worker) {
        Artisan::call('migrate:fresh --seed');
    });
