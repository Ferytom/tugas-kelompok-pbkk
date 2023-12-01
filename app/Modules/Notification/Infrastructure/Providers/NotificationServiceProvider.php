<?php

namespace App\Modules\Notification\Infrastructure\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class NotificationServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/../../Presentation/views', 'notification');
    }

    public function register()
    {
        // Additional registration logic
    }
}
