<?php

namespace App\Catalogs\Actions;

use App\Base\Actions\Action;
use App\Models\Help as Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class HelpAction extends Action
{
    private Model $model;
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

    public function getNewPagesPaginate() :  LengthAwarePaginator
    {
        $this->item = new Model();
        $this->items = $this->item->getNewPaginateItems($this->page);
        return $this->items;
    }

    public function getWorkerAdmPagesPaginate() :  LengthAwarePaginator
    {
        $this->item = new Model();
        $this->items = $this->item->getAdmWorkerPaginateItems($this->page);
        return $this->items;
    }

    public function getWorkerModPagesPaginate() :  LengthAwarePaginator
    {
        $this->item = new Model();
        $this->items = $this->item->getModWorkerPaginateItems($this->page);
        return $this->items;
    }

    public function getCompletedAdmPagesPaginate() :  LengthAwarePaginator
    {
        $this->item = new Model();
        $this->items = $this->item->getAdmCompletedPaginateItems($this->page);
        return $this->items;
    }

    public function getCompletedModPagesPaginate() :  LengthAwarePaginator
    {
        $this->item = new Model();
        $this->items = $this->item->getModCompletedPaginateItems($this->page);
        return $this->items;
    }

    public function getDismissPagesPaginate() :  LengthAwarePaginator
    {
        $this->item = new Model();
        $this->items = $this->item->getAdmDismissPaginateItems($this->page);
        return $this->items;
    }

    public function findCatalogsById(int $id) : Model
    {
        $this->model = new Model();
        $this->item = $this->model->viewOneItem($id);
        return $this->item;
    }

    public function show(int $id) : Model
    {
        $this->model = new Model();
        $this->item = $this->model->viewOneItem($id);
        $this->item->images = json_decode($this->item->images, true);
        return $this->item;
    }

    public function store(array $request) : Model
    {
        $this->model = new Model();
        $this->item = $this->model->create($request);
        Model::flushQueryCache();
        return $this->item;
    }

    public function update(array $request, int $id) : Model
    {
        $this->model = new Model();
        $this->item = $this->model->viewOneItem($id);
        if ($this->item->work_id == auth()->user()->id) {
            throw new \Exception('Нельзя назначить самого себя');
        }
        $this->item->update($request);
        Model::flushQueryCache();
        return $this->item;
    }

    public function delete(int $id) : bool
    {
        $this->model = new Model();
        $this->item = $this->model->viewOneItem($id);
        $this->item->forceDelete();
        Model::flushQueryCache();
        return true;
    }
}
