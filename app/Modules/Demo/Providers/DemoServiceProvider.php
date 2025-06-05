<?php

namespace Modules\Demo\Providers;

use Illuminate\Support\ServiceProvider;

class DemoServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
    }

    public function boot(): void
    {
        // Bootstrapping for the Demo module
    }
}
