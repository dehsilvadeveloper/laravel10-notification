<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Eloquent\Interfaces\EloquentRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

class BaseRepository implements EloquentRepositoryInterface
{
    protected $model;

    public function __construct(Model $model)     
    {         
        $this->model = $model;
    }

    public function create(array $data): Model
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data): Model
    {
        $item = $this->model->findOrFail($id);
        $item->update($data);
        $item->refresh();

        return $item;
    }

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

    public function findById(int $id, array $columns = ['*']): ?Model
    {
        return $this->model->find($id, $columns);
    }

    public function deleteById(int $id): ?bool
    {
        $item = $this->model->findOrFail($id);
        return $item->delete();
    }
}
