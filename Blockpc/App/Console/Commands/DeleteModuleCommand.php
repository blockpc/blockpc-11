<?php

declare(strict_types=1);

namespace Blockpc\App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;

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
        $this->info('Delete a package for the application.');

        $packageName = $this->ask('What is the name of the package?');

        $this->camel_name = Str::camel($packageName);           // foo_bar -> fooBar
        $this->plural_name = Str::plural($this->camel_name);    // fooBar -> fooBars
        $this->snake_name = Str::snake($this->plural_name);     // fooBars -> foo_bars
        $this->package = Str::ucfirst($this->camel_name);       // fooBar -> FooBar
        $this->name = strtolower($this->package);               // FooBar -> foobar

        $paths = $this->getSourceFilePath();

        $this->info('The following files will be deleted:');
        foreach ($paths as $key => $path) {
            $this->info("Directory: {$path}");
        }

        // ask if the user wants to delete the package, if not, exit
        if (! $this->confirm('Do you want to delete the package?')) {
            $this->info('The command was canceled!');

            return;
        }

        $this->deletePackage($paths);
    }

    private function deletePackage($paths): void
    {
        $this->info('Deleting package...');

        foreach ($paths as $key => $path) {
            $this->info("Deleting directory: {$path}");

            $this->deleteFiles($path);
        }

        $this->info("The package {$this->package} was deleted!");

        Artisan::call('blockpc:dump-autoload');
        Artisan::call('route:clear');
    }

    private function deleteFiles($package)
    {
        $files = glob($package);

        foreach ($files as $file) {

            if (is_file($file)) {
                $this->info("File: {$file} deleted!");

                return unlink($file);
            }

            if (is_dir($file)) {
                $this->info("Directory: {$file}");

                // Get the list of the files in this directory
                $scan = glob(rtrim($file, '/').'/*');

                // Loop through the list of files
                foreach ($scan as $index => $path) {

                    // Call recursive function
                    $this->deleteFiles($path);
                }

                // Remove the directory itself
                return @rmdir($file);
            }
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
