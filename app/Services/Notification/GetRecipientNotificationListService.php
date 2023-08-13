<?php

namespace App\Services\Notification;

use App\Repositories\Interfaces\NotificationRepositoryInterface;
use App\Services\Interfaces\Notification\GetRecipientNotificationListServiceInterface;
use Illuminate\Database\Eloquent\Collection;
use Throwable;

class GetRecipientNotificationListService implements GetRecipientNotificationListServiceInterface
{
    public function __construct(
        private NotificationRepositoryInterface $notificationRepository
    ) {}

    public function execute(int $recipientId): Collection
    {
        try {
            return $this->notificationRepository->findManyByRecipientId($recipientId);
        } catch (Throwable $exception) {
            throw $exception;
        }
    }
}