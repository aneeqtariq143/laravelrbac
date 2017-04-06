<?php

namespace Aneeq\LaravelRbac\Providers;

use Illuminate\Support\ServiceProvider;

class RbacServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/../views', 'laravelrbac');
        
        $this->publishes([
            __DIR__.'/../Config/' => config_path()
        ], 'config');
        
        $this->publishes([
            __DIR__.'/../Migrations/' => database_path('migrations')
        ], 'migrations');
        
        $this->publishes([
            __DIR__.'/../Seeds/' => database_path('seeds')
        ], 'seeds');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        include __DIR__.'/../routes.php';
        
        foreach (glob(__DIR__ . '/../Helpers/*.php') as $filename) {
            require_once($filename);
        }
        
        $this->app->make('Aneeq\LaravelRbac\Controllers\RbacController');
    }
}
