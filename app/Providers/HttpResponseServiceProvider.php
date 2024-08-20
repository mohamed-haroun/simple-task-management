<?php

namespace App\Providers;

use App\Contracts\HttpResponseInterface;
use App\Services\HttpResponseService;
use Illuminate\Support\ServiceProvider;
use Psr\Http\Message\ResponseInterface;

class HttpResponseServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(HttpResponseInterface::class, function ($app) {
            return new HttpResponseService();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
