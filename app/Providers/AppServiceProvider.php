<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Blade;
use Illuminate\Pagination\Paginator;

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
        // força https na produção
        if (\App::environment('production')) {
            \URL::forceScheme('https');
        }
        
        Paginator::useBootstrap(); 

        Blade::directive('arr', function ($array) {
            return '<?php $var = '.$array.'; echo Arr::get(array_shift($var), end($var), \'\'); ?>';      
        });

    }
}
