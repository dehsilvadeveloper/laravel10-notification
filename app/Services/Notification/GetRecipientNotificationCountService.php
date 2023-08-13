<?php

namespace App\Services\Notification;

use App\Repositories\Interfaces\NotificationRepositoryInterface;
use App\Services\Interfaces\Notification\GetRecipientNotificationCountServiceInterface;
use Throwable;

class GetRecipientNotificationCountService implements GetRecipientNotificationCountServiceInterface
{
    public function __construct(
        private NotificationRepositoryInterface $notificationRepository
    ) {}

    public function execute(int $recipientId): int
    {
        try {
            return $this->notificationRepository->countByRecipientId($recipientId);
        } catch (Throwable $exception) {
            throw $exception;
        }
    }
}