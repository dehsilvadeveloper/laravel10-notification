<?php

namespace App\Providers;

use App\Services\Interfaces\Notification\CancelNotificationServiceInterface;
use App\Services\Interfaces\Notification\ReadNotificationServiceInterface;
use App\Services\Interfaces\Notification\UnreadNotificationServiceInterface;
use App\Services\Notification\CancelNotificationService;
use App\Services\Notification\ReadNotificationService;
use App\Services\Notification\UnreadNotificationService;
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
        $this->app->bind(ReadNotificationServiceInterface::class, ReadNotificationService::class);
        $this->app->bind(UnreadNotificationServiceInterface::class, UnreadNotificationService::class);
    }
}
