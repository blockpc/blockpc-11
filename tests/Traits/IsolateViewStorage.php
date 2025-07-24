<?php

declare(strict_types=1);

namespace Tests\Traits;

use Illuminate\View\Engines\CompilerEngine;

trait IsolateViewStorage
{

    protected function isolateViewStorage(): void
    {
        $pid = getmypid();
        $path = storage_path("framework/testing/views/{$pid}");

        if (!is_dir($path)) {
            mkdir($path, 0755, true);
        }

        // Re-registra el servicio con un path de compilación distinto
        app()->extend('view.engine.resolver', function ($resolver) use ($path) {
            $resolver->register('blade', function () use ($path) {
                $compiler = new \Illuminate\View\Compilers\BladeCompiler(app('files'), $path);

                return new CompilerEngine($compiler);
            });

            return $resolver;
        });
    }

}
