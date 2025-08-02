<?php

declare(strict_types=1);

namespace Blockpc\App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use InvalidArgumentException;
use RuntimeException;
use Throwable;

final class CreateModuleCommand extends Command
{
    /**
     * Package name (capitalized)
     */
    protected string $package = '';

    /**
     * Package name (lowercase)
     */
    protected string $packageName = '';

    /**
     * Package name (camelCase)
     */
    protected string $camel_name = '';

    /**
     * Plural package name (camelCase)
     */
    protected string $plural_name = '';

    /**
     * Plural package name (snake_case)
     */
    protected string $snake_name = '';

    /**
     * Current date for migrations
     */
    protected string $date = '';

    /**
     * Model name
     */
    protected string $model_name = '';

    /**
     * Migration name
     */
    protected string $migration_name = '';

    /**
     * Factory name
     */
    protected string $factory_name = '';

    /**
     * Filesystem instance
     */
    protected Filesystem $files;

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
            $packageName = $this->getPackageName();
            if ($packageName === null) {
                return;
            }

            $this->initializePackageProperties($packageName);

            $addModel = $this->shouldAddModel();
            $modelName = null;

            if ($addModel) {
                $modelName = $this->getModelName();
                if ($modelName === null) {
                    return;
                }
                $this->initializeModelProperties($modelName);
            }

            $this->info('Creating package: '.$this->package);

            if (! $this->confirmCreation($addModel)) {
                $this->info('The command was canceled!');

                return;
            }

            $this->createPackageFiles($addModel, $modelName);
            $this->runPostCreationCommands();

            $this->info('The command was successful!');
        } catch (Throwable $th) {
            $this->handleError($th);
        }
    }

    /**
     * Get the stub path and the stub variables.
     */
    public function getSourceFile(string $key, bool $addModel = false, ?string $modelName = null): string
    {
        return $this->getStubContents($this->getStubPath($key), $this->getStubVariables($addModel, $modelName));
    }

    /**
     * Map the stub variables present in stub to its value.
     *
     * @return array<string, string>
     */
    public function getStubVariables(bool $addModel = false, ?string $modelName = null): array
    {
        $vars = [
            'PACKAGE' => $this->package,
            'NAME' => $this->packageName,
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
     * Replace the stub variables(key) with the desire value.
     *
     * @param  array<string, string>  $stubVariables
     */
    public function getStubContents(string $stub, array $stubVariables = []): string
    {
        $contents = file_get_contents($stub);

        if ($contents === false) {
            throw new RuntimeException("Unable to read stub file: {$stub}");
        }

        foreach ($stubVariables as $search => $replace) {
            $contents = str_replace('$'.$search.'$', $replace, $contents);
        }

        return $contents;
    }

    /**
     * Return the stub file path.
     */
    public function getStubPath(string $key): string
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

        if (! isset($stubs[$key])) {
            throw new InvalidArgumentException("Unknown stub key: {$key}");
        }

        return $stubs[$key];
    }

    /**
     * Build the directory for the class if necessary.
     */
    protected function makeDirectory(string $path): bool
    {
        if (! $this->files->isDirectory($path)) {
            return $this->files->makeDirectory($path, 0777, true, true);
        }

        return false;
    }

    /**
     * Get and validate package name from user input.
     */
    private function getPackageName(): ?string
    {
        $this->info('Recommended: The package name must be singular');
        $packageName = $this->ask('Choose your package name');

        if (! $this->isValidName($packageName)) {
            $this->error('Invalid package name. Only letters, numbers and underscores are allowed.');

            return null;
        }

        return $packageName;
    }

    /**
     * Validate if name follows the required pattern.
     */
    private function isValidName(?string $name): bool
    {
        return $name !== null && preg_match('/^[a-zA-Z][a-zA-Z0-9_]*$/', $name);
    }

    /**
     * Initialize package-related properties.
     */
    private function initializePackageProperties(string $packageName): void
    {
        $this->camel_name = Str::camel($packageName);
        $this->plural_name = Str::plural($this->camel_name);
        $this->snake_name = Str::snake($this->plural_name);
        $this->package = Str::ucfirst($this->camel_name);
        $this->packageName = mb_strtolower($this->package);
        $this->date = Carbon::now()->format('Y_m_d_Hmi');
    }

    /**
     * Ask user if they want to add a model.
     */
    private function shouldAddModel(): bool
    {
        return $this->confirm('¿Quieres agregar un modelo?');
    }

    /**
     * Get and validate model name from user input.
     */
    private function getModelName(): ?string
    {
        $modelName = $this->ask('¿Nombre del modelo?');

        if (! $this->isValidName($modelName)) {
            $this->error('Nombre de modelo inválido. Solo letras, números y guiones bajos.');

            return null;
        }

        return $modelName;
    }

    /**
     * Initialize model-related properties.
     */
    private function initializeModelProperties(string $modelName): void
    {
        $this->model_name = Str::ucfirst(Str::camel($modelName));
        $this->factory_name = $this->model_name.'Factory';
        $this->migration_name = 'create_'.Str::snake(Str::plural($modelName)).'_table';
    }

    /**
     * Show files to be created and confirm with user.
     */
    private function confirmCreation(bool $addModel): bool
    {
        $paths = $this->getSourceFilePath($addModel);

        $this->info('The following files will be created:');
        foreach ($paths as $path) {
            $this->info("File: {$path}");
        }

        return $this->confirm('Do you want to create the files?');
    }

    /**
     * Create all package files.
     */
    private function createPackageFiles(bool $addModel, ?string $modelName): void
    {
        $paths = $this->getSourceFilePath($addModel);

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
    }

    /**
     * Run post-creation Artisan commands.
     */
    private function runPostCreationCommands(): void
    {
        Artisan::call('blockpc:dump-autoload');
        Artisan::call('route:clear');
    }

    /**
     * Handle errors during package creation.
     */
    private function handleError(Throwable $th): void
    {
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

    /**
     * Get the full path of generate class.
     *
     * @return array<string, string>
     */
    private function getSourceFilePath(bool $addModel = false): array
    {
        $base = "Packages/{$this->package}";

        $paths = [
            'serviceprovider' => "{$base}/App/Providers/{$this->package}ServiceProvider.php",
            'config' => "{$base}/config/config.php",
            'route' => "{$base}/routes/web.php",
            'lang' => "{$base}/lang/en/{$this->packageName}.php",
            'livewire' => "{$base}/App/Livewire/{$this->package}.php",
            'view' => "{$base}/resources/views/livewire/{$this->packageName}.blade.php",
            'test' => "tests/Feature/Packages/{$this->package}/{$this->package}RouteTest.php",
        ];

        if ($addModel) {
            $paths['model'] = "{$base}/App/Models/{$this->model_name}.php";
            $paths['factory'] = "{$base}/database/factories/{$this->factory_name}.php";
            $paths['migration'] = "{$base}/database/migrations/{$this->date}_{$this->migration_name}.php";
        }

        return $paths;
    }
}
