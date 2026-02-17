<?php

declare(strict_types=1);

namespace Blockpc\App\Providers;

use Illuminate\View\DynamicComponent;

final class ViewServiceProvider extends \Illuminate\View\ViewServiceProvider
{
    // BladeCompiler personalizado removido - usando el de Laravel por defecto
    // para evitar conflictos en tests paralelos

    /*
    public function registerBladeCompiler()
    {
        $this->app->singleton('blade.compiler', function ($app) {
            return tap(new BladeCompiler(
                $app['files'],
                $app['config']['view.compiled'],
                $app['config']->get('view.relative_hash', false) ? $app->basePath() : '',
                $app['config']->get('view.cache', true),
                $app['config']->get('view.compiled_extension', 'php'),
                $app['config']->get('view.check_cache_timestamps', true),
            ), function ($blade) {
                $blade->component('dynamic-component', DynamicComponent::class);
            });
        });
    }
    */
}
