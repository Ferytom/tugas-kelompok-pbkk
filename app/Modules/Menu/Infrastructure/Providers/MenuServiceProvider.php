<?php

namespace App\Modules\Menu\Infrastructure\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class MenuServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/../../Presentation/views', 'menu');
    }

    public function register()
    {
        // Additional registration logic
    }
}
