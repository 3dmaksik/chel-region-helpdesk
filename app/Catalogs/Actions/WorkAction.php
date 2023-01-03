<?php

namespace App\Catalogs\Actions;

use App\Base\Actions\Action;
use App\Catalogs\DTO\AllCatalogsDTO;
use App\Catalogs\DTO\WorkDTO;
use App\Models\Work as Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class WorkAction extends Action
{
    public function getAllPages() : Collection
    {
        $this->items = Model::orderBy('lastname', 'ASC')->get();
        return $this->items;
    }

    public function getAllPagesPaginate() :  LengthAwarePaginator
    {
        $this->items = Model::orderBy('lastname', 'ASC')->paginate($this->page);
        return $this->items;
    }

    public function create() : array
    {
        $cabinets = AllCatalogsDTO::getAllCabinetCollection();
        $users = AllCatalogsDTO::getAllUserCollection();
        return [
            'cabinets' => $cabinets,
            'users' => $users,
        ];
    }

    public function show(int $id): Model
    {
        $this->item = Model::findOrFail($id);
        return $this->item;
    }

    public function store(array $request) : Model
    {
        $data = WorkDTO::storeObjectRequest($request);
        $this->item = Model::create((array) $data);
        Model::flushQueryCache();
        return $this->item;
    }

    public function edit(int $id) : array
    {
        $this->item = Model::findOrFail($id);
        $cabinets = AllCatalogsDTO::getAllCabinetCollection();
        $users = AllCatalogsDTO::getAllUserCollection();
        return [
            'items' => $this->item,
            'cabinets' => $cabinets,
            'users' => $users,
        ];
    }

    public function update(array $request, int $id) : Model
    {
        $this->item = Model::findOrFail($id);
        $data = WorkDTO::storeObjectRequest($request);
        $this->item->update((array) $data);
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
