<?php

use Illuminate\Support\Facades\File;

// CreateModuleCommandTest

beforeEach(function () {
    // Limpia el directorio antes de cada test
    File::deleteDirectory(base_path('Packages/Example'));
    File::deleteDirectory(base_path('tests/Feature/Packages/Example'));
})->skip('temporarily unavailable when run tests in parallel');

afterEach(function () {
    // Limpia el directorio después de cada test
    File::deleteDirectory(base_path('Packages/Example'));
    File::deleteDirectory(base_path('tests/Feature/Packages/Example'));
});

it('crea un paquete con modelo, factory y migración si el usuario lo desea', function () {
    set_carbon();

    test()->artisan('blockpc:package')
        ->expectsQuestion('Choose your package name', 'Example')
        ->expectsConfirmation('¿Quieres agregar un modelo?', 'yes')
        ->expectsQuestion('¿Nombre del modelo?', 'Producto')
        ->expectsConfirmation('Do you want to create the files?', 'yes')
        ->expectsOutput('Creating package: Example')
        ->assertExitCode(0);

    // Archivos base
    expect(base_path('Packages/Example/App/Providers/ExampleServiceProvider.php'))->toBeFile();
    expect(base_path('Packages/Example/config/config.php'))->toBeFile();
    expect(base_path('Packages/Example/routes/web.php'))->toBeFile();
    expect(base_path('Packages/Example/lang/en/example.php'))->toBeFile();
    expect(base_path('Packages/Example/App/Livewire/Example.php'))->toBeFile();
    expect(base_path('Packages/Example/resources/views/livewire/example.blade.php'))->toBeFile();
    expect(base_path('tests/Feature/Packages/Example/ExampleRouteTest.php'))->toBeFile();

    // Archivos de modelo
    expect(base_path('Packages/Example/App/Models/Producto.php'))->toBeFile();
    expect(base_path('Packages/Example/database/factories/ProductoFactory.php'))->toBeFile();
    // La migración debe tener el nombre correcto
    $migrationFiles = File::files(base_path('Packages/Example/database/migrations'));
    $migration = collect($migrationFiles)->first(fn ($f) => str_contains($f->getFilename(), 'create_productos_table.php'));
    expect($migration)->not->toBeNull();
});

it('crea un paquete sin modelo, factory ni migración si el usuario no lo desea', function () {
    set_carbon();

    test()->artisan('blockpc:package')
        ->expectsQuestion('Choose your package name', 'Example')
        ->expectsConfirmation('¿Quieres agregar un modelo?', 'no')
        ->expectsConfirmation('Do you want to create the files?', 'yes')
        ->expectsOutput('Creating package: Example')
        ->assertExitCode(0);

    // Archivos base
    expect(base_path('Packages/Example/App/Providers/ExampleServiceProvider.php'))->toBeFile();
    expect(base_path('Packages/Example/config/config.php'))->toBeFile();
    expect(base_path('Packages/Example/routes/web.php'))->toBeFile();
    expect(base_path('Packages/Example/lang/en/example.php'))->toBeFile();
    expect(base_path('Packages/Example/App/Livewire/Example.php'))->toBeFile();
    expect(base_path('Packages/Example/resources/views/livewire/example.blade.php'))->toBeFile();
    expect(base_path('tests/Feature/Packages/Example/ExampleRouteTest.php'))->toBeFile();

    // Archivos de modelo NO deben existir
    expect(base_path('Packages/Example/App/Models/Producto.php'))->not->toBeFile();
    expect(base_path('Packages/Example/database/factories/ProductoFactory.php'))->not->toBeFile();
    expect(File::exists(base_path('Packages/Example/database/migrations')))->toBeFalse();
});
