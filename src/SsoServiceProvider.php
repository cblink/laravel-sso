<?php


namespace Cblink\Sso;


use Cblink\Sso\Console\Commands\CreateSso;
use Cblink\Sso\Console\Commands\MakeSsoRoute;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class SsoServiceProvider extends ServiceProvider
{

    public function register()
    {
        $this->publishes([__DIR__ . '/database/' => database_path()]);
        $this->publishes([__DIR__ . '/config/' => config_path()]);
        $this->commands([CreateSso::class, MakeSsoRoute::class]);
    }

    public function boot()
    {
        Auth::provider('sso', function ($app, $config) {
            return new SsoUserProvider($this->app['db']->connection(), $this->app['hash'], $config['table']);
        });
    }
}