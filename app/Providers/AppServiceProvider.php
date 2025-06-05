<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $modulePath = app_path('Modules');

        if (is_dir($modulePath)) {
            foreach (glob($modulePath . '/*/Providers/*.php') as $provider) {
                $moduleName = basename(dirname($provider));
                $providerClass = "Modules\\{$moduleName}\\Providers\\" . basename($provider, '.php');

                if (class_exists($providerClass)) {
                    $this->app->register($providerClass);
                }
            }
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
