<?php

namespace Nabcellent\Charts;

use Illuminate\Support\ServiceProvider;
use Nabcellent\Charts\Commands\ChartsCommand;

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
            __DIR__.'/Config/charts.php' => config_path('charts.php'),
        ], 'charts_config');

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
            __DIR__.'/Config/charts.php',
            'charts'
        );
    }
}
