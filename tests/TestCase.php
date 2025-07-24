<?php

declare(strict_types=1);

namespace Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Tests\Traits\IsolateViewStorage;
use Tests\Traits\ProtectTestEnvironment;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplicationTrait;
    use IsolateViewStorage;
    use ProtectTestEnvironment;
    use RefreshDatabase;

    /**
     * Indicates whether the default seeder should run before each test.
     *
     * @var bool
     */
    protected $seed = true;

    protected function setUp(): void
    {
        parent::setUp();

        $this->ensureSafeTestEnvironment();

        $this->withoutVite();

        // $this->isolateViewStorage();

        $this->seed();
    }
}
