<?php

namespace App\Services\Notification;

use App\Repositories\Interfaces\NotificationRepositoryInterface;
use App\Services\Interfaces\Notification\GetNotificationPaginatedListServiceInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Throwable;

class GetNotificationPaginatedListService implements GetNotificationPaginatedListServiceInterface
{
    public function __construct(
        private NotificationRepositoryInterface $notificationRepository
    ) {}

    public function execute(?int $page = null, ?int $pageSize = null): LengthAwarePaginator
    {
        try {
            $page = $page ?? config('notifications.pagination.default_page');
            $pageSize = $pageSize ?? config('notifications.pagination.default_page_size');

            return $this->notificationRepository->findAllPaginated($page, $pageSize);
        } catch (Throwable $exception) {
            throw $exception;
        }
    }
}