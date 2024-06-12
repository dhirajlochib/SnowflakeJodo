<?php

namespace Src;

use Illuminate\Support\ServiceProvider;

class SnowflakeJodoServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/snowflakejodo.php', 
            'snowflakejodo'
        );

        $this->app->singleton('snowflakejodo', function () {
            return new SnowflakeJodo(); 
        });
    }

    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/snowflakejodo.php' => config_path('snowflakejodo.php'),
        ], 'snowflakejodo-config');
    }
}   