<?php

namespace App\Catalogs\Actions;

use App\Base\Actions\Action;
use App\Base\Helpers\GeneratorAppNumberHelper;
use App\Catalogs\DTO\AllCatalogsDTO;
use App\Catalogs\DTO\HelpDTO;
use App\Models\Help as Model;
use App\Models\User;
use App\Notifications\HelpNotification;
use Illuminate\Support\Collection as SimpleCollection;
use Illuminate\Support\Facades\Notification;

class HomeAction extends Action
{
    private array $helps;
    private Model | null $last;
    private int $total;
    public User $superAdmin;
    public User $users;
    public function getWorkerPagesPaginate() :  array
    {
        $this->items = Model::dontCache()->where('status_id', '<', 3)
        ->where('user_id', auth()->user()->id)
        ->orderByRaw('CASE WHEN calendar_execution IS NULL THEN 0 ELSE 1 END ASC')
        ->orderByRaw('CASE WHEN calendar_warning IS NULL THEN 0 ELSE 1 END ASC')
        ->orderBy('calendar_accept', 'ASC')
        ->paginate($this->page);
        $this->total = Model::where('status_id', '<', 3)
        ->where('user_id', auth()->user()->id)->count();
        $this->helps =
        [
            'method' => 'workeruser',
            'total' => $this->total,
            'data' => $this->items,
        ];
        return $this->helps;
    }

    public function getCompletedPagesPaginate() :  array
    {
        $this->items = Model::dontCache()->where('status_id', 3)
        ->where('user_id', auth()->user()->id)
        ->orderBy('calendar_final', 'DESC')
        ->paginate($this->page);
        $this->total = Model::where('status_id', 3)
        ->where('user_id', auth()->user()->id)->count();
        $this->helps =
        [
            'method' => 'completeduser',
            'total' => $this->total,
            'data' => $this->items,
        ];
        return $this->helps;
    }

    public function getDismissPagesPaginate() :  array
    {
        $this->items = Model::dontCache()->where('status_id', 4)
        ->where('user_id', auth()->user()->id)
        ->orderBy('calendar_request', 'DESC')
        ->paginate($this->page);
        $this->total = Model::where('status_id', 4)
        ->where('user_id', auth()->user()->id)->count();
        $this->helps =
        [
            'method' => 'dismissuser',
            'total' => $this->total,
            'data' => $this->items,
        ];
        return $this->helps;
    }

    public function create() : SimpleCollection
    {
        $this->items = AllCatalogsDTO::getAllCatalogsCollection();
        return $this->items;
    }

    public function show(int $id) : Model
    {
        $this->item = Model::dontCache()->findOrFail($id);
        $this->item->images = json_decode($this->item->images, true);
        return $this->item;
    }

    public function store(array $request) : bool
    {
        $this->data = HelpDTO::storeObjectRequest($request);
        if (! isset($this->data->user_id)) {
            $this->data->user_id = auth()->user()->id;
        }
        $this->last = Model::dontCache()->select('app_number')->orderBy('id', 'desc')->first();
        if ($this->last == null) {
                $this->data->app_number = GeneratorAppNumberHelper::generate();
        } else {
                $this->data->app_number = GeneratorAppNumberHelper::generate($this->last->app_number);
        }
        $this->item = Model::dontCache()->create((array) $this->data);
        $superAdmin = User::role(['superAdmin'])->get();
        $users = User::role(['admin'])->get();
        Notification::send($superAdmin, new HelpNotification('alladm', route('help.index')));
        Notification::send($superAdmin, new HelpNotification('newadm', route('help.new')));
        Notification::send($users, new HelpNotification('newadm', route('help.new')));
        return true;
    }
}
