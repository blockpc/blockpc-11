<?php

declare(strict_types=1);

namespace Blockpc\App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

final class CreateModuleCommand extends Command
{
    protected $module;

    protected $name;

    protected $camel_name;

    protected $plural_name;

    protected $snake_name;

    protected $date;

    protected $controller_name;

    protected $view_name;

    protected $route_name;

    protected $migration_name;

    protected $lang_name;

    protected $model_name;

    protected $serviceprovider_name;

    protected $config_name;

    protected $factory_name;

    /**
     * Filesystem instance
     *
     * @var Filesystem
     */
    protected $files;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'blockpc:package';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new package for the application.';

    /**
     * Create a new command instance.
     */
    public function __construct(Filesystem $files)
    {
        parent::__construct();
        $this->files = $files;
    }

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        try {
            $this->info('Recommended: The package name must be singular');
            $packageName = $this->ask('Choose your package name');

            // Validación del nombre del paquete
            if (! preg_match('/^[a-zA-Z][a-zA-Z0-9_]*$/', $packageName)) {
                $this->error('Invalid package name. Only letters, numbers and underscores are allowed.');

                return;
            }

            $this->camel_name = Str::camel($packageName);
            $this->plural_name = Str::plural($this->camel_name);
            $this->snake_name = Str::snake($this->plural_name);
            $this->package = Str::ucfirst($this->camel_name);
            $this->name = strtolower($this->package);
            $this->date = Carbon::now()->format('Y_m_d_Hmi');

            // NUEVO: Preguntar si quiere agregar modelo
            $addModel = $this->confirm('¿Quieres agregar un modelo?');
            $modelName = null;
            if ($addModel) {
                $modelName = $this->ask('¿Nombre del modelo?');
                // Validación simple del nombre del modelo
                if (! preg_match('/^[a-zA-Z][a-zA-Z0-9_]*$/', $modelName)) {
                    $this->error('Nombre de modelo inválido. Solo letras, números y guiones bajos.');

                    return;
                }
                $this->model_name = Str::ucfirst(Str::camel($modelName));
                $this->factory_name = $this->model_name.'Factory';
                $this->migration_name = 'create_'.Str::snake(Str::plural($modelName)).'_table';
            }

            $this->info('Creating package: '.$this->package);

            $paths = $this->getSourceFilePath($addModel);

            $this->info('The following files will be created:');
            foreach ($paths as $key => $path) {
                $this->info("File: {$path}");
            }

            if (! $this->confirm('Do you want to create the files?')) {
                $this->info('The command was canceled!');

                return;
            }

            foreach ($paths as $key => $path) {
                $this->makeDirectory(dirname($path));
                if ($this->files->exists($path)) {
                    if (! $this->confirm("File {$path} exists. Overwrite?")) {
                        $this->info("Skipped: {$path}");

                        continue;
                    }
                }
                $this->files->put($path, $this->getSourceFile($key, $addModel, $modelName));
                $this->info("Created: {$path}");
            }

            Artisan::call('blockpc:dump-autoload');
            Artisan::call('route:clear');

            $this->info('The command was successful!');
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            $this->error('Something went wrong: '.$th->getMessage());

            if ($this->files->isDirectory(base_path('Packages/'.$this->package))) {
                if ($this->files->deleteDirectory(base_path('Packages/'.$this->package))) {
                    $this->info("Delete: Packages/{$this->package}");
                } else {
                    $this->info("Something went wrong at delete: Packages/{$this->package}");
                }
            }
        }
    }

    /**
     * Get the stub path and the stub variables
     *
     * @return bool|mixed|string
     */
    public function getSourceFile($key, $addModel = false, $modelName = null)
    {
        return $this->getStubContents($this->getStubPath($key), $this->getStubVariables($addModel, $modelName));
    }

    /**
     **
     * Map the stub variables present in stub to its value
     */
    public function getStubVariables($addModel = false, $modelName = null): array
    {
        $vars = [
            'PACKAGE' => $this->package,
            'NAME' => $this->name,
            'TABLE' => $this->snake_name,
        ];

        if ($addModel && $modelName) {
            $vars['MODEL'] = $this->model_name;
            $vars['FACTORY'] = $this->factory_name;
            $vars['MIGRATION'] = $this->migration_name;
        }

        return $vars;
    }

    /**
     * Replace the stub variables(key) with the desire value
     *
     * @param  array  $stubVariables
     * @return bool|mixed|string
     */
    public function getStubContents($stub, $stubVariables = [])
    {
        $contents = file_get_contents($stub);

        foreach ($stubVariables as $search => $replace) {
            $contents = str_replace('$'.$search.'$', $replace, $contents);
        }

        return $contents;
    }

    /**
     * Build the directory for the class if necessary.
     *
     * @param  string  $path
     */
    protected function makeDirectory($path): bool
    {
        if (! $this->files->isDirectory($path)) {
            return $this->files->makeDirectory($path, 0777, true, true);
        }

        return false;
    }

    /**
     * Get the full path of generate class
     */
    private function getSourceFilePath($addModel = false): array
    {
        $base = "Packages/{$this->package}";

        $paths = [
            'serviceprovider' => "{$base}/App/Providers/{$this->package}ServiceProvider.php",
            'config' => "{$base}/config/config.php",
            'route' => "{$base}/routes/web.php",
            'lang' => "{$base}/lang/en/{$this->name}.php",
            'livewire' => "{$base}/App/Livewire/{$this->package}.php",
            'view' => "{$base}/resources/views/livewire/{$this->name}.blade.php",
            'test' => "tests/Feature/Packages/{$this->package}/{$this->package}RouteTest.php",
        ];

        if ($addModel) {
            $paths['model'] = "{$base}/App/Models/{$this->model_name}.php";
            $paths['factory'] = "{$base}/database/factories/{$this->factory_name}.php";
            $paths['migration'] = "{$base}/database/migrations/{$this->date}_{$this->migration_name}.php";
        }

        return $paths;
    }

    /**
     * Return the stub file path
     */
    public function getStubPath($key): string
    {
        $stubs = [
            'serviceprovider' => base_path('Blockpc/stubs/serviceprovider.stub'),
            'config' => base_path('Blockpc/stubs/config.stub'),
            'route' => base_path('Blockpc/stubs/route.stub'),
            'lang' => base_path('Blockpc/stubs/lang.stub'),
            'livewire' => base_path('Blockpc/stubs/livewire.stub'),
            'view' => base_path('Blockpc/stubs/view.stub'),
            'migration' => base_path('Blockpc/stubs/migration.stub'),
            'model' => base_path('Blockpc/stubs/model.stub'),
            'factory' => base_path('Blockpc/stubs/factory.stub'),
            'test' => base_path('Blockpc/stubs/test.stub'),
        ];

        return $stubs[$key];
    }
}
