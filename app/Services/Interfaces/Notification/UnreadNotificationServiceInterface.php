<?php

namespace App\Services\Interfaces\Notification;

use App\Models\Notification;

interface UnreadNotificationServiceInterface
{
    public function execute(int $id): Notification;
}
