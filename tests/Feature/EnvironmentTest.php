<?php

declare(strict_types=1);

uses()->group('environment');

beforeEach(function () {
    $this->user = new_user();
});

// EnvironmentTest

// EnvironmentTest

test('tests are running in the correct environment', function () {
    $this->assertEquals('testing', app()->environment());
    $this->assertDatabaseHas('users', ['id' => $this->user->id]); // según lo que sepas
});

test('aborts if environment is not testing', function () {
    $this->assertEquals('testing', app()->environment(), 'El entorno no es testing');
});

test('route cache is not enabled during tests', function () {
    $cachedRoutesFile = base_path('bootstrap/cache/routes-v7.php');

    if (file_exists($cachedRoutesFile)) {
        $this->fail("⚠️ Las rutas están cacheadas en {$cachedRoutesFile}. Ejecutá `php artisan route:clear`.");
    }

    $this->assertTrue(true); // por si el archivo no existe, que no marque como "sin assertions"
});
