<?php

declare(strict_types=1);

namespace Blockpc\App\Providers;

use Blockpc\App\Console\Commands\CreateModuleCommand;
use Blockpc\App\Console\Commands\DeleteModuleCommand;
use Blockpc\App\Console\Commands\DumpAutoloadCommand;
use Blockpc\App\Livewire\MessageAlerts;
use Blockpc\App\Mixins\QuerySearchMixin;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;
use Livewire\Livewire;

final class BlockpcServiceProvider extends ServiceProvider
{
    protected $menus;

    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->register(BlockpcAuthServiceProvider::class);

        Builder::mixin(new QuerySearchMixin);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $blockpc_dir = base_path('Blockpc/');

        Model::preventLazyLoading(! app()->isProduction());

        Carbon::setLocale(config('app.locale'));

        Password::defaults(function () {
            $rule = Password::min(8);

            return $this->app->isProduction()
                        ? $rule->mixedCase()->uncompromised()
                        : $rule;
        });

        if ($this->app->runningInConsole()) {
            $this->commands([
                DumpAutoloadCommand::class,
                CreateModuleCommand::class,
                DeleteModuleCommand::class,
            ]);
        }

        // Load Service Providers from packages
        $this->loadServiceProviders();

        // Load Views
        $this->loadViewsFrom($blockpc_dir.'resources/views', 'blockpc');

        // Load Livewire Components
        $this->loadWireComponents();

        $this->app->singleton('menus', function () {
            $this->checkHashMenus();

            return Cache::rememberForever('ordered_menus', function () {
                return $this->reorderMenus();
            });
        });
    }

    protected function loadWireComponents()
    {
        Livewire::component('message-alerts', MessageAlerts::class);
    }

    /**
     * Load Service Providers
     */
    protected function loadServiceProviders(): void
    {
        /** @var \Illuminate\Filesystem\Filesystem $files */
        $files = $this->app->make('files');
        $this->menus = [];

        $packagesPath = base_path('Packages');
        if (! $files->exists($packagesPath)) {
            return;
        }

        foreach ($files->directories($packagesPath) as $directory) {
            $directoryName = Str::afterLast($directory, DIRECTORY_SEPARATOR);
            $customServiceProvider = "Packages\\{$directoryName}\\App\\Providers\\{$directoryName}ServiceProvider";
            $pathServiceProvider = base_path("Packages/{$directoryName}/App/Providers/{$directoryName}ServiceProvider.php");

            if ($files->exists($pathServiceProvider)) {
                $this->app->register($customServiceProvider);
                $providerInstance = app($customServiceProvider);
                if (property_exists($providerInstance, 'config')) {
                    $this->menus = array_merge($providerInstance->config, $this->menus);
                }
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
