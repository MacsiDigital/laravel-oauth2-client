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
        // Register the main class to use with the facade
        $this->app->bind('oauth2.provider', 'MacsiDigital\OAuth2\Contracts\Provider');

        $this->app->bind('MacsiDigital\OAuth2\Contracts\Provider', 'MacsiDigital\OAuth2\Provider');
    }
}
