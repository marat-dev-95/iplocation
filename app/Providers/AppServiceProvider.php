<?php

namespace App\Providers;

use App\Service\Contracts\IpLocationProviderContract;
use App\Service\ExternalIpLocationProvider;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */

    public function register()
    {
        $this->app->bind(IpLocationProviderContract::class, function($app) {
            $config = Config::get('external_provider');
            return new ExternalIpLocationProvider($config['host'], $config['token']);
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
