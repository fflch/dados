<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Observers\PedidoObserver;
use App\Models\Pedido;

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
        Pedido::observe(PedidoObserver::class);
        // https na produção
        if (\App::environment('production')) {
            \URL::forceScheme('https');
        }
    }
}
