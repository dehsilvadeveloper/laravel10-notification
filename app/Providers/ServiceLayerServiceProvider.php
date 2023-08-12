<?php

namespace App\Providers;

use App\Services\Interfaces\Notification\CancelNotificationServiceInterface;
use App\Services\Notification\CancelNotificationService;
use Illuminate\Support\ServiceProvider;

class ServiceLayerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->registerNotificationServices();
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }

    private function registerNotificationServices(): void
    {
        $this->app->bind(CancelNotificationServiceInterface::class, CancelNotificationService::class);
    }
}
