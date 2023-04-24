<?php

namespace App\Catalogs\Actions;

use App\Base\Actions\Action;
use App\Base\Helpers\GeneratorAppNumberHelper;
use App\Catalogs\DTO\AllCatalogsDTO;
use App\Catalogs\DTO\HelpDTO;
use App\Models\Help as Model;
use App\Models\User;
use App\Notifications\HelpNotification;
use App\Requests\HelpRequest;
use Carbon\Carbon;
use Illuminate\Support\Collection as SimpleCollection;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Notification;

class HelpAction extends Action
{
    const newHelp = 1;

    const workHelp = 2;

    const successHelp = 3;

    const dangerHelp = 4;

    private Model|null $last;

    private User $user;

    public User $superAdmin;

    public User $users;

    public User $userMod;

    public User $oldUserMod;

    public User $userHome;

    private Carbon $calendar_request;

    private SimpleCollection $options;

    private array $helps;

    private array $dataClear;

    private int $total;

    private int $count;

    private string $app_number;

    public function getAllCatalogs(): SimpleCollection
    {
        $this->items = AllCatalogsDTO::getAllCatalogsCollection();

        return $this->items;
    }

    public function getAllPagesPaginate(): array
    {
        $this->items = Model::dontCache()->orderBy('status_id', 'ASC')
        ->orderByRaw('CASE WHEN calendar_execution IS NULL THEN 0 ELSE 1 END ASC')
        ->orderByRaw('CASE WHEN calendar_warning IS NULL THEN 0 ELSE 1 END ASC')
        ->orderBy('calendar_final', 'DESC')
        ->paginate($this->page);
        $this->total = Model::count();
        $this->helps =
        [
            'method' => 'alladm',
            'total' => $this->total,
            'data' => $this->items,
        ];

        return $this->helps;
    }

    public function getNewPagesPaginate(): array
    {
        $this->items = Model::dontCache()->where('status_id', self::newHelp)
        ->orderBy('calendar_request', 'ASC')
        ->paginate($this->page);
        $this->total = Model::where('status_id', self::newHelp)->count();
        $this->helps =
        [
            'method' => 'newadm',
            'total' => $this->total,
            'data' => $this->items,
        ];

        return $this->helps;
    }

    public function getWorkerPagesPaginate(): array
    {
        $this->items = Model::dontCache()->where('status_id', self::workHelp)
        ->RoleHelp()
        ->orderByRaw('CASE WHEN calendar_execution IS NULL THEN 0 ELSE 1 END ASC')
        ->orderByRaw('CASE WHEN calendar_warning IS NULL THEN 0 ELSE 1 END ASC')
        ->paginate($this->page);
        $this->total = Model::where('status_id', self::workHelp)->count();
        $this->helps =
        [
            'method' => 'workeradm',
            'total' => $this->total,
            'data' => $this->items,
        ];

        return $this->helps;
    }

    public function getCompletedPagesPaginate(): array
    {
        $this->items = Model::dontCache()->where('status_id', self::successHelp)
        ->RoleHelp()
        ->orderBy('calendar_final', 'DESC')
        ->paginate($this->page);
        $this->total = Model::where('status_id', self::successHelp)->count();
        $this->helps =
        [
            'method' => 'completedadm',
            'total' => $this->total,
            'data' => $this->items,
        ];

        return $this->helps;
    }

    public function getDismissPagesPaginate(): array
    {
        $this->items = Model::dontCache()->where('status_id', self::dangerHelp)
        ->orderBy('calendar_final', 'DESC')
        ->paginate($this->page);
        $this->total = Model::where('status_id', self::dangerHelp)->count();
        $this->helps =
        [
            'method' => 'dismissadm',
            'total' => $this->total,
            'data' => $this->items,
        ];

        return $this->helps;
    }

    public function findCatalogsById(int $id): Model
    {
        $this->item = Model::dontCache()->findOrFail($id);

        return $this->item;
    }

    public function create(): SimpleCollection
    {
        $this->items = AllCatalogsDTO::getAllCatalogsCollection();

        return $this->items;
    }

    public function show(int $id): Model
    {
        $this->item = Model::dontCache()->findOrFail($id);
        $this->item->images = json_decode($this->item->images, true);
        $this->item->images_final = json_decode($this->item->images_final, true);

        return $this->item;
    }

    protected function clear(HelpDTO $data): array
    {
        return array_diff((array) $data, ['', null, false]);
    }

    public function store(HelpRequest $request): bool
    {
        $this->last = Model::dontCache()->select('app_number')->orderBy('id', 'desc')->first();
        if ($this->last == null) {
                $this->app_number = GeneratorAppNumberHelper::generate();
        } else {
                $this->app_number = GeneratorAppNumberHelper::generate($this->last->app_number);
        }
        $this->calendar_request = Carbon::now();
        $this->options = collect([
            'app_number' => $this->app_number,
            'calendar_request' => $this->calendar_request,
        ]);
        $this->data = HelpDTO::storeObjectRequest($request, $this->options);
        $this->dataClear = $this->clear($this->data);
        $this->item = Model::create($this->dataClear);
        $superAdmin = User::role(['superAdmin'])->get();
        $users = User::role(['admin'])->get();
        Notification::send($superAdmin, new HelpNotification('alladm', route('help.index')));
        Notification::send($superAdmin, new HelpNotification('newadm', route('help.new')));
        Notification::send($users, new HelpNotification('newadm', route('help.new')));

        return true;
    }

    public function edit(int $id): array
    {
        $this->item = Model::dontCache()->findOrFail($id);
        $this->items = AllCatalogsDTO::getAllCatalogsCollection();

        return [
            'item' => $this->item,
            'data' => $this->items,
        ];
    }

    public function update(HelpRequest $request, int $id): Model
    {
        $this->item = Model::dontCache()->findOrFail($id);
        $this->data = HelpDTO::storeObjectRequest($request);
        $this->dataClear = $this->clear($this->data);
        $this->item->update($this->dataClear);

        return $this->item;
    }

    public function accept(HelpRequest $request, int $id): Model
    {
        $this->item = Model::dontCache()->findOrFail($id);
        $this->options = collect([
            'status_id' => self::workHelp,
            'calendar_accept' => Carbon::now(),
            'calendar_warning' => Carbon::now()->addHour($this->item->priority->warning_timer),
            'calendar_execution' => Carbon::now()->addHour($this->item->priority->danger_timer),
            'check_write' => true,
        ]);
        $this->data = HelpDTO::storeObjectRequest($request, $this->options);
        $this->dataClear = $this->clear($this->data);
        $this->user = User::dontCache()->findOrFail($this->data->executor_id);
        if ($this->user->id == auth()->user()->id) {
            if ($this->user->getRoleNames()[0] != 'admin' && $this->user->getRoleNames()[0] != 'superAdmin') {
                throw new \Exception('Нельзя назначить самого себя');
            }
        }
        if ($this->user->getRoleNames()[0] == 'user') {
            throw new \Exception('Нельзя назначить пользователя');
        }
        if ($this->item->status_id != self::newHelp) {
            throw new \Exception('Заявка уже принята или отклонена');
        }
        $this->item->update($this->dataClear);

        $superAdmin = User::role(['superAdmin'])->get();
        $users = User::role(['admin'])->get();
        Notification::send($superAdmin, new HelpNotification('workeradm', route('help.worker')));
        Notification::send($superAdmin, new HelpNotification('alladm', route('help.index')));
        Notification::send($users, new HelpNotification('workeradm', route('help.worker')));

        $userMod = User::findOrFail($this->item->executor_id);
        Notification::send($userMod, new HelpNotification('workeradm', route('help.worker')));

        $userHome = User::findOrFail($this->item->user_id);
        Notification::send($userHome, new HelpNotification('workeruser', route('home.worker')));

        return $this->item;
    }

    public function execute(HelpRequest $request, int $id): Model
    {
        $this->item = Model::dontCache()->findOrFail($id);
        $this->options = collect([
            'status_id' => self::successHelp,
            'calendar_final' => Carbon::now(),
            'check_write' => false,
        ]);
        $this->data = HelpDTO::storeObjectRequest($request, $this->options);
        $this->dataClear = $this->clear($this->data);
        if ($this->item->status_id != self::workHelp) {
            throw new \Exception('Заявка уже выполнена или отклонена');
        }
        $this->item->update($this->dataClear);

        $superAdmin = User::role(['superAdmin'])->get();
        $users = User::role(['admin'])->get();
        Notification::send($superAdmin, new HelpNotification('alladm', route('help.index')));
        Notification::send($superAdmin, new HelpNotification('completedadm', route('help.completed')));
        Notification::send($users, new HelpNotification('completedadm', route('help.completed')));

        $userHome = User::findOrFail($this->item->user_id);
        Notification::send($userHome, new HelpNotification('completeduser', route('home.completed')));

        return $this->item;
    }

    public function redefine(HelpRequest $request, int $id): Model
    {
        $this->item = Model::dontCache()->findOrFail($id);
        $this->options = collect([
            'calendar_accept' => Carbon::now(),
        ]);
        $this->data = HelpDTO::storeObjectRequest($request, $this->options);
        $this->dataClear = $this->clear($this->data);
        $this->user = User::findOrFail($this->data->executor_id);
        if ($this->user->id == auth()->user()->id) {
            throw new \Exception('Нельзя назначить самого себя');
        }
        if ($this->user->getRoleNames()[0] == 'user') {
            throw new \Exception('Нельзя назначить пользователя');
        }
        if ($this->item->status_id != self::workHelp) {
            throw new \Exception('Заявка уже выполнена или отклонена');
        }
        $oldUserMod = User::findOrFail($this->item->executor_id);
        $this->item->update($this->dataClear);

        $superAdmin = User::role(['superAdmin'])->get();
        $users = User::role(['admin'])->get();
        Notification::send($superAdmin, new HelpNotification('alladm', route('help.index')));
        Notification::send($superAdmin, new HelpNotification('workeradm', route('help.worker')));
        Notification::send($users, new HelpNotification('workeradm', route('help.worker')));

        $userMod = User::findOrFail($this->item->executor_id);
        Notification::send($oldUserMod, new HelpNotification('workeradm', route('help.worker')));
        Notification::send($userMod, new HelpNotification('workeradm', route('help.worker')));

        $userHome = User::findOrFail($this->item->user_id);
        Notification::send($userHome, new HelpNotification('workeruser', route('home.worker')));

        return $this->item;
    }

    public function reject(HelpRequest $request, int $id): Model
    {
        $this->item = Model::dontCache()->findOrFail($id);
        $this->options = collect([
            'status_id' => self::dangerHelp,
            'calendar_final' => Carbon::now(),
            'check_write' => false,
        ]);
        $this->data = HelpDTO::storeObjectRequest($request, $this->options);
        $this->dataClear = $this->clear($this->data);
        if ($this->item->status_id != self::newHelp) {
            throw new \Exception('Заявка не может быть отклонена');
        }
        $this->item->update($this->dataClear);

        $superAdmin = User::role(['superAdmin'])->get();
        $users = User::role(['admin'])->get();
        Notification::send($superAdmin, new HelpNotification('alladm', route('help.index')));
        Notification::send($superAdmin, new HelpNotification('dismissadm', route('help.dismiss')));
        Notification::send($users, new HelpNotification('dismissadm', route('help.dismiss')));

        $userHome = User::findOrFail($this->item->user_id);
        Notification::send($userHome, new HelpNotification('dismissuser', route('home.dismiss')));

        return $this->item;
    }

    public function delete(int $id): bool
    {
        $this->item = Model::dontCache()->findOrFail($id);
        $this->item->forceDelete();

        return true;
    }

    public function updateView(int $id, bool $status = true): bool
    {
        return Model::whereId($id)->update(['check_write' => $status]);
    }

    public function getNewPagesCount(): int
    {
        if (auth()->user()->hasAnyRole(['admin', 'superAdmin']) == true) {
           $this->count = Model::dontCache()->where('status_id', self::newHelp)->count();
           Cookie::queue('newCount', $this->count);
        } else {
            $this->count = 0;
        }

         return $this->count;
    }

    public function getNowPagesCount(): int
    {
        return Model::dontCache()->where('status_id', self::workHelp)
        ->where('executor_id', auth()->user()->id)->count();
    }
}
