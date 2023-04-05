<?php

namespace App\Catalogs\Actions;

use App\Base\Actions\Action;
use App\Models\Cabinet as Model;
use Illuminate\Database\Eloquent\Collection;

class CabinetAction extends Action
{
    private array $cabinets;

    private int $total;

    public function getAllPages(): Collection
    {
        $this->items = Model::orderBy('description', 'ASC')->get();

        return $this->items;
    }

    public function getAllPagesPaginate(): array
    {
        $this->items = Model::orderBy('description', 'ASC')->paginate($this->page);
        $this->total = Model::count();
        $this->cabinets =
        [
            'data' => $this->items,
            'total' => $this->total,
        ];

        return $this->cabinets;
    }

    public function show(int $id): Model
    {
        $this->item = Model::findOrFail($id);

        return $this->item;
    }

    public function store(array $request): bool
    {
        $this->item = Model::create($request);
        Model::flushQueryCache();

        return true;
    }

    public function update(array $request, int $id): Model
    {
        $this->item = Model::findOrFail($id);
        $this->item->update($request);
        Model::flushQueryCache();

        return $this->item;
    }

    public function delete(int $id): bool
    {
        $this->item = Model::findOrFail($id);
        $this->item->forceDelete();
        Model::flushQueryCache();

        return true;
    }
}
