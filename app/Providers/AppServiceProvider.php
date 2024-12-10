<?php

namespace BolsaTrabajo\Providers;

use BolsaTrabajo\Configuracion;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    /* public function boot()
    {
        if (\App::environment('production')) {
            \URL::forceScheme('https');
            $this->app['request']->server->set('HTTPS','on');
        }
        Schema::defaultStringLength(200);
        \Carbon\Carbon::setLocale('es');
        
    } */

    public function boot()
    {
        if (\App::environment('production')) {
            \URL::forceScheme('https');
            $this->app['request']->server->set('HTTPS','on');
        }

        Schema::defaultStringLength(200);
        \Carbon\Carbon::setLocale('es');

        // View Composer para cargar la variable $empresa
        View::composer('*', function ($view) {
            $configuracion = Configuracion::first();
            $view->with('configuracion', $configuracion);
        });
    }
}
