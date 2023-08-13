<?php

namespace App\Services\Interfaces\Notification;

use App\Models\Notification;

interface ReadNotificationServiceInterface
{
    public function execute(int $id): Notification;
}
