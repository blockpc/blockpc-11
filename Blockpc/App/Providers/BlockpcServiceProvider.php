<?php

declare(strict_types=1);

namespace Blockpc\App\Providers;

use Blockpc\App\Console\Commands\CreateModuleCommand;
use Blockpc\App\Console\Commands\DeleteModuleCommand;
use Blockpc\App\Console\Commands\DumpAutoloadCommand;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\ServiceProvider;

final class BlockpcServiceProvider extends ServiceProvider
{
    protected $menus;

    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->register(BlockpcAuthServiceProvider::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                DumpAutoloadCommand::class,
                CreateModuleCommand::class,
                DeleteModuleCommand::class,
            ]);
        }

        // Load Service Providers from packages
        $this->loadServiceProviders();

        $this->app->singleton('menus', function () {
            $this->checkHashMenus();

            return Cache::rememberForever('ordered_menus', function () {
                return $this->reorderMenus();
            });

            return $this->menus;
        });
    }

    /**
     * Load Service Providers
     */
    protected function loadServiceProviders(): void
    {
        /** @var \Illuminate\Filesystem\Filesystem $files */
        $files = $this->app->make('files');
        $this->menus = [];

        foreach ($files->directories(base_path('Packages')) as $directory) {

            $directoryName = last(explode(DIRECTORY_SEPARATOR, $directory));
            $customServiceProvider = "Packages\\{$directoryName}\\App\\Providers\\{$directoryName}ServiceProvider";
            $pathServiceProvider = base_path("Packages/{$directoryName}/App/Providers/{$directoryName}ServiceProvider.php");

            if ($files->exists($pathServiceProvider)) {
                $app = $this->app->register($customServiceProvider);
                $this->menus = array_merge($app->menus, $this->menus);
            }
        }
    }

    private function checkHashMenus(): void
    {
        $ids = array_map(function ($menu) {
            return $menu['id'] ?? 0;
        }, $this->menus);
        $currentKeysHash = md5(implode(',', $ids));

        if (Cache::get('menus_keys_hash') !== $currentKeysHash) {
            // Si las claves han cambiado, borra la caché
            Cache::forget('ordered_menus');
            Cache::put('menus_keys_hash', $currentKeysHash);
        }
    }

    private function reorderMenus()
    {
        $menus = $this->menus;

        // Ordenando los menus segun su id
        uasort($menus, function ($a, $b) {
            if (isset($a['id']) && isset($b['id'])) {
                return $a['id'] <=> $b['id'];
            }
            if (! isset($a['id'])) {
                return 1;
            }
            if (! isset($b['id'])) {
                return -1;
            }
        });

        return $menus;
    }
}
