<?php

namespace Exlo89\LaravelSevdeskApi\Tests;

use Exlo89\LaravelSevdeskApi\SevdeskApiServiceProvider;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

class TestCase extends OrchestraTestCase
{
    /**
     * Load package alias
     * @param  \Illuminate\Foundation\Application $app
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            SevdeskApiServiceProvider::class,
        ];
    }
}
