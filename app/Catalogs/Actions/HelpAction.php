<?php

namespace App\Catalogs\Actions;

use App\Base\Actions\Action;
use App\Models\Help as Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

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

    public function show(int $id) : Model
    {
        $this->item = Model::findOrFail($id);
        $this->item->images = json_decode($this->item->images, true);
        return $this->item;
    }

    public function store(array $request) : Model
    {
        $this->item = Model::create($request);
        Model::flushQueryCache();
        return $this->item;
    }

    public function update(array $request, int $id) : Model
    {
        $this->item = Model::findOrFail($id);
        if ($this->item->work_id == auth()->user()->id) {
            throw new \Exception('Нельзя назначить самого себя');
        }
        $this->item->update($request);
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
