<?php

namespace App\Services\Interfaces\Notification;

use Illuminate\Pagination\LengthAwarePaginator;

interface GetNotificationPaginatedListServiceInterface
{
    public function execute(?int $page = null, ?int $pageSize = null): LengthAwarePaginator;
}
