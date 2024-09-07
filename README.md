# SEO Helper

A Laravel package for SEO functionalities.

## Installation

You can install the package via Composer:

```bash
composer require h1ch4m/seo-helper
```

## Service Provider

After installing the package, you need to register the service provider. Add the service provider to your `config/app.php` file:

```php
'providers' => [
    // Other Service Providers...

    H1ch4m\SeoHelper\SeoServiceProvider::class,
],
```

## Middleware

The package includes middleware to handle SEO metadata. You can use this middleware to automatically apply SEO settings to your responses.

### Register Middleware

To use the middleware, you need to register it in your `app/Http/Kernel.php` file.

#### For Global Middleware 

To apply the middleware globally to all routes, add it to the `$middleware` array:

```php
protected $middleware = [
    // Other middleware...

    \H1ch4m\SeoHelper\Http\Middleware\SeoMiddleware::class,
];
```

#### For Route Middleware

To apply the middleware to specific routes or route groups, add it to the `$routeMiddleware` array:

```php
protected $routeMiddleware = [
    // Other middleware...

    'seo-helper' => \H1ch4m\SeoHelper\Http\Middleware\SeoMiddleware::class,
];
```

You can then use the middleware in your routes like this:

```php
Route::middleware(['seo-helper'])->group(function () {
    Route::get('/example', ['ExampleController','show']);
});
```
## Publishing Configuration

If your package includes configuration options, you can publish the configuration file using Artisan:

```bash
php artisan vendor:publish --provider="H1ch4m\SeoHelper\SeoServiceProvider"

```
This will publish the configuration file to `config/seo-helper.php`, where you can adjust the settings as needed.

## Migration

run migration to create table `seo-helper`

```bash
php artisan migrate
```

## Usage

### Adding SEO Metadata

You can use the package's API to set SEO metadata for your application. Here's an example of how to use it in a controller:

```php
use H1ch4m\SeoHelper\Facades\SeoHelper;

public function someMethod()
{
    DB::table('seo_helpers')->insert([
        [
            'name' => 'name',
            'value' => 'author',
            'content' => 'h1ch4m',
            'route' => 'home.index',
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'name' => 'property',
            'value' => 'og:image:width',
            'content' => '256',
            'route' => 'home.index|about.index',
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'name' => 'http-equiv',
            'value' => 'X-UA-Compatible',
            'content' => 'IE=edge',
            'route' => '*', // Wildcard to apply to all routes
            'created_at' => now(),
            'updated_at' => now(),
        ],
    ]);

    // Additional logic...
}

```
Note:

- if you want to apply it on one route just add it on `route` column, if you want to apply it on more than one route use `|` between routes, if you want to apply it on all routes just insert `*`
- The name can be `name` or `property` or any mate name you want
- The value is the meta name value
- The content is the meta content

### Applying Middleware

The `SeoMiddleware` will handle SEO settings automatically based on your routes. Ensure you have configured the middleware correctly to apply it to the desired routes.

## License

This package is open-source software licensed under the [MIT license](LICENSE).