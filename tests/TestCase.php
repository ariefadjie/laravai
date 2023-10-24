<?php

namespace Ariefadjie\Laravai\Tests;

class TestCase extends \Orchestra\Testbench\TestCase
{
    protected function getPackageProviders($app)
    {
        return [
            \Ariefadjie\Laravai\LaravaiServiceProvider::class,
        ];
    }
}