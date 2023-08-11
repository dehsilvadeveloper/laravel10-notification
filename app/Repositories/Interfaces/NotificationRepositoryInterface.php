<?php

namespace App\Repositories\Interfaces;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

interface NotificationRepositoryInterface
{
    public function create(array $data): Model;
    public function update(int $id, array $data): Model;
    public function findAll(array $columns = ['*']): Collection;
    public function findAllPaginated(
        int $page = 1,
        int $pageSize = 10,
        array $columns = ['*']
    ): LengthAwarePaginator;
    public function findById(int $id, array $columns = ['*']): ?Model;
    public function deleteById(int $id): ?bool;
    public function findManyByRecipientId(int $recipientId, array $columns = ['*']): Collection;
    public function countByRecipientId(int $recipientId): int;
}
