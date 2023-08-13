<?php

namespace App\Services\Notification;

use App\Exceptions\NotificationNotFoundException;
use App\Models\Notification;
use App\Repositories\Interfaces\NotificationRepositoryInterface;
use App\Services\Interfaces\Notification\GetNotificationServiceInterface;
use Throwable;

class GetNotificationService implements GetNotificationServiceInterface
{
    public function __construct(
        private NotificationRepositoryInterface $notificationRepository
    ) {}

    public function execute(int $id): Notification
    {
        try {
            $notification = $this->notificationRepository->findById($id);

            throw_if(
                is_null($notification),
                new NotificationNotFoundException(
                    __CLASS__ . '::' . __FUNCTION__ . ' - line ' . __LINE__,
                    $id
                )
            );

            return $notification;
        } catch (Throwable $exception) {
            throw $exception;
        }
    }
}