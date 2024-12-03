<?php

namespace App\Providers;
use Illuminate\Support\ServiceProvider;

use App\Services\DateFormatService;
use App\Services\EmployeePairService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(DateFormatService::class, function() {
            return new DateFormatService();
        });
        $this->app->singleton(EmployeePairService::class, function ($app) {
            return new EmployeePairService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
