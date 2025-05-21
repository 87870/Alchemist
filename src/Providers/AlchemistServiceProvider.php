<?php

namespace MJ\Alchemist\Providers;

use Illuminate\Support\ServiceProvider;
use MJ\Alchemist\Services\Alchemist;

class AlchemistServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->registerPublishing();

        $this->registerFacades();
    }

    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__.'/../../config/alchemist.php',
            'alchemist'
        );
    }

    protected function registerPublishing(): void
    {
        $this->publishes([
            __DIR__.'/../../config/alchemist.php' => config_path('alchemist.php'),
        ], 'alchemist-config');

        $this->publishes([
            __DIR__.'/../Formulas/Formula.php' => app_path('Formulas/Formula.php'),
        ], 'alchemist-formula');

//        $this->publishes([
//            __DIR__.'/Console/stubs/PressServiceProvider.stub' => app_path('Providers/PressServiceProvider.php'),
//        ], 'press-provider');
    }

    protected function registerFacades(): void
    {
        $this->app->singleton('Alchemist', function ($app) {
            return new Alchemist();
        });
    }
}