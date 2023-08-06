<?php

namespace App\Repositories\Interfaces;

use Illuminate\Database\Eloquent\Collection;

interface NotificationRepositoryInterface
{
    public function findManyByRecipientId(int $recipientId, array $columns = ['*']): Collection;
    public function countByRecipientId(int $recipientId): int;
}
