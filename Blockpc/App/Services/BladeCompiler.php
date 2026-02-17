<?php

declare(strict_types=1);

namespace Blockpc\App\Services;

final class BladeCompiler extends \Illuminate\View\Compilers\BladeCompiler
{
    public function compile($path = null)
    {
        // Temporalmente deshabilitado para tests paralelos
        // Solo usar el compilador base de Laravel
        return parent::compile($path);
    }

    protected function setCachePath(): void
    {
        // Método deshabilitado temporalmente
    }
}
