<?php

namespace App\Repositories\Eloquent;

use App\Models\Notification;
use App\Repositories\Interfaces\NotificationRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class NotificationRepository extends BaseRepository implements NotificationRepositoryInterface
{
    public function __construct(Notification $model)
    {
        parent::__construct($model);
    }

    public function findManyByRecipientId(int $recipientId, array $columns = ['*']): Collection
    {
        return $this->model->where('recipient_id', '=', $recipientId)->get($columns);
    }

    public function countByRecipientId(int $recipientId): int
    {
        return $this->model->where('recipient_id', '=', $recipientId)->count();
    }
}
