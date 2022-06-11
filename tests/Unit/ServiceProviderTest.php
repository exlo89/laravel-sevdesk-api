<?php

namespace Exlo89\LaravelSevdeskApi\Tests\Unit;

use Exlo89\LaravelSevdeskApi\Tests\TestCase;

class ServiceProviderTest extends TestCase
{
    public function test_publish_config()
    {
        $this->artisan('vendor:publish', [
            '--provider' => 'Exlo89\LaravelSevdeskApi\SevdeskApiServiceProvider',
            '--tag'=>'config'
        ]);

        $this->assertFileExists(config_path('sevdesk-api.php'));
        $this->assertFileIsReadable(config_path('sevdesk-api.php'));
        $this->assertFileEquals(config_path('sevdesk-api.php'), __DIR__ . '/../../config/config.php');
        $this->assertTrue(unlink(config_path('sevdesk-api.php')));
    }
}
