<?php

namespace MyVendor\HelloWorld;

use Illuminate\Support\ServiceProvider;

class HelloWorldServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Define a simple route
        if ($this->app->runningInConsole()) {
            $this->commands([]);
        }

        $this->loadRoutesFrom(__DIR__ . '/routes/web.php');
    }

    public function register()
    {
        // Register bindings or configurations
    }
}
