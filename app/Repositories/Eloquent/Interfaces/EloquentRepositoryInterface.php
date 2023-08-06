<?php

namespace App\Repositories\Eloquent\Interfaces;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface EloquentRepositoryInterface
{
    public function create(array $attributes): Model;
    public function update(int $id, array $data): Model;
    public function findAll(array $columns = ['*']): Collection;
    public function findById(int $id, array $columns = ['*']): ?Model;
    public function deleteById(int $id): ?bool;
}
