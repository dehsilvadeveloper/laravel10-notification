<?php

namespace App\Services\Notification;

use App\Repositories\Interfaces\NotificationRepositoryInterface;
use App\Services\Interfaces\Notification\GetNotificationListServiceInterface;
use Illuminate\Database\Eloquent\Collection;
use Throwable;

class GetNotificationListService implements GetNotificationListServiceInterface
{
    public function __construct(
        private NotificationRepositoryInterface $notificationRepository
    ) {}

    public function execute(): Collection
    {
        try {
            return $this->notificationRepository->findAll();
        } catch (Throwable $exception) {
            throw $exception;
        }
    }
}