<?php

namespace App\Repositories\Interfaces;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface BaseRepositoryInterface
{
    public function findAll(array $columns = ['*']): Collection;
    public function findAllPaginated(
        int $page = 1,
        int $pageSize = 10,
        array $columns = ['*']
    ): LengthAwarePaginator;
    public function deleteById(int $id): ?bool;
}
