<?php

namespace App\Services\Interfaces\Notification;

use App\Models\Notification;

interface GetNotificationServiceInterface
{
    public function execute(int $id): Notification;
}
