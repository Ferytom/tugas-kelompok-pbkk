<?php

namespace App\Modules\Member\Infrastructure\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class MemberServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/../../Presentation/views', 'member');
    }

    public function register()
    {
        // Additional registration logic
    }
}
