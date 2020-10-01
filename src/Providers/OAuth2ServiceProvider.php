<?php

namespace MacsiDigital\OAuth2\Providers;

use Illuminate\Support\ServiceProvider;

class OAuth2ServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/../../routes/web.php');

        if ($this->app->runningInConsole()) {
            $this->publishes([
              __DIR__ . '/../../database/migrations' => database_path('migrations/'),
            ], 'integration-migrations');
        }
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('oauth2', 'MacsiDigital\OAuth2\Package');
        
        // Register the main class to use with the facade
        $this->app->bind('oauth2.connection', 'MacsiDigital\OAuth2\Contracts\Connection');

        $this->app->bind('MacsiDigital\OAuth2\Contracts\Connection', 'MacsiDigital\OAuth2\Connection');
    }
}
