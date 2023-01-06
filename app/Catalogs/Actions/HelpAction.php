<?php

namespace App\Catalogs\Actions;

use App\Base\Actions\Action;
use App\Catalogs\DTO\AllCatalogsDTO;
use App\Catalogs\DTO\HelpDTO;
use App\Models\Help as Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection as SimpleCollection;

class HelpAction extends Action
{
    const workHelp = 1;
    const newHelp = 2;
    const successHelp = 3;
    const dangerHelp = 4;
    public function getAllPages() : Collection
    {
        $this->items = Model::orderBy('status_id', 'ASC')
        ->orderBy('calendar_execution', 'ASC')
        ->orderBy('calendar_warning', 'ASC')
        ->orderBy('calendar_final', 'DESC')
        ->get();
        return $this->items;
    }

    public function getAllPagesPaginate() :  LengthAwarePaginator
    {
        $this->items = Model::orderBy('status_id', 'ASC')
        ->orderBy('calendar_execution', 'ASC')
        ->orderBy('calendar_warning', 'ASC')
        ->orderBy('calendar_final', 'DESC')
        ->paginate($this->page);
        return $this->items;
    }

    public function getNewPagesPaginate() :  LengthAwarePaginator
    {
        $this->items = Model::where('status_id', self::newHelp)
        ->orderBy('calendar_request', 'DESC')
        ->paginate($this->page);
        return $this->items;
    }

    public function getWorkerAdmPagesPaginate() :  LengthAwarePaginator
    {
        $this->items = Model::where('status_id', self::workHelp)
        ->orderBy('calendar_accept', 'DESC')
        ->paginate($this->page);
        return $this->items;
    }

    public function getWorkerModPagesPaginate() :  LengthAwarePaginator
    {
        $this->items = Model::where('status_id', self::workHelp)
        ->where('executor_id', auth()->user()->id)
        ->orderBy('calendar_accept', 'DESC')
        ->paginate($this->page);
        return $this->items;
    }

    public function getCompletedAdmPagesPaginate() :  LengthAwarePaginator
    {
        $this->items = Model::where('status_id', self::successHelp)
        ->orderBy('calendar_final', 'DESC')
        ->paginate($this->page);
        return $this->items;
    }

    public function getCompletedModPagesPaginate() :  LengthAwarePaginator
    {
        $this->items = Model::where('status_id', self::successHelp)
        ->where('executor_id', auth()->user()->id)
        ->orderBy('calendar_final', 'DESC')
        ->paginate($this->page);
        return $this->items;
    }

    public function getDismissPagesPaginate() :  LengthAwarePaginator
    {
        $this->items = Model::where('status_id', self::dangerHelp)
        ->orderBy('calendar_request', 'DESC')
        ->paginate($this->page);
        return $this->items;
    }

    public function findCatalogsById(int $id) : Model
    {
        $this->item = Model::findOrFail($id);
        return $this->item;
    }

    public function create(): SimpleCollection
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
        $this->items = HelpDTO::storeObjectRequest($request);
        Model::create((array) $this->items);
        Model::flushQueryCache();
        return true;
    }

    public function edit(int $id) : array
    {
        $this->item = Model::findOrFail($id);
        $this->items = AllCatalogsDTO::getAllCatalogsCollection();
        return [
            'items' => $this->item,
            'data' => $this->items,
        ];
    }

    public function update(array $request, int $id) : Model
    {
        $this->item = Model::findOrFail($id);
        $this->data = HelpDTO::storeObjectRequest($request);
        $this->item->update((array) $this->data);
        Model::flushQueryCache();
        return $this->item;
    }

    public function accept(array $request, int $id) : Model
    {
        $this->item = Model::findOrFail($id);
        if ($this->item->work->user->id == auth()->user()->id) {
            throw new \Exception('Нельзя назначить самого себя');
        }
        if ($this->item->work->user->getRoleNames()[0] == 'user') {
            throw new \Exception('Нельзя назначить пользователя');
        }
        $this->data = HelpDTO::acceptObjectRequest($request, $id);
        $this->item->update((array) $this->data);
        Model::flushQueryCache();
        return $this->item;
    }

    public function execute(array $request, int $id) : Model
    {
        $this->item = Model::findOrFail($id);
        $this->data = HelpDTO::executeObjectRequest($request, $id);
        $this->item->update((array) $this->data);
        Model::flushQueryCache();
        return $this->item;
    }

    public function redefine(array $request, int $id) : Model
    {
        $this->item = Model::findOrFail($id);
        $this->data = HelpDTO::redefineObjectRequest($request, $id);
        $this->item->update((array) $this->data);
        Model::flushQueryCache();
        return $this->item;
    }

    public function reject(array $request, int $id) : Model
    {
        $this->item = Model::findOrFail($id);
        $this->data = HelpDTO::rejectObjectRequest($request, $id);
        $this->item->update((array) $this->data);
        Model::flushQueryCache();
        return $this->item;
    }

    public function delete(int $id) : bool
    {
        $this->item = Model::viewOneItem($id);
        $this->item->forceDelete();
        Model::flushQueryCache();
        return true;
    }
}
