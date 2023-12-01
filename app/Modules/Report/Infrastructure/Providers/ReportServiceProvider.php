<?php

namespace App\Modules\Report\Infrastructure\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ReportServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/../../Presentation/views', 'report');
    }

    public function register()
    {
        // Additional registration logic
    }
}
