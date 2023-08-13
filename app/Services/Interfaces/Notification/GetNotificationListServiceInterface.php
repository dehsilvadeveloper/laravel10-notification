<?php

namespace App\Services\Interfaces\Notification;

use Illuminate\Database\Eloquent\Collection;

interface GetNotificationListServiceInterface
{
    public function execute(): Collection;
}
