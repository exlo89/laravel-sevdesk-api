<?php


namespace Exlo89\LaravelSevdeskApi\Tests\Unit;


use Exlo89\LaravelSevdeskApi\Tests\TestCase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

class InstallSevdeskApiTest extends TestCase
{
    /**
     * @test
     */
    function the_install_command_copies_the_configuration()
    {
        // make sure we're starting from a clean state
        if (File::exists(config_path('sevdesk-api.php'))) {
            unlink(config_path('sevdesk-api.php'));
        }

        $this->assertFalse(File::exists(config_path('sevdesk-api.php')));

        Artisan::call('sevdesk-api:install');

        $this->assertTrue(File::exists(config_path('sevdesk-api.php')));
    }
}
