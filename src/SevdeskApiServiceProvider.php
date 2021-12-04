<?php
/*
 * SevdeskApiServiceProvider.php
 * @author Martin Appelmann <hello@martin-appelmann.de>
 * @copyright 2021 Martin Appelmann
 */

namespace Exlo89\LaravelSevdeskApi;

use Illuminate\Support\ServiceProvider;

class SevdeskApiServiceProvider extends ServiceProvider
{
    /**
     * Register the application services.
     */
    public function register()
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'laravel-sevdesk-api');

        // Register the main class to use with the facade
        $this->app->singleton('sevdesk-api', function () {
            return new SevdeskApi();
        });
    }

    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/config.php' => config_path('sevdesk-api.php'),
            ], 'config');
        }
    }
}
