<?php


namespace Exlo89\LaravelSevdeskApi\Tests;


use Exlo89\LaravelSevdeskApi\LaravelSevdeskApiServiceProvider;

class TestCase extends \Orchestra\Testbench\TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        // additional setup
    }

    protected function getPackageProviders($app)
    {
        return [
            LaravelSevdeskApiServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        // perform environment setup
    }
}
