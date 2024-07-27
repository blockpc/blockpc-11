<?php

namespace Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplicationTrait;
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutVite();

        $this->seed();
    }

    protected function setUpTraits()
    {
        $uses = parent::setUpTraits();

        // if (isset($uses[RefreshTestDatabase::class])) {
        //     $this->refreshTestDatabase();
        // }

        return $uses;
    }
}
