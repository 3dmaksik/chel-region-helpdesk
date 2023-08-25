<?php

declare(strict_types=1);

namespace App\Catalogs\Actions;

use App\Base\Actions\Action;
use App\Models\Cabinet;
use App\Models\Help;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\LengthAwarePaginator;

final class SearchCatalogAction extends Action
{
    /**
     * [data model help search]
     *
     * @var helpSearch
     */
    private LengthAwarePaginator $helpSearch;

    /**
     * [data model cabinet search]
     *
     * @var userCabinetSearch
     */
    private Collection $userCabinetSearch;

    /**
     * [data model user search]
     *
     * @var userHelpSearch
     */
    private Collection $userHelpSearch;

    /**
     * [result data]
     *
     * @var searchData
     */
    private array $searchData;

    /**
     * [cabinet user search]
     *
     * @var cabinet
     */
    private ?string $cabinet;

    /**
     * [help user search]
     *
     * @var cabinet
     */
    private ?string $user;

    /**
     * [search help users sent help with role]
     *
     * @return array{method: string, data: Illuminate\Pagination\LengthAwarePaginator}
     */
    public function searchHelpWork(int $id): array
    {
        $this->helpSearch = Help::query()->where('user_id', $id)->RoleSearch()->paginate($this->page);
        $this->searchData =
        [
            'method' => 'searchwork',
            'data' => $this->helpSearch,
        ];

        return $this->searchData;
    }

    /**
     * [search help category sent help with role]
     *
     * @return array{method: string, Illuminate\Pagination\LengthAwarePaginator}
     */
    public function searchHelpCategory(int $id): array
    {
        $this->helpSearch = Help::query()->where('category_id', $id)->RoleSearch()->paginate($this->page);
        $this->searchData =
        [
            'method' => 'searchcategory',
            'data' => $this->helpSearch,
        ];

        return $this->searchData;
    }

    /**
     * [search help cabinet sent help with role]
     *
     * @return array{method: string, data: Illuminate\Pagination\LengthAwarePaginator}
     */
    public function searchHelpCabinet(int $id): array
    {
        $this->helpSearch =
        Help::join('users', 'users.id', '=', 'help.user_id')->RoleSearch()->where('users.cabinet_id', $id)->paginate($this->page);
        $this->searchData =
        [
            'method' => 'searchcabinet',
            'data' => $this->helpSearch,
        ];

        return $this->searchData;
    }

    /**
     * [search cabinet number with 10 limit count]
     */
    public function searchUserCabinet(array $request): JsonResponse
    {
        $this->cabinet = $request['q'] ?? null;
        if ($this->cabinet) {
            $this->userCabinetSearch = Cabinet::query()->where('description', 'LIKE', '%'.$this->cabinet.'%')
                ->orderBy('description', 'ASC')
                ->skip(0)->take(10)->get();
        } else {
            $this->userCabinetSearch = Cabinet::query()
                ->orderBy('description', 'ASC')
                ->skip(0)->take(100)->get();
        }

        return response()->success($this->userCabinetSearch);

    }

    /**
     * [search help user with 10 limit count]
     */
    public function searchUserHelp(array $request): JsonResponse
    {
        $this->user = $request['q'] ?? null;
        if ($this->user) {
            $this->userHelpSearch = User::query()->where('firstname', 'LIKE', '%'.$this->user.'%')
                ->orWhere('lastname', 'LIKE', '%'.$this->user.'%')
                ->orWhere('patronymic', 'LIKE', '%'.$this->user.'%')
                ->orderBy('lastname', 'ASC')
                ->skip(0)->take(10)->get();
        } else {
            $this->userHelpSearch = User::query()
                ->orderBy('lastname', 'ASC')
                ->skip(0)->take(100)->get();
        }

        return response()->success($this->userHelpSearch);

    }

    /**
     * @return array{method: string, data: Illuminate\Pagination\LengthAwarePaginator}
     */
    public function searchHelp(array $request): array
    {
        $item = $request['search'];
        $this->helpSearch = Help::query()->join('users', 'users.id', '=', 'help.user_id')
            ->join('category', 'category.id', '=', 'help.category_id')
            ->join('status', 'status.id', '=', 'help.status_id')
            ->join('cabinet', 'cabinet.id', '=', 'users.cabinet_id')
            ->join('priority', 'priority.id', '=', 'help.priority_id')
            ->RoleSearch()
            ->where('app_number', 'LIKE', '%'.$item.'%')
            ->orWhere('description_long', 'LIKE', '%'.$item.'%')
            ->orWhere('category.description', 'LIKE', '%'.$item.'%')
            ->orWhere('status.description', 'LIKE', '%'.$item.'%')
            ->orWhere('cabinet.description', 'LIKE', '%'.$item.'%')
            ->orWhere('priority.description', 'LIKE', '%'.$item.'%')
            ->orWhere('info', 'LIKE', '%'.$item.'%')
            ->orWhere('info_final', 'LIKE', '%'.$item.'%')
            ->orWhere('users.firstname', 'LIKE', '%'.$item.'%')
            ->orWhere('users.lastname', 'LIKE', '%'.$item.'%')
            ->orWhere('users.patronymic', 'LIKE', '%'.$item.'%')
            ->paginate($this->page);
        $this->helpSearch->appends(['search' => $item]);
        $this->searchData =
        [
            'method' => 'searchcall',
            'data' => $this->helpSearch,
        ];

        return $this->searchData;
    }
}
