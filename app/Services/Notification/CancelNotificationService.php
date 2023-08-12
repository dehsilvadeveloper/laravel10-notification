<?php

namespace App\Services\Notification;

use App\Exceptions\NotificationNotFoundException;
use App\Models\Notification;
use App\Repositories\Interfaces\NotificationRepositoryInterface;
use App\Services\Interfaces\Notification\CancelNotificationServiceInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Throwable;

class CancelNotificationService implements CancelNotificationServiceInterface
{
    public function __construct(
        private NotificationRepositoryInterface $notificationRepository
    ) {}

    public function execute(int $id): Notification
    {
        try {
            return $this->notificationRepository->cancel($id);
        } catch (ModelNotFoundException $exception) {
            throw new NotificationNotFoundException(
                __CLASS__ . '::' . __FUNCTION__ . ' - line ' . __LINE__,
                $id
            );
        } catch (Throwable $exception) {
            throw $exception;
        }
    }
}
