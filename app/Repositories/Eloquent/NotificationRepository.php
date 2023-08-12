<?php

namespace App\Repositories\Eloquent;

use App\DataTransferObjects\Notification\CreateNotificationDTO;
use App\DataTransferObjects\Notification\UpdateNotificationDTO;
use App\Models\Notification;
use App\Repositories\Interfaces\NotificationRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class NotificationRepository extends BaseRepository implements NotificationRepositoryInterface
{
    public function __construct(Notification $model)
    {
        $this->model = $model;
    }

    public function create(CreateNotificationDTO $data): Notification
    {
        $dataArray = $data->toArray();

        return $this->model->create($dataArray);
    }

    public function update(int $id, UpdateNotificationDTO $data): Notification
    {
        $dataArray = $data->toArray();

        $item = $this->model->findOrFail($id);
        $item->update($dataArray);
        $item->refresh();

        return $item;
    }

    public function read(int $id): Notification
    {
        $item = $this->model->findOrFail($id);
        $item->update([
            'read_at' => date('Y-m-d H:i:s')
        ]);
        $item->refresh();

        return $item;
    }

    public function unread(int $id): Notification
    {
        $item = $this->model->findOrFail($id);
        $item->update([
            'read_at' => null
        ]);
        $item->refresh();

        return $item;
    }

    public function cancel(int $id): Notification
    {
        $item = $this->model->findOrFail($id);
        $item->update([
            'canceled_at' => date('Y-m-d H:i:s')
        ]);
        $item->refresh();

        return $item;
    }

    public function findById(int $id, array $columns = ['*']): ?Notification
    {
        return $this->model->find($id, $columns);
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
