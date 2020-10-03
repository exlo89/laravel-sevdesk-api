<?php


namespace Exlo\LaravelSevdeskApi;

use Exlo\LaravelSevdeskApi\Facades\Sevdesk;
use Illuminate\Support\ServiceProvider;

class SevdeskServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/laravel-sevdesk-api.php' => config_path('laravel-sevdesk-api.php'),
        ], 'laravel-sevdesk-api-config');
    }

    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/laravel-sevdesk-api.php',
            'laravel-sevdesk-api'
        );
    }
}
