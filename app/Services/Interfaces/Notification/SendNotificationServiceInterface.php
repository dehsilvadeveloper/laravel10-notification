<?php

namespace App\Services\Interfaces\Notification;

use App\DataTransferObjects\Notification\CreateNotificationDTO;
use App\Models\Notification;

interface SendNotificationServiceInterface
{
    public function execute(CreateNotificationDTO $dto): Notification;
}
