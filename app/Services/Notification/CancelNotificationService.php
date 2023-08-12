<?php

namespace App\Services\Notification;

use App\Models\Notification;
use App\Repositories\Interfaces\NotificationRepositoryInterface;
use App\Services\Interfaces\Notification\CancelNotificationInterface;

class CancelNotificationService implements CancelNotificationInterface
{
    public function __construct(
        private NotificationRepositoryInterface $notificationRepository
    ) {}

    public function execute(int $id): Notification
    {
        return $this->notificationRepository->cancel($id);
    }
}
