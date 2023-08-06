<?php

namespace App\Providers;

use App\Repositories\Eloquent\BaseRepository;
use App\Repositories\Eloquent\Interfaces\EloquentRepositoryInterface;
use App\Repositories\Eloquent\NotificationRepository;
use App\Repositories\Interfaces\NotificationRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryLayerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->registerBaseRepositories();
        $this->registerNotificationRepositories();
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }

    private function registerBaseRepositories(): void
    {
        $this->app->bind(EloquentRepositoryInterface::class, BaseRepository::class);
    }

    private function registerNotificationRepositories(): void
    {
        $this->app->bind(NotificationRepositoryInterface::class, NotificationRepository::class);
    }
}
