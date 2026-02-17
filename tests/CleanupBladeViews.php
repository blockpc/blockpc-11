<?php

declare(strict_types=1);

// Limpiar vistas compiladas de testing regular
$basePath = __DIR__.'/../storage/framework/testing/views';
if (is_dir($basePath)) {
    $dirs = array_filter(glob($basePath.'/*'), 'is_dir');

    foreach ($dirs as $dir) {
        foreach (glob($dir.'/*.php') as $file) {
            if (! unlink($file)) {
                error_log("Failed to delete file: $file");
            }
        }
        if (! rmdir($dir)) {
            error_log("Failed to remove directory: $dir");
        }
    }
}

// Limpiar vistas compiladas de workers paralelos
$workersBasePath = __DIR__.'/../storage/framework/views';
if (is_dir($workersBasePath)) {
    $workerDirs = array_filter(glob($workersBasePath.'/worker_*'), 'is_dir');

    foreach ($workerDirs as $dir) {
        foreach (glob($dir.'/*.php') as $file) {
            if (! unlink($file)) {
                error_log("Failed to delete worker file: $file");
            }
        }
        if (! rmdir($dir)) {
            error_log("Failed to remove worker directory: $dir");
        }
    }
}
