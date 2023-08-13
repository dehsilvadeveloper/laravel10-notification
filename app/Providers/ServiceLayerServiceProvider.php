<?php

namespace App\Providers;

use App\Services\Interfaces\Notification\CancelNotificationServiceInterface;
use App\Services\Interfaces\Notification\GetNotificationListServiceInterface;
use App\Services\Interfaces\Notification\GetNotificationPaginatedListServiceInterface;
use App\Services\Interfaces\Notification\GetNotificationServiceInterface;
use App\Services\Interfaces\Notification\GetRecipientNotificationCountServiceInterface;
use App\Services\Interfaces\Notification\GetRecipientNotificationListServiceInterface;
use App\Services\Interfaces\Notification\ReadNotificationServiceInterface;
use App\Services\Interfaces\Notification\SendNotificationServiceInterface;
use App\Services\Interfaces\Notification\UnreadNotificationServiceInterface;
use App\Services\Notification\CancelNotificationService;
use App\Services\Notification\GetNotificationListService;
use App\Services\Notification\GetNotificationPaginatedListService;
use App\Services\Notification\GetNotificationService;
use App\Services\Notification\GetRecipientNotificationCountService;
use App\Services\Notification\GetRecipientNotificationListService;
use App\Services\Notification\ReadNotificationService;
use App\Services\Notification\SendNotificationService;
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
        $this->app->bind(GetNotificationListServiceInterface::class, GetNotificationListService::class);
        $this->app->bind(GetNotificationPaginatedListServiceInterface::class, GetNotificationPaginatedListService::class);
        $this->app->bind(GetNotificationServiceInterface::class, GetNotificationService::class);
        $this->app->bind(GetRecipientNotificationCountServiceInterface::class, GetRecipientNotificationCountService::class);
        $this->app->bind(GetRecipientNotificationListServiceInterface::class, GetRecipientNotificationListService::class);
        $this->app->bind(ReadNotificationServiceInterface::class, ReadNotificationService::class);
        $this->app->bind(SendNotificationServiceInterface::class, SendNotificationService::class);
        $this->app->bind(UnreadNotificationServiceInterface::class, UnreadNotificationService::class);
    }
}
