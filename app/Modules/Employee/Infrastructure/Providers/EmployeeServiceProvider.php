<?php

namespace App\Modules\Employee\Infrastructure\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class EmployeeServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/../../Presentation/views', 'employee');
    }

    public function register()
    {
        // Additional registration logic
    }
}
