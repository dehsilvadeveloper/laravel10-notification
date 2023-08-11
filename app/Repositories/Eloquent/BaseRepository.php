<?php

namespace App\Repositories\Eloquent;

use App\DataTransferObjects\Interfaces\DataTransferObjectInterface;
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

    public function create(DataTransferObjectInterface $data): Model
    {
        $dataArray = $data->toArray();

        return $this->model->create($dataArray);
    }

    public function update(int $id, DataTransferObjectInterface $data): Model
    {
        $dataArray = $data->toArray();

        $item = $this->model->findOrFail($id);
        $item->update($dataArray);
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
