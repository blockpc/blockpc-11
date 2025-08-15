<?php

declare(strict_types=1);

use Illuminate\Support\Facades\File;

// DeleteModuleCommandTest

beforeEach(function () {
    // Asegurar que no existan directorios antes de cada test
    File::deleteDirectory(base_path('Packages/TestDelete'));
    File::deleteDirectory(base_path('tests/Feature/Packages/TestDelete'));
});

afterEach(function () {
    // Limpiar después de cada test
    File::deleteDirectory(base_path('Packages/TestDelete'));
    File::deleteDirectory(base_path('tests/Feature/Packages/TestDelete'));
});

it('elimina un paquete existente cuando el usuario confirma', function () {
    // Preparar: crear el paquete primero
    createTestPackage();

    // Verificar que el paquete existe antes de eliminarlo
    expect(base_path('Packages/TestDelete'))->toBeDirectory();
    expect(base_path('tests/Feature/Packages/TestDelete'))->toBeDirectory();
    expect(base_path('Packages/TestDelete/App/Providers/TestDeleteServiceProvider.php'))->toBeFile();

    // Ejecutar comando de eliminación
    test()->artisan('blockpc:delete-package')
        ->expectsQuestion('What is the name of the package?', 'TestDelete')
        ->expectsConfirmation('Do you want to delete the package?', 'yes')
        ->expectsConfirmation('Are you sure you want to delete Packages/TestDelete?', 'yes')
        ->expectsConfirmation('Are you sure you want to delete tests/Feature/Packages/TestDelete?', 'yes')
        ->expectsOutput('Directory: Packages/TestDelete deleted!')
        ->expectsOutput('Directory: tests/Feature/Packages/TestDelete deleted!')
        ->expectsOutput('The package TestDelete was deleted successfully!')
        ->assertExitCode(0);

    // Verificar que el paquete ya no existe
    expect(base_path('Packages/TestDelete'))->not->toBeDirectory();
    expect(base_path('tests/Feature/Packages/TestDelete'))->not->toBeDirectory();
})->group('filesystem', 'slow');

it('cancela la eliminación cuando el usuario no confirma', function () {
    // Preparar: crear el paquete primero
    createTestPackage();

    // Verificar que el paquete existe antes de intentar eliminarlo
    expect(base_path('Packages/TestDelete'))->toBeDirectory();

    // Ejecutar comando de eliminación pero cancelar
    test()->artisan('blockpc:delete-package')
        ->expectsQuestion('What is the name of the package?', 'TestDelete')
        ->expectsConfirmation('Do you want to delete the package?', 'no')
        ->expectsOutput('The command was canceled!')
        ->assertExitCode(0);

    // Verificar que el paquete todavía existe
    expect(base_path('Packages/TestDelete'))->toBeDirectory();
    expect(base_path('tests/Feature/Packages/TestDelete'))->toBeDirectory();
})->group('filesystem', 'slow');

it('muestra error con nombre de paquete inválido', function () {
    test()->artisan('blockpc:delete-package')
        ->expectsQuestion('What is the name of the package?', '123Invalid')
        ->expectsOutput('Invalid package name. Only letters, numbers and underscores are allowed.')
        ->assertExitCode(0);
})->group('filesystem', 'slow');

it('maneja paquetes que no existen correctamente', function () {
    test()->artisan('blockpc:delete-package')
        ->expectsQuestion('What is the name of the package?', 'NonExistentPackage')
        ->expectsOutput('Path not found: Packages/NonExistentPackage')
        ->expectsOutput('Path not found: tests/Feature/Packages/NonExistentPackage')
        ->expectsConfirmation('Do you want to delete the package?', 'no')
        ->expectsOutput('The command was canceled!')
        ->assertExitCode(0);
})->group('filesystem', 'slow');

it('permite saltar la eliminación de directorios específicos', function () {
    // Preparar: crear el paquete primero
    createTestPackage();

    // Verificar que el paquete existe
    expect(base_path('Packages/TestDelete'))->toBeDirectory();
    expect(base_path('tests/Feature/Packages/TestDelete'))->toBeDirectory();

    // Ejecutar comando y saltar algunos directorios
    test()->artisan('blockpc:delete-package')
        ->expectsQuestion('What is the name of the package?', 'TestDelete')
        ->expectsConfirmation('Do you want to delete the package?', 'yes')
        ->expectsConfirmation('Are you sure you want to delete Packages/TestDelete?', 'yes')
        ->expectsConfirmation('Are you sure you want to delete tests/Feature/Packages/TestDelete?', 'no')
        ->expectsOutput('Directory: Packages/TestDelete deleted!')
        ->expectsOutput('Skipped: tests/Feature/Packages/TestDelete')
        ->expectsOutput('The package TestDelete was deleted successfully!')
        ->assertExitCode(0);

    // Verificar que solo se eliminó el directorio principal
    expect(base_path('Packages/TestDelete'))->not->toBeDirectory();
    expect(base_path('tests/Feature/Packages/TestDelete'))->toBeDirectory(); // Este debe seguir existiendo
})->group('filesystem', 'slow');

/**
 * Helper function para crear un paquete de prueba
 */
function createTestPackage(): void
{
    $packageDir = base_path('Packages/TestDelete');
    $testDir = base_path('tests/Feature/Packages/TestDelete');

    // Crear directorios
    File::makeDirectory($packageDir.'/App/Providers', 0755, true);
    File::makeDirectory($packageDir.'/config', 0755, true);
    File::makeDirectory($testDir, 0755, true);

    // Crear algunos archivos de ejemplo
    File::put($packageDir.'/App/Providers/TestDeleteServiceProvider.php', '<?php // Test service provider');
    File::put($packageDir.'/config/config.php', '<?php return [];');
    File::put($testDir.'/TestDeleteRouteTest.php', '<?php // Test route test');
}
