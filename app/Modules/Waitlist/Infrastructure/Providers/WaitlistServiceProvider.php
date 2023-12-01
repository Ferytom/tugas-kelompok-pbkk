<?php

namespace App\Modules\Waitlist\Infrastructure\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class WaitlistServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/../../Presentation/views', 'waitlist');
    }

    public function register()
    {
        // Additional registration logic
    }
}
