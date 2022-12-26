<?php

namespace App\Catalogs\Actions;

use App\Base\Actions\Action;
use App\Models\Help as Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;

class HelpAction extends Action
{
    private Model $item;

    public function getAllPages() : Collection
    {
        $this->item = new Model();
        if (Auth::user()->hasRole('superAdmin')) {
            $this->items = $this->item->getAllItems();
        }
        return $this->items;
    }

    public function getAllPagesPaginate() :  LengthAwarePaginator
    {
        $this->item = new Model();
        if (Auth::user()->hasRole('superAdmin')) {
            $this->items = $this->item->getAllPaginateItems($this->page);
        }
        return $this->items;
    }

    public function getNewPagesPaginate() :  LengthAwarePaginator
    {
        $this->item = new Model();
        if (Auth::user()->hasAnyRole('admin', 'superAdmin')) {
            $this->items = $this->item->getNewPaginateItems($this->page);
        }
        return $this->items;
    }

    public function getWorkerPagesPaginate() :  LengthAwarePaginator
    {
        $this->item = new Model();
        if (Auth::user()->hasRole('manager')) {
            $this->items = $this->item->getModWorkerPaginateItems($this->page);
        }
        if (Auth::user()->hasAnyRole('admin', 'superAdmin')) {
            $this->items = $this->item->getAdmWorkerPaginateItems($this->page);
        }
        return $this->items;
    }

    public function getCompletedPagesPaginate() :  LengthAwarePaginator
    {
        $this->item = new Model();
        if (Auth::user()->hasRole('manager')) {
            $this->items = $this->item->getModCompletedPaginateItems($this->page);
        }
        if (Auth::user()->hasAnyRole('admin', 'superAdmin')) {
            $this->items = $this->item->getAdmCompletedPaginateItems($this->page);
        }
        return $this->items;
    }

    public function getDismissPagesPaginate() :  LengthAwarePaginator
    {
        $this->item = new Model();
        if (Auth::user()->hasAnyRole('admin', 'superAdmin')) {
            $this->items = $this->item->getAdmDismissPaginateItems($this->page);
        }
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
        $this->item->images = json_decode($this->item->images, true);
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
        if ($this->item->work_id == auth()->user()->id) {
            throw new \Exception('Нельзя назначить самого себя');
        }
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
