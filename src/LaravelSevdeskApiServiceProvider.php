<?php

namespace Exlo89\LaravelSevdeskApi;

use Exlo89\LaravelSevdeskApi\Facades\Console\InstallSevdeskApi;
use Illuminate\Support\ServiceProvider;

class LaravelSevdeskApiServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        /*
         * Optional methods to load your package assets
         */
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'laravel-sevdesk-api');
        // $this->loadViewsFrom(__DIR__.'/../resources/views', 'laravel-sevdesk-api');
        // $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        // $this->loadRoutesFrom(__DIR__.'/routes.php');

        if ($this->app->runningInConsole()) {
            $this->commands([
                InstallSevdeskApi::class,
            ]);

            $this->publishes([
                __DIR__.'/../config/config.php' => config_path('sevdesk-api.php'),
            ], 'config');

            // Publishing the views.
            /*$this->publishes([
                __DIR__.'/../resources/views' => resource_path('views/vendor/laravel-sevdesk-api'),
            ], 'views');*/

            // Publishing assets.
            /*$this->publishes([
                __DIR__.'/../resources/assets' => public_path('vendor/laravel-sevdesk-api'),
            ], 'assets');*/

            // Publishing the translation files.
            /*$this->publishes([
                __DIR__.'/../resources/lang' => resource_path('lang/vendor/laravel-sevdesk-api'),
            ], 'lang');*/

            // Registering package commands.
            // $this->commands([]);
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'laravel-sevdesk-api');

        // Register the main class to use with the facade
        $this->app->singleton('laravel-sevdesk-api', function () {
            return new LaravelSevdeskApi;
        });
    }
}
