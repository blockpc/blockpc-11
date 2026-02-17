<?php

declare(strict_types=1);

namespace Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Tests\Traits\ProtectTestEnvironment;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplicationTrait;
    use ProtectTestEnvironment;
    use RefreshDatabase;

    /**
     * Indicates whether the default seeder should run before each test.
     * Se desactiva en tests paralelos porque ya se hace en ParallelTesting.php
     *
     * @var bool
     */
    protected $seed = false;

    protected function setUp(): void
    {
        parent::setUp();

        $this->ensureSafeTestEnvironment();

        $this->withoutVite();

        // Crear directorio de vistas compiladas si no existe (para tests normales)
        if (!env('PEST_PARALLEL_WORKER_ID')) {
            $viewPath = storage_path('framework/testing/views');
            if (!is_dir($viewPath)) {
                mkdir($viewPath, 0755, true);
            }
            config(['view.compiled' => $viewPath]);
            $this->seed();
        }
    }
}
