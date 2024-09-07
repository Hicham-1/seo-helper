<?php

namespace H1ch4m\SeoHelper;

use Illuminate\Support\ServiceProvider;
use H1ch4m\SeoHelper\Http\Middleware\SeoMiddleware;

class SeoServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');
        $this->app['router']->aliasMiddleware('seo-helper', SeoMiddleware::class);
    }


    public function register() {}
}
