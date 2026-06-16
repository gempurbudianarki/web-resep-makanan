<?php

namespace Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->artisan('migrate');
        $this->artisan('db:seed', ['--class' => 'RoleAndPermissionSeeder']);
        $this->artisan('db:seed', ['--class' => 'CategorySeeder']);
    }
}
