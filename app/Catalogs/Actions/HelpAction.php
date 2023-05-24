<?php

namespace App\Catalogs\Actions;

use App\Base\Actions\Action;
use App\Base\Helpers\GeneratorAppNumberHelper;
use App\Base\Helpers\StoreFilesHelper;
use App\Catalogs\DTO\AllCatalogsDTO;
use App\Catalogs\DTO\HelpDTO;
use App\Models\Help as Model;
use App\Models\User;
use App\Notifications\HelpNotification;
use App\Requests\HelpRequest;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection as SimpleCollection;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Notification;

class HelpAction extends Action
{
    const newHelp = config('constants.request.new');

    const workHelp = config('constants.request.work');

    const successHelp = config('constants.request.success');

    const dangerHelp = config('constants.request.danger');

    private ?Model $last;

    private User $user;

    public User $superAdmin;

    public User $users;

    public User $userMod;

    public User $oldUserMod;

    public User $userHome;

    private Carbon $calendar_request;

    private SimpleCollection $options;

    private array $helps;

    private array $response;

    private array $dataClear;

    private int $count;

    private string $app_number;

    private ?string $images;

    private ?string $images_final;

    private ?int $lead_at;

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
        $this->helps =
        [
            'method' => 'alladm',
            'data' => $this->items,
        ];

        return $this->helps;
    }

    public function getNewPagesPaginate(): array
    {
        $this->items = Model::dontCache()->where('status_id', self::newHelp)
            ->orderBy('calendar_request', 'ASC')
            ->paginate($this->page);
        $this->helps =
        [
            'method' => 'newadm',
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
        $this->helps =
        [
            'method' => 'workeradm',
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
        $this->helps =
        [
            'method' => 'completedadm',
            'data' => $this->items,
        ];

        return $this->helps;
    }

    public function getDismissPagesPaginate(): array
    {
        $this->items = Model::dontCache()->where('status_id', self::dangerHelp)
            ->orderBy('calendar_final', 'DESC')
            ->paginate($this->page);
        $this->helps =
        [
            'method' => 'dismissadm',
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
        $this->user = User::findOrFail(auth()->user()->id);
        if ($this->user->can('new help')) {
            $this->item = Model::dontCache()->findOrFail($id);
        } else {
            $this->item = Model::dontCache()->where('user_id', $this->user->id)->orWhere('executor_id', $this->user->id)->first();
            if ($this->item === null) {
                abort(404);
            }

        }
        $this->item->images = json_decode($this->item->images, true);
        $this->item->images_final = json_decode($this->item->images_final, true);

        return $this->item;
    }

    protected function clear(HelpDTO $data): array
    {
        return array_diff((array) $data, ['', null, false]);
    }

    public function store(HelpRequest $request): JsonResponse
    {
        $this->last = Model::dontCache()->select('app_number')->orderBy('id', 'desc')->first();
        if ($this->last == null) {
            $this->app_number = GeneratorAppNumberHelper::generate();
        } else {
            $this->app_number = GeneratorAppNumberHelper::generate($this->last->app_number);
        }
        $this->calendar_request = Carbon::now();
        if ($request->hasFile('images')) {
            $this->images = json_encode(StoreFilesHelper::createFile($request->file('images'), 'images', 1920, 1080));
        } else {
            $this->images = $request->file('images');
        }
        $this->options = collect([
            'app_number' => $this->app_number,
            'calendar_request' => $this->calendar_request,
            'images' => $this->images,
        ]);
        $this->data = HelpDTO::storeObjectRequest($request, $this->options);
        $this->dataClear = $this->clear($this->data);
        $this->item = Model::create($this->dataClear);
        $superAdmin = User::role(['superAdmin'])->get();
        $users = User::role(['admin'])->get();
        Notification::send($superAdmin, new HelpNotification('alladm', route('help.index')));
        Notification::send($superAdmin, new HelpNotification('newadm', route('help.new')));
        Notification::send($users, new HelpNotification('newadm', route('help.new')));

        $this->response = [
            'message' => 'Заявка успешно добавлена!',
        ];

        return response()->success($this->response);
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

    public function update(HelpRequest $request, int $id): JsonResponse
    {
        $this->item = Model::dontCache()->findOrFail($id);
        $this->data = HelpDTO::storeObjectRequest($request);
        $this->dataClear = $this->clear($this->data);
        $this->item->update($this->dataClear);

        $this->response = [
            'message' => 'Заявка успешно обновлена!',
        ];

        return response()->success($this->response);
    }

    public function accept(HelpRequest $request, int $id): JsonResponse
    {
        $this->item = Model::dontCache()->findOrFail($id);
        $this->options = collect([
            'status_id' => self::workHelp,
            'calendar_accept' => Carbon::now(),
            'calendar_warning' => Carbon::now()->addHour($this->item->priority->warning_timer),
            'calendar_execution' => Carbon::now()->addHour($this->item->priority->danger_timer),
            'route' => route(config('constants.help.show'), $this->item->id),
            'check_write' => true,
        ]);
        $this->data = HelpDTO::storeObjectRequest($request, $this->options);
        $this->dataClear = $this->clear($this->data);
        $this->user = User::dontCache()->findOrFail($this->data->executor_id);
        if ($this->user->id == auth()->user()->id) {
            if ($this->user->getRoleNames()[0] != 'admin' && $this->user->getRoleNames()[0] != 'superAdmin') {
                $this->response = [
                    'message' => 'Нельзя назначить самого себя!',
                ];

                return response()->error($this->response);
            }
        }
        if ($this->user->getRoleNames()[0] == 'user') {
            $this->response = [
                'message' => 'Нельзя назначить пользователя!',
            ];

            return response()->error($this->response);
        }
        if ($this->item->status_id != self::newHelp) {
            $this->response = [
                'message' => 'Заявка уже принята или отклонена!',
            ];

            return response()->error($this->response);
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

        $this->response = [
            'message' => 'Заявка успешно принята!',
        ];

        return response()->success($this->response);
    }

    public function execute(HelpRequest $request, int $id): JsonResponse
    {
        $this->item = Model::dontCache()->findOrFail($id);
        if ($request->hasFile('images_final')) {
            $this->images_final = json_encode(StoreFilesHelper::createFile($request->file('images_final'), 'images', 1920, 1080));
        } else {
            $this->images_final = $request->file('images_final');
        }
        $this->lead_at = Carbon::now()->diffInSeconds(Carbon::parse($this->item->calendar_accept));
        $this->options = collect([
            'status_id' => self::successHelp,
            'calendar_final' => Carbon::now(),
            'check_write' => false,
            'images_final' => $this->images_final,
            'lead_at' => $this->lead_at,
            'route' => route(config('constants.help.show'), $this->item->id),
        ]);
        $this->data = HelpDTO::storeObjectRequest($request, $this->options);
        $this->dataClear = $this->clear($this->data);
        if ($this->item->status_id != self::workHelp) {
            $this->response = [
                'message' => 'Заявка уже выполнена или отклонена!',
            ];

            return response()->error($this->response);
        }
        $this->item->update($this->dataClear);

        $superAdmin = User::role(['superAdmin'])->get();
        $users = User::role(['admin'])->get();
        Notification::send($superAdmin, new HelpNotification('alladm', route('help.index')));
        Notification::send($superAdmin, new HelpNotification('completedadm', route('help.completed')));
        Notification::send($users, new HelpNotification('completedadm', route('help.completed')));

        $userHome = User::findOrFail($this->item->user_id);
        Notification::send($userHome, new HelpNotification('completeduser', route('home.completed')));

        $this->response = [
            'message' => 'Заявка успешно выполнена!',
        ];

        return response()->success($this->response);
    }

    public function redefine(HelpRequest $request, int $id): JsonResponse
    {
        $this->item = Model::dontCache()->findOrFail($id);
        $this->options = collect([
            'calendar_accept' => Carbon::now(),
        ]);
        $this->data = HelpDTO::storeObjectRequest($request, $this->options);
        $this->dataClear = $this->clear($this->data);
        $this->user = User::findOrFail($this->data->executor_id);
        if ($this->user->id == auth()->user()->id) {
            $this->response = [
                'message' => 'Нельзя назначить самого себя!',
            ];

            return response()->error($this->response);
        }
        if ($this->user->getRoleNames()[0] == 'user') {
            $this->response = [
                'message' => 'Нельзя назначить пользователя!',
            ];

            return response()->error($this->response);
        }
        if ($this->item->status_id != self::workHelp) {
            $this->response = [
                'message' => 'Заявка уже выполнена или отклонена!',
            ];

            return response()->error($this->response);
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

        $this->response = [
            'message' => 'Заявка успешно перенаправлена!',
            'route' => route(config('constants.help.show'), $this->item->id),
        ];

        return response()->success($this->response);
    }

    public function reject(HelpRequest $request, int $id): JsonResponse
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
            $this->response = [
                'message' => 'Заявка не может быть отклонена, так как уже принята в работу!',
            ];

            return response()->error($this->response);
        }
        $this->item->update($this->dataClear);

        $superAdmin = User::role(['superAdmin'])->get();
        $users = User::role(['admin'])->get();
        Notification::send($superAdmin, new HelpNotification('alladm', route('help.index')));
        Notification::send($superAdmin, new HelpNotification('dismissadm', route('help.dismiss')));
        Notification::send($users, new HelpNotification('dismissadm', route('help.dismiss')));

        $userHome = User::findOrFail($this->item->user_id);
        Notification::send($userHome, new HelpNotification('dismissuser', route('home.dismiss')));

        $this->response = [
            'message' => 'Заявка успешно отклонена!',
            'route' => route(config('constants.help.show'), $this->item->id),
        ];

        return response()->success($this->response);
    }

    public function delete(int $id): JsonResponse
    {
        $this->item = Model::dontCache()->findOrFail($id);
        $this->item->forceDelete();

        $this->response = [
            'message' => 'Заявка успешно удалена!',
        ];

        return response()->success($this->response);
    }

    public function updateView(int $id, bool $status = true): JsonResponse
    {
        Model::whereId($id)->update(['check_write' => $status]);

        return response()->success('Заявка успешно прочитана!');
    }

    public function getNewPagesCount(): JsonResponse
    {
        $this->user = User::findOrFail(auth()->user()->id);
        if ($this->user->can('new help')) {
            $this->count = Model::dontCache()->where('status_id', self::newHelp)->count();
            Cookie::queue('newCount', $this->count);
        } else {
            $this->count = 0;
        }

        return response()->json($this->count);
    }

    public function getNowPagesCount(): JsonResponse
    {
        $this->count = Model::dontCache()->where('status_id', self::workHelp)
            ->where('executor_id', auth()->user()->id)->count();

        return response()->json($this->count);
    }
}
