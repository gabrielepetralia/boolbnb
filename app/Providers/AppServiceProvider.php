<?php

namespace App\Providers;
use Braintree\Gateway;
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
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
      $this->app->singleton(Gateway::class, function($app){
        return new Gateway(
          [
          'environment' => 'sandbox',
          'merchantId' => 'z9bj3nqj8c3wxpyr',
          'publicKey' => 'ys5zjbrscrzrptz4',
          'privateKey' => 'cfced86c027ced08e45b13ed6da1fb6b',
          ]

          );
      });
    }
}
