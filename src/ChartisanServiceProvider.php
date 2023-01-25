<?php

namespace Nabcellent\Chartisan;

use Illuminate\Support\ServiceProvider;
use Nabcellent\Chartisan\Commands\ChartsCommand;

class ChartisanServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->publishes([
                             __DIR__ . '/Config/chartisan.php' => config_path('chartisan.php'),
        ], 'chartisan_config');

        $this->loadViewsFrom(__DIR__.'/Views', 'charts');

        $this->publishes([
            __DIR__.'/Views' => resource_path('views/vendor/charts'),
        ]);

        if ($this->app->runningInConsole()) {
            $this->commands([
                ChartsCommand::class,
            ]);
        }
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__ . '/Config/chartisan.php',
            'charts'
        );
    }
}
