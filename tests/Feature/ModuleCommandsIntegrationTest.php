<?php

declare(strict_types=1);

use Illuminate\Support\Facades\File;

// ModuleCommandsIntegrationTest

beforeEach(function () {
    // Limpiar antes de cada test
    File::deleteDirectory(base_path('Packages/IntegrationTest'));
    File::deleteDirectory(base_path('tests/Feature/Packages/IntegrationTest'));
});

afterEach(function () {
    // Limpiar después de cada test
    File::deleteDirectory(base_path('Packages/IntegrationTest'));
    File::deleteDirectory(base_path('tests/Feature/Packages/IntegrationTest'));
});

it('puede crear y luego eliminar un paquete completamente', function () {
    set_carbon();

    // Paso 1: Crear el paquete
    test()->artisan('blockpc:package')
        ->expectsQuestion('Choose your package name', 'IntegrationTest')
        ->expectsConfirmation('¿Quieres agregar un modelo?', 'yes')
        ->expectsQuestion('¿Nombre del modelo?', 'TestModel')
        ->expectsConfirmation('Do you want to create the files?', 'yes')
        ->expectsOutput('Creating package: IntegrationTest')
        ->assertExitCode(0);

    // Verificar que el paquete fue creado
    expect(base_path('Packages/IntegrationTest'))->toBeDirectory();
    expect(base_path('Packages/IntegrationTest/App/Providers/IntegrationTestServiceProvider.php'))->toBeFile();
    expect(base_path('Packages/IntegrationTest/App/Models/TestModel.php'))->toBeFile();
    expect(base_path('tests/Feature/Packages/IntegrationTest'))->toBeDirectory();

    // Paso 2: Eliminar el paquete
    test()->artisan('blockpc:delete-package')
        ->expectsQuestion('What is the name of the package?', 'IntegrationTest')
        ->expectsConfirmation('Do you want to delete the package?', 'yes')
        ->expectsConfirmation('Are you sure you want to delete Packages/IntegrationTest?', 'yes')
        ->expectsConfirmation('Are you sure you want to delete tests/Feature/Packages/IntegrationTest?', 'yes')
        ->expectsOutput('The package IntegrationTest was deleted successfully!')
        ->assertExitCode(0);

    // Verificar que el paquete fue eliminado completamente
    expect(base_path('Packages/IntegrationTest'))->not->toBeDirectory();
    expect(base_path('tests/Feature/Packages/IntegrationTest'))->not->toBeDirectory();
})->group('filesystem', 'slow', 'integration');

it('puede crear un paquete sin modelo y luego eliminarlo', function () {
    set_carbon();

    // Paso 1: Crear el paquete sin modelo
    test()->artisan('blockpc:package')
        ->expectsQuestion('Choose your package name', 'IntegrationTest')
        ->expectsConfirmation('¿Quieres agregar un modelo?', 'no')
        ->expectsConfirmation('Do you want to create the files?', 'yes')
        ->expectsOutput('Creating package: IntegrationTest')
        ->assertExitCode(0);

    // Verificar que el paquete fue creado sin archivos de modelo
    expect(base_path('Packages/IntegrationTest'))->toBeDirectory();
    expect(base_path('Packages/IntegrationTest/App/Providers/IntegrationTestServiceProvider.php'))->toBeFile();
    expect(base_path('Packages/IntegrationTest/App/Models'))->not->toBeDirectory();
    expect(base_path('tests/Feature/Packages/IntegrationTest'))->toBeDirectory();

    // Paso 2: Eliminar el paquete
    test()->artisan('blockpc:delete-package')
        ->expectsQuestion('What is the name of the package?', 'IntegrationTest')
        ->expectsConfirmation('Do you want to delete the package?', 'yes')
        ->expectsConfirmation('Are you sure you want to delete Packages/IntegrationTest?', 'yes')
        ->expectsConfirmation('Are you sure you want to delete tests/Feature/Packages/IntegrationTest?', 'yes')
        ->expectsOutput('The package IntegrationTest was deleted successfully!')
        ->assertExitCode(0);

    // Verificar que el paquete fue eliminado completamente
    expect(base_path('Packages/IntegrationTest'))->not->toBeDirectory();
    expect(base_path('tests/Feature/Packages/IntegrationTest'))->not->toBeDirectory();
})->group('filesystem', 'slow', 'integration');
