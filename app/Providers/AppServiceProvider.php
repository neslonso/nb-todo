<?php

namespace App\Providers;

use App\Core\Application\ApiResponse;
use App\Core\Application\Interfaces\ApiResponseInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(ApiResponseInterface::class, ApiResponse::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
    }
}
