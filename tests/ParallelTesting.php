<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

use function Laravel\ParallelTesting\parallel;

uses()
    ->beforeEach(function () {
        // Limpieza general antes de cada test individual si fuera necesario
        Artisan::call('icons:cache');
        Artisan::call('view:cache');
    });

parallel()
    ->setUp(function ($worker) {
        // Crear una carpeta de vistas compiladas única por worker
        $customViewPath = storage_path("framework/views/worker_{$worker->id}");
        if (! File::exists($customViewPath)) {
            File::makeDirectory($customViewPath, 0755, true);
        }

        // Redefinir el path de vistas compiladas solo para este worker
        config(['view.compiled' => $customViewPath]);

        // Limpiar y recompilar vistas para evitar conflictos

        Artisan::call('view:clear');
        Artisan::call('cache:clear');
        Artisan::call('config:clear');

        $databaseName = 'testing_test_'.$worker->id;

        config(['database.connections.mysql.database' => $databaseName]);

        DB::purge('mysql'); // Limpia la conexión anterior
        DB::reconnect('mysql'); // Reconecta con la nueva configuración
    })
    ->tearDown(function ($worker) {
        // Eliminar vistas compiladas del worker al final si querés dejar limpio
        $customViewPath = storage_path("framework/views/worker_{$worker->id}");
        if (File::exists($customViewPath)) {
            File::deleteDirectory($customViewPath);
        }
    })
    ->setUpDatabase(function ($worker) {
        Artisan::call('migrate:fresh --seed');
    });
