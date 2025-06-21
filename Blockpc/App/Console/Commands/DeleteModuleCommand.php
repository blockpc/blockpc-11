<?php

declare(strict_types=1);

namespace Blockpc\App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;
use Throwable;

final class DeleteModuleCommand extends Command
{
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
    protected $signature = 'blockpc:delete-package';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete a new package for the application.';

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
            $this->info('Delete a package for the application.');

            $packageName = $this->ask('What is the name of the package?');

            // Validar el nombre del paquete
            if (! preg_match('/^[a-zA-Z][a-zA-Z0-9_]*$/', $packageName)) {
                $this->error('Invalid package name. Only letters, numbers and underscores are allowed.');

                return;
            }

            $this->camel_name = Str::camel($packageName);           // foo_bar -> fooBar
            $this->plural_name = Str::plural($this->camel_name);    // fooBar -> fooBars
            $this->snake_name = Str::snake($this->plural_name);     // fooBars -> foo_bars
            $this->package = Str::ucfirst($this->camel_name);       // fooBar -> FooBar
            $this->name = mb_strtolower($this->package);               // FooBar -> foobar

            $paths = $this->getSourceFilePath();

            $this->info('The following files/directories will be deleted:');
            foreach ($paths as $key => $path) {
                $this->info("Directory: {$path}");
            }

            // Confirmar antes de eliminar
            if (! $this->confirm('Do you want to delete the package?')) {
                $this->info('The command was canceled!');

                return;
            }

            foreach ($paths as $key => $path) {
                if ($this->files->exists($path)) {
                    if ($this->confirm("Are you sure you want to delete {$path}?")) {
                        $this->deleteFiles($path);
                    } else {
                        $this->info("Skipped: {$path}");
                    }
                } else {
                    $this->warn("Path not found: {$path}");
                }
            }

            $this->info("The package {$this->package} was deleted!");

            Artisan::call('blockpc:dump-autoload');
            Artisan::call('route:clear');
        } catch (Throwable $th) {
            $this->error('Something went wrong: '.$th->getMessage());
        }
    }

    /**
     * Elimina archivos o directorios de forma recursiva usando Filesystem de Laravel.
     */
    private function deleteFiles($path)
    {
        if ($this->files->exists($path)) {
            if ($this->files->isDirectory($path)) {
                $this->files->deleteDirectory($path);
                $this->info("Directory: {$path} deleted!");
            } else {
                $this->files->delete($path);
                $this->info("File: {$path} deleted!");
            }
        } else {
            $this->warn("Path not found: {$path}");
        }
    }

    /**
     * Get the full path of generate class
     */
    private function getSourceFilePath(): array
    {
        return [
            'package' => "Packages/{$this->package}",
            'test' => "tests/Feature/Packages/{$this->package}",
        ];
    }
}
