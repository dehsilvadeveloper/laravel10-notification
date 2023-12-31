<?php

namespace App\Repositories\Interfaces;

use App\DataTransferObjects\Notification\CreateNotificationDTO;
use App\DataTransferObjects\Notification\UpdateNotificationDTO;
use App\Models\Notification;
use App\Repositories\Interfaces\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

interface NotificationRepositoryInterface extends BaseRepositoryInterface
{
    public function create(CreateNotificationDTO $dto): Notification;
    public function update(int $id, UpdateNotificationDTO $dto): Notification;
    public function read(int $id): Notification;
    public function unread(int $id): Notification;
    public function cancel(int $id): Notification;
    public function findById(int $id, array $columns = ['*']): ?Notification;
    public function findManyByRecipientId(int $recipientId, array $columns = ['*']): Collection;
    public function countByRecipientId(int $recipientId): int;
}
