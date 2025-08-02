<?php

declare(strict_types=1);

use Illuminate\Support\Facades\File;

/**
 * Helper function para generar nombres únicos para tests en paralelo
 */
function getUniqueTestName(string $baseName): string
{
    $processId = getmypid();
    $timestamp = time();

    return "{$baseName}_{$processId}_{$timestamp}";
}

/**
 * Helper function para generar directorios únicos para tests
 */
function getUniqueTestPaths(string $packageName): array
{
    return [
        'package' => base_path("Packages/{$packageName}"),
        'test' => base_path("tests/Feature/Packages/{$packageName}"),
    ];
}

/**
 * Helper function para limpiar directorios de test
 */
function cleanupTestDirectories(string $packageName): void
{
    $paths = getUniqueTestPaths($packageName);

    foreach ($paths as $path) {
        if (File::exists($path)) {
            if (File::isDirectory($path)) {
                File::deleteDirectory($path);
            } else {
                File::delete($path);
            }
        }
    }
}
