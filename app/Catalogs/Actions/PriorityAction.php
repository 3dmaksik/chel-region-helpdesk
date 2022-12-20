<?php

namespace App\Catalogs\Actions;

use App\Base\Actions\Action;
use App\Models\Priority as Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class PriorityAction extends Action
{
    private Model $item;

    public function getAllPages() : Collection
    {
        $this->item = new Model();
        $this->items = $this->item->getAllItems();
        return $this->items;
    }

    public function getAllPagesPaginate() :  LengthAwarePaginator
    {
        $this->item = new Model();
        $this->items = $this->item->getAllPaginateItems($this->page);
        return $this->items;
    }

    public function findCatalogsById(int $id): Model
    {
        $model = new Model();
        $this->item = $model->viewOneItem($id);
        return $this->item;
    }

    public function show(int $id): Model
    {
        $model = new Model();
        $this->item = $model->viewOneItem($id);
        return $this->item;
    }

    public function store(array $request) : Model
    {
        $model = new Model();
        $this->item = $model->create($request);
        Model::flushQueryCache();
        return $this->item;
    }

    public function update(array $request, int $id) : Model
    {
        $model = new Model();
        $this->item = $model->viewOneItem($id);
        $this->item->update($request);
        Model::flushQueryCache();
        return $this->item;
    }

    public function delete(int $id) : bool
    {
        $model = new Model();
        $this->item = $model->viewOneItem($id);
        $this->item->forceDelete();
        Model::flushQueryCache();
        return true;
    }
}
