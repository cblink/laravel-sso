<?php


namespace Cblink\Sso;


use Cblink\Sso\Console\Commands\CreateSso;
use Illuminate\Support\ServiceProvider;

class SsoServiceProvider extends ServiceProvider
{

    public function register()
    {
        $this->publishes([__DIR__ . '/database/' => database_path()]);
        $this->publishes([__DIR__ . '/config/' => config_path()]);
        $this->commands(CreateSso::class);
    }

    public function boot()
    {
        \Auth::provider('sso', function ($app, $config) {
            return new SsoUserProvider($this->app['hash'], $config['model']);
        });
    }
}