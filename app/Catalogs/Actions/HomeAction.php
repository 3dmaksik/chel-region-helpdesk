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
use Illuminate\Support\Facades\Notification;

class HomeAction extends Action
{
    private array $helps;

    private ?Model $last = null;

    public User $superAdmin;

    private Carbon $calendar_request;

    private array $dataClear;

    public User $users;

    private string $app_number;

    private SimpleCollection $options;

    private ?string $images = null;

    private ?string $images_final = null;

    /**
     * @return array{method: string, data: mixed}
     */
    public function getWorkerPagesPaginate(): array
    {
        $this->items = Model::where('status_id', '<', config('constants.request.success'))
            ->where('user_id', auth()->user()->id)
            ->orderBy('status_id', 'ASC')
            ->orderByRaw('CASE WHEN calendar_execution IS NULL THEN 0 ELSE 1 END ASC')
            ->orderByRaw('CASE WHEN calendar_warning IS NULL THEN 0 ELSE 1 END ASC')
            ->orderBy('calendar_accept', 'ASC')
            ->paginate($this->page);
        $this->helps =
        [
            'method' => 'workeruser',
            'data' => $this->items,
        ];

        return $this->helps;
    }

    /**
     * @return array{method: string, data: mixed}
     */
    public function getCompletedPagesPaginate(): array
    {
        $this->items = Model::where('status_id', config('constants.request.success'))
            ->where('user_id', auth()->user()->id)
            ->orderBy('calendar_final', 'DESC')
            ->paginate($this->page);
        $this->helps =
        [
            'method' => 'completeduser',
            'data' => $this->items,
        ];

        return $this->helps;
    }

    /**
     * @return array{method: string, data: mixed}
     */
    public function getDismissPagesPaginate(): array
    {
        $this->items = Model::where('status_id', config('constants.request.danger'))
            ->where('user_id', auth()->user()->id)
            ->orderBy('calendar_request', 'DESC')
            ->paginate($this->page);
        $this->helps =
        [
            'method' => 'dismissuser',
            'data' => $this->items,
        ];

        return $this->helps;
    }

    public function create(): SimpleCollection
    {
        $this->items = AllCatalogsDTO::getAllCatalogsCollection();

        return $this->items;
    }

    public function show(int $id): Model
    {
        $this->item = Model::findOrFail($id);
        $this->item->images = json_decode((string) $this->item->images, true, 512, JSON_THROW_ON_ERROR);

        return $this->item;
    }

    public function store(HelpRequest $request): JsonResponse
    {
        $this->last = Model::select('app_number')->orderBy('id', 'desc')->first();
        if ($this->last == null) {
            $this->app_number = GeneratorAppNumberHelper::generate();
        } else {
            $this->app_number = GeneratorAppNumberHelper::generate($this->last->app_number);
        }
        $this->calendar_request = Carbon::now();
        if ($request->hasFile('images')) {
            $this->images = json_encode(StoreFilesHelper::createFileImages($request->file('images'), 'images', 1920, 1080), JSON_THROW_ON_ERROR);
        } else {
            $this->images = $request->file('images');
        }
        if ($request->hasFile('images_final')) {
            $this->images_final = json_encode(StoreFilesHelper::createFileImages($request->file('images_final'), 'images', 1920, 1080), JSON_THROW_ON_ERROR);
        } else {
            $this->images_final = $request->file('images_final');
        }
        $this->options = collect([
            'app_number' => $this->app_number,
            'calendar_request' => $this->calendar_request,
            'images' => $this->images,
            'images_final' => $this->images_final,
        ]);
        $data1 = HelpDTO::storeObjectRequest($request, $this->options);
        if ($data1->user_id == null) {
            $data1->user_id = auth()->user()->id;
        }
        $this->dataClear = $this->clear($data1);
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

    protected function clear(HelpDTO $data): array
    {
        return array_diff((array) $data, ['', null, false]);
    }
}
