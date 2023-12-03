<?php

namespace App\Modules\Location\Infrastructure\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class LocationServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/../../Presentation/views', 'location');
    }

    public function register()
    {
        // Additional registration logic
    }
}
