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
            return new AfricasTalkingGateway('sandbox', '2e3de328ff8ae1300991dfb18efb71bd97383ea6fadcf3e14604c35e8cb97a21');
        });
    }
}
