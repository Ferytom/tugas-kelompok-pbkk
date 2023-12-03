<?php

namespace App\Modules\Dashboard\Infrastructure\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class DashboardServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/../../Presentation/views', 'dashboard');
    }

    public function register()
    {
        // Additional registration logic
    }
}
