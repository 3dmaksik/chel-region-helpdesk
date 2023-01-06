<?php

namespace App\Catalogs\Actions;

use App\Base\Actions\Action;
use App\Catalogs\DTO\AllCatalogsDTO;
use App\Catalogs\DTO\HelpDTO;
use App\Models\Help as Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection as SimpleCollection;

class UserAction extends Action
{
    public function getWorkerPagesPaginate() :  LengthAwarePaginator
    {
        $this->items = Model::where('status_id', '<', 3)
        ->where('work_id', auth()->user()->id)
        ->orderBy('calendar_accept', 'DESC')
        ->paginate($this->page);
        return $this->items;
    }

    public function getCompletedPagesPaginate() :  LengthAwarePaginator
    {
        $this->items = Model::where('status_id', 3)
        ->where('work_id', auth()->user()->id)
        ->orderBy('calendar_final', 'DESC')
        ->paginate($this->page);
        return $this->items;
    }

    public function getDismissPagesPaginate() :  LengthAwarePaginator
    {
        $this->items = Model::where('status_id', 4)
        ->where('work_id', auth()->user()->id)
        ->orderBy('calendar_request', 'DESC')
        ->paginate($this->page);
        return $this->items;
    }

    public function create() : SimpleCollection
    {
        $this->items = AllCatalogsDTO::getAllCatalogsCollection();
        return $this->items;
    }

    public function show(int $id) : Model
    {
        $this->item = Model::findOrFail($id);
        $this->item->images = json_decode($this->item->images, true);
        return $this->item;
    }

    public function store(array $request) : bool
    {
        $this->data = HelpDTO::storeObjectRequest($request);
        Model::create((array) $this->data);
        Model::flushQueryCache();
        return true;
    }
}
