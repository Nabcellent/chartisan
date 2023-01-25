<h1 align="center">CHARTISAN</h1>

<p align="center">
<a href="https://styleci.io/repos/69124179"><img src="https://img.shields.io/badge/Built_for-Laravel-red.svg" alt="Build For Laravel"></a>
<a href="https://packagist.org/packages/nabcellent/chartisan"><img src="https://poser.pugx.org/nabcellent/chartisan/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/nabcellent/chartisan"><img src="https://poser.pugx.org/nabcellent/chartisan/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/nabcellent/chartisan"><img src="https://poser.pugx.org/nabcellent/chartisan/license.svg" alt="License"></a>
</p>

## What is Chartisan?

Chartisan is a Laravel library used to create charts. This library attempts to provide more laravel-like features into it by providing support
for chart creation using the artisan command, middleware support and routing support. This makes handling
charts feel more laravel-like.

<p align="center"><img src="https://image.prntscr.com/image/pwONtZIUSOGnxud9Omh4-Q.png" alt="Chart"></p>

Chartisan makes creating charts a laravel experience that's quick and elegant.

## Installation

You can install Chartisan by using [Composer](https://getcomposer.org/)

You can use the following composer command to install it into an existing laravel project.

```
composer require nabcellent/chartisan
```

Laravel will already register the service provider to your application because Chartisan
does make use of the extra laravel tag on the `composer.json` schema.

## Publish the configuration file

You can publish the config file with:
```
php artisan vendor:publish --tag=chartisan
```

This will create a new file under `app/config/chartisan.php` that you can edit to modify the
options of Chartisan.


## Create Charts

You can start creating charts with the typical `make` command by laravel artisan.

Following the other make conventions, you may use the following command to create a new chart and give it
a name. The name will be used by the class and also the route name. You may further change this in the
created class.

```
php artisan make:chart SampleChart
```

This will create a SampleChart class under `App\Charts` namespace that will look like this:

```php
<?php

declare(strict_types = 1);

namespace App\Charts;

use Illuminate\Http\Request;
use Nabcellent\Chartisan\BaseChart;
use Nabcellent\Chartisan\Chartisan\Chartisan;

class SampleChart extends BaseChart
{
    /**
     * Handles the HTTP request for the given chart.
     * It must always return an instance of Chartisan
     * and never a string or an array.
     */
    public function handler(Request $request): Chartisan
    {
        return Chartisan::build()
            ->labels(['First', 'Second', 'Third'])
            ->dataset('Sample', [1, 2, 3])
            ->dataset('Sample 2', [3, 2, 1]);
    }
}
```

## Create the Chartisan instance

The handler method is the one that will be called when Chartisan tries to get the chart
data. You'll get the request instance as a parameter in case you want to check for query parameters
or additional info like headers, or post data. You can modify the Chartisan instance as you need.

You have to return a Chartisan instance, never a string or an object.

## Register the chart

You'll need to manually register using the `App\Providers\AppServiceProvider`

The charts have a registered singleton that will be injected to the `boot()` method on the service provider.

You can use the following example as a guide to register an example chart.

```php
<?php

namespace App\Providers;

use App\Charts\SampleChart;
use Nabcellent\Chartisan\Registrar as Chartisan;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    // ...

    /**
     * Bootstrap any application services.
     */
    public function boot(Chartisan $charts)
    {
        $charts->register([
            SampleChart::class
        ]);
    }
}
```

### Generated routes

You can use php artisan route:list -c to see all your application routes and check out the chart routes that have
been created by Chartisan in case you need them.

## Chart Configuration

You can customize how some chart configuration on the laravel side by simply applying the
class properties needed.

You can modify the following props on the chart:

- Middlewares
- Chart name (used to generate the URL)
- Chart route name
- Route endpoint prefix

```php
<?php

declare(strict_types = 1);

namespace App\Charts;

use Illuminate\Http\Request;
use Nabcellent\Chartisan\BaseChart;
use Nabcellent\Chartisan\Chartisan\Chartisan;

class SampleChart extends BaseChart
{
    /**
     * Determines the chart name to be used on the
     * route. If null, the name will be a snake_case
     * version of the class name.
     */
    public ?string $name = 'custom_chart_name';

    /**
     * Determines the name suffix of the chart route.
     * This will also be used to get the chart URL
     * from the blade directive. If null, the chart
     * name will be used.
     */
    public ?string $routeName = 'chart_route_name';

    /**
     * Determines the prefix that will be used by the chart
     * endpoint.
     */
    public ?string $prefix = 'some_prefix';

    /**
     * Determines the middlewares that will be applied
     * to the chart endpoint.
     */
    public ?array $middlewares = ['auth'];

    /**
     * Handles the HTTP request for the given chart.
     * It must always return an instance of Chartisan
     * and never a string or an array.
     */
    public function handler(Request $request): Chartisan
    {
        return Chartisan::build()
            ->labels(['First', 'Second', 'Third'])
            ->dataset('Sample', [1, 2, 3])
            ->dataset('Sample 2', [3, 2, 1]);
    }
}
```

## Render Charts

Chartisan can be used without any rendering on the PHP side. Meaning it can be used and served as an API endpoint. There's no need to modify the configuration files or the chart to do such.

However, if you do not plan to develop the front-end as an SPA or in a different application and can use the
laravel Blade syntax, you can then use the `@chartisan` helper to create charts.

Keep in mind that you still need to import Chartisan, and it's front-end library of your choice. The `@chartisan` blade helper does accept a string containing the
chart name to get the URL of. The following example can be used as a guide:

```html
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8"/>
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	<title>Chartisan example</title>
</head>
<body>
<!-- Chart's container -->
<div id="chart" style="height: 300px;"></div>
<!-- Charting library -->
<script src="https://unpkg.com/echarts/dist/echarts.min.js"></script>
<!-- Chartisan -->
<script src="https://unpkg.com/@chartisan/echarts/dist/chartisan_echarts.js"></script>
<!-- Your application script -->
<script>
	const chart = new Chartisan({
		el: '#chart',
		url: "@chartisan('sample_chart')",
	});
</script>
</body>
</html>
```

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Nabcellent](https://github.com/Nabcellent)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.