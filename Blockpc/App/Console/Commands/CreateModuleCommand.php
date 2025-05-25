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

            $this->camel_name = Str::camel($packageName);           // foo_bar -> fooBar
            $this->plural_name = Str::plural($this->camel_name);    // fooBar -> fooBars
            $this->snake_name = Str::snake($this->plural_name);     // fooBars -> foo_bars
            $this->package = Str::ucfirst($this->camel_name);       // fooBar -> FooBar
            $this->name = strtolower($this->package);               // FooBar -> foobar
            $this->date = Carbon::now()->format('Y_m_d_Hmi');       // 2021_01_01_000000

            $this->info('Creating package: '.$this->package);

            $paths = $this->getSourceFilePath();

            $this->info('The following files will be created:');
            foreach ($paths as $key => $path) {
                $this->info("File: {$path}");
            }

            // ask if the user wants to create the files, if not, exit
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
                $this->files->put($path, $this->getSourceFile($key));
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
    public function getSourceFile($key)
    {
        return $this->getStubContents($this->getStubPath($key), $this->getStubVariables());
    }

    /**
     **
     * Map the stub variables present in stub to its value
     */
    public function getStubVariables(): array
    {
        return [
            'PACKAGE' => $this->package,
            'NAME' => $this->name,
            'TABLE' => $this->snake_name,
        ];
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
    private function getSourceFilePath(): array
    {
        $base = "Packages/{$this->package}";

        return [
            'serviceprovider' => "{$base}/App/Providers/{$this->package}ServiceProvider.php",
            'config' => "{$base}/config/config.php",
            'route' => "{$base}/routes/web.php",
            'lang' => "{$base}/lang/en/{$this->name}.php",
            'livewire' => "{$base}/App/Livewire/{$this->package}.php",
            'view' => "{$base}/resources/views/livewire/{$this->name}.blade.php",
            'migration' => "{$base}/database/migrations/{$this->date}_create_{$this->snake_name}_table.php",
            'model' => "{$base}/App/Models/{$this->package}.php",
            'factory' => "{$base}/database/factories/{$this->package}Factory.php",
            'test' => "tests/Feature/Packages/{$this->package}/{$this->package}RouteTest.php",
        ];
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
