<?php

namespace App\Catalogs\Actions;

use App\Base\Actions\Action;
use App\Base\Helpers\GeneratorAppNumberHelper;
use App\Base\Helpers\StoreFilesHelper;
use App\Catalogs\DTO\HelpDTO;
use App\Core\Contracts\ICatalog;
use App\Core\Contracts\ICatalogExtented;
use App\Core\Contracts\IHelp;
use App\Models\Category;
use App\Models\Help as Model;
use App\Models\Priority;
use App\Models\User;
use App\Notifications\HelpNotification;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Notification;

/**
 * [case status]
 *
 * @var'1'|'2'|'3'|'4'
 */
enum Status: int
{
    case New = 1;
    case Work = 2;
    case Success = 3;
    case Danger = 4;
}
final class HelpAction extends Action implements ICatalog, ICatalogExtented, IHelp
{
    /**
     * [items help data paginate]
     *
     * @var helps
     */
    private array $helps;

    /**
     * [all category]
     *
     * @var collectCategory
     */
    private Collection $collectCategory;

    /**
     * [all user]
     *
     * @var collectUser
     */
    private Collection $collectUser;

    /**
     * [all priority]
     *
     * @var collectPriority
     */
    private Collection $collectPriority;

    /**
     * [result data collection or json]
     *
     * @var collectData
     */
    private array|string $collectData;

    /**
     * [last app number or null]
     *
     * @var last
     */
    private ?Model $last = null;

    /**
     * [new app number]
     *
     * @var app_number
     */
    private string $app_number;

    /**
     * [date request help]
     *
     * @var calendar_request
     */
    private Carbon $calendar_request;

    /**
     * [images help request]
     *
     * @var images
     */
    private ?string $images = null;

    /**
     * [this user in task]
     */
    private User $user;

    /**
     * [all super admin]
     *
     * @var superAdmin
     */
    public User $superAdmin;

    /**
     * [all admins]
     *
     * @var admins
     */
    public User $admins;

    /**
     * [this executor in task]
     *
     * @var userMod
     */
    public User $userMod;

    /**
     * [this user work in task]
     *
     * @var userHome
     */
    public User $userHome;

    /**
     * [this old executor in task]
     *
     * @var images
     */
    public User $oldUserMod;

    /**
     * [images help in final task]
     *
     * @var images_final
     */
    private ?string $images_final = null;

    /**
     * [count help]
     *
     * @var images
     */
    private int $count;

    /**
     * [request user or auth]
     *
     * @var userId
     */
    private int $userId;

    /**
     * [all helps with count items on page]
     *
     * @return array{method: string, data: Illuminate\Pagination\LengthAwarePaginator}
     */
    public function getAllPagesPaginate(): array
    {
        $this->items = Model::query()->orderBy('status_id', 'ASC')
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

    /**
     * [new helps with count items on page]
     *
     * @return array{method: string, data: Illuminate\Pagination\LengthAwarePaginator}
     */
    public function getNewPagesPaginate(): array
    {
        $this->items = Model::query()->where('status_id', Status::New)
            ->orderBy('calendar_request', 'ASC')
            ->paginate($this->page);
        $this->helps =
        [
            'method' => 'newadm',
            'data' => $this->items,
        ];

        return $this->helps;
    }

    /**
     * [worker helps with count items on page]
     *
     * @return array{method: string, data: Illuminate\Pagination\LengthAwarePaginator}
     */
    public function getWorkerPagesPaginate(): array
    {
        $this->items = Model::query()->where('status_id', Status::Work)
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

    /**
     * [completed helps with count items on page]
     *
     * @return array{method: string, data: Illuminate\Pagination\LengthAwarePaginator}
     */
    public function getCompletedPagesPaginate(): array
    {
        $this->items = Model::query()->where('status_id', Status::Success)
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

    /**
     * [danger helps with count items on page]
     *
     * @return array{method: string, data: Illuminate\Pagination\LengthAwarePaginator}
     */
    public function getDismissPagesPaginate(): array
    {
        $this->items = Model::query()->where('status_id', Status::Danger)
            ->orderBy('calendar_final', 'DESC')
            ->paginate($this->page);
        $this->helps =
        [
            'method' => 'dismissadm',
            'data' => $this->items,
        ];

        return $this->helps;
    }

    /**
     * [all category, users with chunk load items on page]
     *
     * @return array{categories: Illuminate\Support\Collection, users: Illuminate\Support\Collection}
     */
    public function create(): array
    {
        $this->collectCategory = $this->getAllCategoryCollection();
        $this->collectUser = $this->getAllUserCollection();

        $this->collectData =
        [
            'categories' => $this->collectCategory,
            'users' => $this->collectUser,
        ];

        return $this->collectData;
    }

    /**
     * [show one help]
     *
     * @return array{data: \App\Models\Help}
     */
    public function show(int $id): array
    {
        $this->user = User::query()->find(auth()->user()->id);
        if (! $this->user) {

            return abort(404);
        }

        if ($this->user->can('new help')) {
            $this->item = Model::query()->find($id);
        } else {
            $this->item = Model::query()->where('id',$id)->where('user_id', $this->user->id)->orWhere('executor_id', $this->user->id)->first();
        }
        if (! $this->item) {

            return abort(404);
        }
        $this->checkWrite($this->item);

        $this->response =
        [
            'data' => $this->item,
        ];

        return $this->response;
    }

    /**
     * [get api for form help]
     */
    public function getApiCatalog(): JsonResponse
    {
        $this->collectPriority = $this->getAllPriorityCollection();
        $this->collectUser = $this->getAllExecutorCollection();

        $this->collectData = collect(
            [
                'priority' => $this->collectPriority,
                'user' => $this->collectUser,
            ])->toJson();

        return response()->success($this->collectData);
    }

    /**
     * [add new help]
     *
     * @param  array  $request {category_id: string, user_id: int, description_long: string, images: \Illuminate\Http\UploadedFile|null}
     */
    public function store(array $request): JsonResponse
    {
        $this->last = Model::select('app_number')->orderBy('id', 'desc')->first();
        $this->last ? $this->app_number = GeneratorAppNumberHelper::generate($this->last->app_number) : $this->app_number = GeneratorAppNumberHelper::generate();
        $this->calendar_request = Carbon::now();
        $this->userId = $request['user_id'] ?? auth()->user()->id;

        $this->dataObject = new HelpDTO(
            number : $this->app_number,
            category : (int) $request['category_id'],
            status : Status::New,
            user : $this->userId,
            description_long : $request['description_long'],
            request : $this->calendar_request,
            images : $request['images'] ?? null,
        );
        $this->item = new Model();
        if ($this->dataObject->images) {
            $this->images = collect(StoreFilesHelper::createFileImages($this->dataObject->images, 'images', 1920, 1080))->toJson();
            $this->item->images = $this->images;
        }
        $this->item->app_number = $this->dataObject->appNumber;
        $this->item->category_id = $this->dataObject->category;
        $this->item->status_id = $this->dataObject->status;
        $this->item->user_id = $this->dataObject->user;
        $this->item->description_long = $this->dataObject->descriptionLong;
        $this->item->calendar_request = $this->dataObject->calendarRequest;
        $this->item->save();

        $this->response = [
            'message' => 'Заявка успешно добавлена!',
        ];

        $superAdmin = User::role(['superAdmin'])->get();
        Notification::send($superAdmin, new HelpNotification('alladm', route('help.index')));
        Notification::send($superAdmin, new HelpNotification('newadm', route('help.new')));

        $admins = User::role(['admin'])->get();
        Notification::send($admins, new HelpNotification('newadm', route('help.new')));

        return response()->success($this->response);
    }

    /**
     * [edit help]
     *
     * @return array{item: \App\Models\Help, category: \Illuminate\Support\Collection, priority: \Illuminate\Support\Collection, user: \Illuminate\Support\Collection}
     */
    public function edit(int $id): array
    {
        $this->item = Model::query()->find($id);
        if (! $this->item) {

            return abort(404);
        }
        $this->collectCategory = $this->getAllCategoryCollection();
        $this->collectPriority = $this->getAllPriorityCollection();
        $this->collectUser = $this->getAllExecutorCollection();

        $this->collectData =
            [
                'item' => $this->item,
                'category' => $this->collectCategory,
                'priority' => $this->collectPriority,
                'user' => $this->collectUser,
            ];

        return $this->collectData;
    }

    /**
     * [update help]
     *
     * @param  array  $request {category_id: int, user_id: int, priority_id: int}
     */
    public function update(array $request, int $id): JsonResponse
    {
        $this->item = Model::query()->find($id);
        if (! $this->item) {

            return abort(404);
        }

        $this->dataObject = new HelpDTO(
            category : (int) $request['category_id'],
            user : (int) $request['user_id'],
            priority : (int) $request['priority_id'],
        );
        $this->item->category_id = $this->dataObject->category;
        $this->item->user_id = $this->dataObject->user;
        $this->item->priority_id = $this->dataObject->priority;
        $this->item->save();

        $this->response = [
            'message' => 'Заявка успешно обновлена!',
        ];

        $superAdmin = User::role(['superAdmin'])->get();
        Notification::send($superAdmin, new HelpNotification('alladm', route('help.index')));
        Notification::send($superAdmin, new HelpNotification('newadm', route('help.new')));

        $admins = User::role(['admin'])->get();
        Notification::send($admins, new HelpNotification('newadm', route('help.new')));

        $userHome = User::find($this->item->user_id);
        if (! $userHome) {

            return abort(404);
        }
        Notification::send($userHome, new HelpNotification('workeruser', route('home.worker')));

        return response()->success($this->response);
    }

    /**
     * [accept help]
     *
     * @param  array  $request {executor_id: int, priority_id: int, info: string}
     */
    public function accept(array $request, int $id): JsonResponse
    {
        $this->item = Model::query()->find($id);
        if (! $this->item) {

            return abort(404);
        }
        if ($this->item->status_id !== Status::New->value) {
            $this->response = [
                'message' => 'Заявка уже принята или отклонена!',
            ];

            return response()->error($this->response);
        }
        $this->dataObject = new HelpDTO(
            executor: (int) $request['executor_id'],
            priority : (int) $request['priority_id'],
            info : (string) $request['info'] ?? null,
            status : Status::Work,
            accept: Carbon::now(),
            warning : Carbon::now()->addHour($this->item->priority->warning_timer),
            execution : Carbon::now()->addHour($this->item->priority->danger_timer),
            checkWrite : true,
        );
        $this->user = User::query()->find($this->dataObject->executor);
        if (! $this->user) {

            return abort(404);
        }
        if ($this->user->id === auth()->user()->id) {
            if ($this->user->getRoleNames()[0] !== 'admin' && $this->user->getRoleNames()[0] !== 'superAdmin') {
                $this->response = [
                    'message' => 'Нельзя назначить самого себя!',
                ];

                return response()->error($this->response);
            }
        }
        if ($this->user->getRoleNames()[0] === 'user') {
            $this->response = [
                'message' => 'Нельзя назначить пользователя!',
            ];

            return response()->error($this->response);
        }
        $this->item->executor_id = $this->user->id;
        $this->item->priority_id = $this->dataObject->priority;
        $this->item->info = $this->dataObject->info;
        $this->item->status_id = $this->dataObject->status;
        $this->item->calendar_accept = $this->dataObject->calendarAccept;
        $this->item->calendar_warning = $this->dataObject->calendarWarning;
        $this->item->calendar_execution = $this->dataObject->calendarExecution;
        $this->item->check_write = $this->dataObject->checkWrite;
        $this->item->save();

        $superAdmin = User::role(['superAdmin'])->get();
        Notification::send($superAdmin, new HelpNotification('alladm', route('help.index')));
        Notification::send($superAdmin, new HelpNotification('newadm', route('help.new')));
        Notification::send($superAdmin, new HelpNotification('workeradm', route('help.worker')));

        $admins = User::role(['admin'])->get();
        Notification::send($admins, new HelpNotification('newadm', route('help.new')));
        Notification::send($admins, new HelpNotification('workeradm', route('help.worker')));

        $userMod = $this->user;
        if ($userMod->getRoleNames()[0] === 'manager') {
            Notification::send($userMod, new HelpNotification('workeradm', route('help.worker')));
        }

        $userHome = User::find($this->item->user_id);
        if (! $userHome) {

            return abort(404);
        }
        Notification::send($userHome, new HelpNotification('workeruser', route('home.worker')));

        $this->response = [
            'message' => 'Заявка успешно принята!',
            'reload' => true,
        ];

        return response()->success($this->response);
    }

    /**
     * [execute help]
     *
     * @param  array  $request {info_final: string|null, images_final: \Illuminate\Http\UploadedFile|null}
     */
    public function execute(array $request, int $id): JsonResponse
    {
        $this->item = Model::query()->find($id);
        if (! $this->item) {

            return abort(404);
        }
        if ($this->item->status_id !== Status::Work->value) {
            $this->response = [
                'message' => 'Заявка уже выполнена или отклонена!',
            ];

            return response()->error($this->response);
        }
        $this->dataObject = new HelpDTO(
            info_final: (string) $request['info_final'] ?? null,
            images_final : $request['images_final'] ?? null,
            status : Status::Success,
            calendar_final: Carbon::now(),
            lead_at : Carbon::now()->diffInSeconds(Carbon::parse($this->item->calendar_accept)),
            checkWrite : false,
        );
        if ($this->dataObject->imagesFinal) {
            $this->images_final = collect(StoreFilesHelper::createFileImages($this->dataObject->imagesFinal, 'images', 1920, 1080))->toJson();
            $this->item->images_final = $this->images_final;
        }

        $this->item->info_final = $this->dataObject->infoFinal;
        $this->item->status_id = $this->dataObject->status;
        $this->item->calendar_final = $this->dataObject->calendarFinal;
        $this->item->lead_at = $this->dataObject->leadAt;
        $this->item->check_write = $this->dataObject->checkWrite;
        $this->item->save();

        $superAdmin = User::role(['superAdmin'])->get();
        Notification::send($superAdmin, new HelpNotification('alladm', route('help.index')));
        Notification::send($superAdmin, new HelpNotification('workeradm', route('help.worker')));
        Notification::send($superAdmin, new HelpNotification('completedadm', route('help.completed')));

        $admins = User::role(['admin'])->get();
        Notification::send($admins, new HelpNotification('workeradm', route('help.worker')));
        Notification::send($admins, new HelpNotification('completedadm', route('help.completed')));

        $userHome = User::find($this->item->user_id);
        if (! $userHome) {

            return abort(404);
        }
        Notification::send($userHome, new HelpNotification('workeruser', route('home.worker')));
        Notification::send($userHome, new HelpNotification('completeduser', route('home.completed')));

        $this->response = [
            'message' => 'Заявка успешно выполнена!',
            'reload' => true,
        ];

        return response()->success($this->response);
    }

    /**
     * [redefine help]
     *
     * @param  array  $request {executor_id: int}
     */
    public function redefine(array $request, int $id): JsonResponse
    {
        $this->item = Model::query()->find($id);
        if (! $this->item) {

            return abort(404);
        }
        if ($this->item->status_id !== Status::Work->value) {
            $this->response = [
                'message' => 'Заявка уже выполнена или отклонена!',
            ];

            return response()->error($this->response);
        }
        $this->dataObject = new HelpDTO(
            executor: (int) $request['executor_id'],
        );

        $this->user = User::query()->find($this->dataObject->executor);
        if (! $this->user) {

            return abort(404);
        }
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
        $this->item->executor_id = $this->user->id;
        $this->item->save();

        $this->response = [
            'message' => 'Заявка успешно перенаправлена!',
            'reload' => true,
        ];

        $superAdmin = User::role(['superAdmin'])->get();
        Notification::send($superAdmin, new HelpNotification('alladm', route('help.index')));
        Notification::send($superAdmin, new HelpNotification('workeradm', route('help.worker')));

        $admins = User::role(['admin'])->get();
        Notification::send($admins, new HelpNotification('workeradm', route('help.worker')));

        $oldUserMod = $this->user;
        if ($oldUserMod->getRoleNames()[0] === 'manager') {
            Notification::send($oldUserMod, new HelpNotification('workeradm', route('help.worker')));
        }

        $userMod = User::query()->find($this->item->executor_id);
        if (! $userMod) {

            return abort(404);
        }
        if ($userMod->getRoleNames()[0] === 'manager') {
            Notification::send($userMod, new HelpNotification('workeradm', route('help.worker')));
        }

        $userHome = User::query()->find($this->item->user_id);
        if (! $userHome) {

            return abort(404);
        }
        Notification::send($userHome, new HelpNotification('workeruser', route('home.worker')));

        return response()->success($this->response);
    }

    /**
     * [reject help]
     *
     * @param  array  $request {info_final: string|null}
     */
    public function reject(array $request, int $id): JsonResponse
    {
        $this->item = Model::query()->find($id);
        if (! $this->item) {

            return abort(404);
        }
        if ($this->item->status_id !== Status::New->value) {
            $this->response = [
                'message' => 'Заявка не может быть отклонена, так как уже принята в работу!',
            ];

            return response()->error($this->response);
        }
        $this->dataObject = new HelpDTO(
            info_final: (string) $request['info_final'] ?? null,
            status : Status::Danger,
            accept: Carbon::now(),
            calendar_final: Carbon::now(),
            lead_at : 60,
            checkWrite : false,
        );
        $this->item->info_final = $this->dataObject->infoFinal;
        $this->item->status_id = $this->dataObject->status;
        $this->item->calendar_accept = $this->dataObject->calendarAccept;
        $this->item->calendar_final = $this->dataObject->calendarFinal;
        $this->item->lead_at = $this->dataObject->leadAt;
        $this->item->check_write = $this->dataObject->checkWrite;
        $this->item->save();

        $superAdmin = User::role(['superAdmin'])->get();
        Notification::send($superAdmin, new HelpNotification('alladm', route('help.index')));
        Notification::send($superAdmin, new HelpNotification('newadm', route('help.new')));
        Notification::send($superAdmin, new HelpNotification('dismissadm', route('help.dismiss')));

        $admins = User::role(['admin'])->get();
        Notification::send($superAdmin, new HelpNotification('newadm', route('help.new')));
        Notification::send($admins, new HelpNotification('dismissadm', route('help.dismiss')));

        $userHome = User::query()->find($this->item->user_id);
        if (! $userHome) {

            return abort(404);
        }
        Notification::send($userHome, new HelpNotification('dismissuser', route('home.dismiss')));

        $this->response = [
            'message' => 'Заявка успешно отклонена!',
            'reload' => true,
        ];

        return response()->success($this->response);
    }

    /**
     * [remove help]
     *
     */
    public function destroy(int $id): JsonResponse
    {
        $this->item = Model::query()->find($id);
        if (! $this->item) {

            return abort(404);
        }
        $this->item->forceDelete();

        $this->response = [
            'message' => 'Заявка успешно удалена!',
            'reload' => true,
        ];

        return response()->success($this->response);
    }

    /**
     * [writable help]
     *
     */
    public function updateView(int $id, bool $status = true): JsonResponse
    {
        $this->item = Model::query()->find($id);
        if (! $this->item) {

            return abort(404);
        }
        $this->dataObject = new HelpDTO(
            checkWrite : $status,
        );
        $this->item->check_write = $this->dataObject->checkWrite;
        $this->item->save();

        $this->response = [
            'message' => 'Заявка успешно прочитана!',
            'reload' => true,
        ];

        return response()->success($this->response);
    }

    /**
     * [get new help count]
     *
     */
    public function getNewPagesCount(): JsonResponse
    {
        $this->user = User::findOrFail(auth()->user()->id);
        if ($this->user->can('new help')) {
            $this->count = Model::where('status_id', Status::New)->count();
            Cookie::queue('newCount', $this->count);
        } else {
            $this->count = 0;
            if (Cookie::get('newCount') !== null) {
                Cookie::forget('newCount');
            }
        }

        return response()->json($this->count);
    }

    /**
     * [get now help count]
     *
     */
    public function getNowPagesCount(): JsonResponse
    {
        $this->count = Model::where('status_id', Status::Work)
            ->where('executor_id', auth()->user()->id)->count();

        return response()->json($this->count);
    }

    protected function getAllCategoryCollection(): Collection
    {
        $rows = collect();
        Category::chunk(100, function ($categories) use ($rows) {
            foreach ($categories as $category) {
                $rows->push($category);
            }
        });

        return $rows;
    }

    protected function getAllPriorityCollection(): Collection
    {
        $rows = collect();
        Priority::query()->chunk(100, function ($categories) use ($rows) {
            foreach ($categories as $category) {
                $rows->push($category);
            }
        });

        return $rows;
    }

    protected function getAllUserCollection(): Collection
    {
        $rows = collect();
        User::query()->chunk(100, function ($users) use ($rows) {
            foreach ($users as $user) {
                $rows->push($user);
            }
        });

        return $rows;
    }

    protected function getAllExecutorCollection(): Collection
    {
        $rows = collect();
        User::query()->whereHas('roles',
            function ($q) {
                $q->whereNot('name', 'user');
            }
        )->chunk(100, function ($users) use ($rows) {
            foreach ($users as $user) {
                $rows->push($user);
            }
        });

        return $rows;
    }

    protected function checkWrite(Model $item): void
    {
        $item->check_write = true;
        $item->save();
    }
}
