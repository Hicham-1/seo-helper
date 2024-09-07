<?php

namespace Seo\SeoHelper;

use Illuminate\Support\ServiceProvider;
use Seo\SeoHelper\Http\Middleware\SeoMiddleware;

class SeoServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');
        $this->app['router']->aliasMiddleware('seo-helper', SeoMiddleware::class);
    }


    public function register() {}
}
