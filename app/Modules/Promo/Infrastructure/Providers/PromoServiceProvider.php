<?php

namespace App\Modules\Promo\Infrastructure\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class PromoServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/../../Presentation/views', 'promo');
    }

    public function register()
    {
        // Additional registration logic
    }
}
