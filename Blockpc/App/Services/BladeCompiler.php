<?php

declare(strict_types=1);

namespace Blockpc\App\Services;

use Illuminate\Support\Facades\ParallelTesting;

final class BladeCompiler extends \Illuminate\View\Compilers\BladeCompiler
{
    public function compile($path = null)
    {
        if (app()->runningUnitTests()) {
            $this->setCachePath(ParallelTesting::token());
        }

        return parent::compile($path);
    }

    protected function setCachePath(false|string $token): void
    {
        if (is_string($token)) {
            $this->cachePath = config('view.compiled').DIRECTORY_SEPARATOR."view_{$token}";

            if (! is_dir($this->cachePath)) {
                mkdir($this->cachePath, 0777, true);
            }
        }
    }
}
