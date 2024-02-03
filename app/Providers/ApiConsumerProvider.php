<?php

namespace App\Providers;

use GuzzleHttp\Client;
use Illuminate\Support\ServiceProvider;

class ApiConsumerProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind('ApiConnection', function () {
            $apiConnection = new Client([
                // Base URI is used with relative requests
                'base_uri' => 'http://127.0.0.1:8000/api/',
                // You can set any number of default request options.
                'timeout'  => 5.0,
            ]);

            return $apiConnection;
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
