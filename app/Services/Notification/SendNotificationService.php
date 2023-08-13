<?php

namespace App\Services\Notification;

use App\DataTransferObjects\Notification\CreateNotificationDTO;
use App\Models\Notification;
use App\Repositories\Interfaces\NotificationRepositoryInterface;
use App\Services\Interfaces\Notification\SendNotificationServiceInterface;
use Throwable;

class SendNotificationService implements SendNotificationServiceInterface
{
    public function __construct(
        private NotificationRepositoryInterface $notificationRepository
    ) {}

    public function execute(CreateNotificationDTO $dto): Notification
    {
        try {
            return $this->notificationRepository->create($dto);
        } catch (Throwable $exception) {
            throw $exception;
        }
    }
}