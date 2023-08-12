<?php

namespace App\Services\Interfaces\Notification;

use App\Models\Notification;

interface CancelNotificationInterface
{
    public function execute(int $id): Notification;
}
