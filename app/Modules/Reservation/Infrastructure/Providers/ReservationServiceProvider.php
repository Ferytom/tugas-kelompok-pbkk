<?php

namespace App\Modules\Reservation\Infrastructure\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ReservationServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/../../Presentation/views', 'reservation');
    }

    public function register()
    {
        // Additional registration logic
    }
}
