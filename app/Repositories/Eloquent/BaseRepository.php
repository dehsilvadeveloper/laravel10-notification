<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Interfaces\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

class BaseRepository implements BaseRepositoryInterface
{
    public function __construct(
        protected Model $model
    ) {}

    public function findAll(array $columns = ['*']): Collection
    {
        return $this->model->get($columns);
    }

    public function findAllPaginated(
        int $page = 1,
        int $pageSize = 10,
        array $columns = ['*']
    ): LengthAwarePaginator {
        $paginatedItems = $this->model->paginate(
            $pageSize,
            $columns,
            'page',
            $page
        );
        $paginatedItems->appends(['page' => $page, 'page_size' => $pageSize]);

        return $paginatedItems;
    }

    public function deleteById(int $id): ?bool
    {
        $item = $this->model->findOrFail($id);
        return $item->delete();
    }
}
