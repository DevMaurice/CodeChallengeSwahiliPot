<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\AfricasTalkingGateway;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $gateway = $this->app->singleton('africas', function ($app) {
            return new AfricasTalkingGateway(config('challenge.account'), config('challenge.key'));
        });
    }
}
