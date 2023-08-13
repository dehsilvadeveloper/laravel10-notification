<?php

namespace App\Services\Interfaces\Notification;

interface GetRecipientNotificationCountServiceInterface
{
    public function execute(int $recipientId): int;
}
