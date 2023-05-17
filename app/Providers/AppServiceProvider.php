<?php

namespace App\Providers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Validator::extend('alpha_num_dash', function ($attribute, $value) {
            // This will only accept alpha and spaces.
            return preg_match('/^(?!-)(?!.*--)[\pL \pM\pN-]+(?<!-)+$/u', $value);
        });
    }
}
