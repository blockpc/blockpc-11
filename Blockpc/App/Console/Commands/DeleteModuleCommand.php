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
     * Filesystem instance
     */
    protected Filesystem $files;

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
            $packageName = $this->getPackageName();
            if ($packageName === null) {
                return;
            }

            $this->initializePackageProperties($packageName);

            if (! $this->confirmDeletion()) {
                $this->info('The command was canceled!');

                return;
            }

            $this->deletePackageFiles();
            $this->runPostDeletionCommands();

            $this->info("The package {$this->package} was deleted successfully!");
        } catch (Throwable $th) {
            $this->handleError($th);
        }
    }

    /**
     * Get and validate package name from user input.
     */
    private function getPackageName(): ?string
    {
        $this->info('Delete a package for the application.');
        $packageName = $this->ask('What is the name of the package?');

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
    }

    /**
     * Show paths to be deleted and confirm with user.
     */
    private function confirmDeletion(): bool
    {
        $paths = $this->getSourceFilePath();

        $this->info('The following files/directories will be deleted:');
        foreach ($paths as $path) {
            if ($this->files->exists($path)) {
                $this->info("Directory: {$path}");
            } else {
                $this->warn("Path not found: {$path}");
            }
        }

        return $this->confirm('Do you want to delete the package?');
    }

    /**
     * Delete all package files and directories.
     */
    private function deletePackageFiles(): void
    {
        $paths = $this->getSourceFilePath();

        foreach ($paths as $path) {
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
    }

    /**
     * Run post-deletion Artisan commands.
     */
    private function runPostDeletionCommands(): void
    {
        Artisan::call('blockpc:dump-autoload');
        Artisan::call('route:clear');
    }

    /**
     * Handle errors during package deletion.
     */
    private function handleError(Throwable $th): void
    {
        $this->error('Something went wrong: '.$th->getMessage());
    }

    /**
     * Delete files or directories recursively using Laravel's Filesystem.
     */
    private function deleteFiles(string $path): void
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
     * Get the full path of package directories to delete.
     *
     * @return array<string>
     */
    private function getSourceFilePath(): array
    {
        return [
            "Packages/{$this->package}",
            "tests/Feature/Packages/{$this->package}",
        ];
    }
}
