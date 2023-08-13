<?php

namespace App\Services\Interfaces\Notification;

use Illuminate\Database\Eloquent\Collection;

interface GetRecipientNotificationListServiceInterface
{
    public function execute(int $recipientId): Collection;
}
