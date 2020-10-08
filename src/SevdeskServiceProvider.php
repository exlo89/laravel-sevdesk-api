<?php


namespace Exlo\LaravelSevdeskApi;

use Exlo\LaravelSevdeskApi\Facades\Sevdesk;
use Illuminate\Support\ServiceProvider;

class SevdeskServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // routes listener or other functionality
        $this->publishes([
            __DIR__.'/../config/laravel-sevdesk-api.php' => config_path('sevdesk.php'),
        ], 'laravel-sevdesk-api-config');
    }

    public function register()
    {
        // to bind any classes in the app container
        $this->mergeConfigFrom(
            __DIR__.'/../config/laravel-sevdesk-api.php',
            'laravel-sevdesk-api'
        );
    }
}
