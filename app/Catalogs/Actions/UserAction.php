<?php

namespace App\Catalogs\Actions;

use App\Base\Actions\Action;
use App\Models\Help as Model;
use Illuminate\Pagination\LengthAwarePaginator;

class UserAction extends Action
{
    private Model $model;
    private Model $item;

    public function getWorkerPagesPaginate() :  LengthAwarePaginator
    {
        $this->item = new Model();
        $this->items = $this->item->getUserWorkerPaginateItems($this->page);
        return $this->items;
    }

    public function getCompletedPagesPaginate() :  LengthAwarePaginator
    {
        $this->item = new Model();
        $this->items = $this->item->getUserCompletedPaginateItems($this->page);
        return $this->items;
    }

    public function getDismissPagesPaginate() :  LengthAwarePaginator
    {
        $this->item = new Model();
        $this->items = $this->item->getUserDismissPaginateItems($this->page);
        return $this->items;
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
}
