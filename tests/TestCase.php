<?php

namespace OsarisUk\Access\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use OsarisUk\Access\AccessServiceProvider;

class TestCase extends Orchestra
{
    protected function getPackageProviders($app)
    {
        return [
            AccessServiceProvider::class,
        ];
    }
}