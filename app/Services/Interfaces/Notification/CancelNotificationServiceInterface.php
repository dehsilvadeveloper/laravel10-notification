<?php

namespace App\Services\Interfaces\Notification;

use App\Models\Notification;

interface CancelNotificationServiceInterface
{
    public function execute(int $id): Notification;
}
