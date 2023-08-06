<?php

namespace App\Repositories\Eloquent\Interfaces;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

interface EloquentRepositoryInterface
{
    public function create(array $data): Model;
    public function update(int $id, array $data): Model;
    public function findAll(array $columns = ['*']): Collection;
    public function findAllPaginated(int $pageSize = 10, array $columns = ['*']): LengthAwarePaginator;
    public function findById(int $id, array $columns = ['*']): ?Model;
    public function deleteById(int $id): ?bool;
}
