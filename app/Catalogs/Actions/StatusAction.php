<?php

namespace App\Catalogs\Actions;

use App\Base\Actions\Action;
use App\Models\Status as Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class StatusAction extends Action
{
    public function getAllPages() : Collection
    {
        $this->items = Model::orderBy('description', 'ASC')->get();
        return $this->items;
    }

    public function getAllPagesPaginate() :  LengthAwarePaginator
    {
        $this->items = Model::orderBy('description', 'ASC')->paginate($this->page);
        return $this->items;
    }

    public function show(int $id): Model
    {
        $this->item = Model::findOrFail($id);
        return $this->item;
    }

    public function store(array $request) : bool
    {
        Model::create($request);
        Model::flushQueryCache();
        return true;
    }

    public function update(array $request, int $id) : Model
    {
        $this->item = Model::findOrFail($id);
        $this->item->update($request);
        Model::flushQueryCache();
        return $this->item;
    }

    public function delete(int $id) : bool
    {
        $this->item = Model::findOrFail($id);
        $this->item->forceDelete();
        Model::flushQueryCache();
        return true;
    }
}
