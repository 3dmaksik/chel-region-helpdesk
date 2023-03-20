<?php

namespace App\Catalogs\Actions;

use App\Base\Actions\Action;
use App\Models\Priority as Model;
use Illuminate\Database\Eloquent\Collection;

class PriorityAction extends Action
{
    private array $proirity;
    private int $total;
    public function getAllPages() : Collection
    {
        $this->items = Model::orderBy('rang', 'ASC')->get();
        return $this->items;
    }

    public function getAllPagesPaginate() : array
    {
        $this->item = new Model();
        $this->items = Model::orderBy('rang', 'ASC')->paginate($this->page);
        $this->total = Model::count();
        $this->proirity =
        [
            'data' => $this->items,
            'total' => $this->total,
        ];
        return $this->proirity;
    }

    public function findCatalogsById(int $id): Model
    {
        $this->item = Model::findOrFail($id);
        return $this->item;
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
