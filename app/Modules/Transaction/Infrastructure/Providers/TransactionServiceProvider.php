<?php

namespace App\Modules\Transaction\Infrastructure\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class TransactionServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/../../Presentation/views', 'transaction');
    }

    public function register()
    {
        // Additional registration logic
    }
}
