<?php

namespace App\Catalogs\Actions;

use App\Base\Actions\Action;
use App\Catalogs\DTO\AllCatalogsDTO;
use App\Catalogs\DTO\WorkDTO;
use App\Models\Work as Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection as SimpleCollection;

class WorkAction extends Action
{
    private SimpleCollection $cabinets;
    private SimpleCollection $users;
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
        $this->cabinets = AllCatalogsDTO::getAllCabinetCollection();
        $this->users = AllCatalogsDTO::getAllUserCollection();
        return [
            'cabinets' => $this->cabinets,
            'users' => $this->users,
        ];
    }

    public function show(int $id): Model
    {
        $this->item = Model::findOrFail($id);
        return $this->item;
    }

    public function store(array $request) : bool
    {
        $this->data = WorkDTO::storeObjectRequest($request);
        Model::create((array) $this->data);
        Model::flushQueryCache();
        return true;
    }

    public function edit(int $id) : array
    {
        $this->item = Model::findOrFail($id);
        $this->cabinets = AllCatalogsDTO::getAllCabinetCollection();
        $this->users = AllCatalogsDTO::getAllUserCollection();
        return [
            'items' => $this->item,
            'cabinets' => $this->cabinets,
            'users' => $this->users,
        ];
    }

    public function update(array $request, int $id) : Model
    {
        $this->item = Model::findOrFail($id);
        $this->data = WorkDTO::storeObjectRequest($request);
        $this->item->update((array) $this->data);
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
