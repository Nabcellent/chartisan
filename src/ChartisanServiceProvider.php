<?php

declare(strict_types=1);

namespace Nabcellent\Chartisan;

use Illuminate\Contracts\Config\Repository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\Registrar as RouteRegistrar;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class ChartisanServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Merge the configuration files.
        $this->mergeConfigFrom(__DIR__.'/Config/chartisan.php', 'chartisan');

        // Register the Chart Registerer singleton class to avoid resolving it
        // multiple times in the application.
        $this->app->singleton(Registrar::class, fn (Application $app) => new Registrar(
            $app,
            $app->make(Repository::class),
            $app->make(RouteRegistrar::class)
        ));
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(Repository $config, Registrar $chartisan): void
    {
        // Publish the configuration file to the config path.
        $this->publishes([__DIR__.'/Config/chartisan.php' => config_path('chartisan.php')], 'chartisan');

        // Create the blade directives
        $routeNamePrefix = $config->get('chartisan.global_route_name_prefix');
        Blade::directive('chartisan', function ($expression) use ($routeNamePrefix) {
            return "<?php echo route('$routeNamePrefix.'.$expression); ?>";
        });

        // Register the console commands.
        if ($this->app->runningInConsole()) {
            $this->commands([Commands\CreateChart::class]);
        }
    }
}
